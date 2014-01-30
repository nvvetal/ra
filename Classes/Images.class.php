<?php

class Images {


    var $rules;
    var $dbh;
    var $imagemagick;

    function Images($dbh,$imagemagick,$rules){

        $this->rules 		= $rules;
        $this->dbh 			= $dbh;
        $this->imagemagick 	= $imagemagick;
    }
	
	function copy_image($fromFileName, $pathOriginal)
	{
		$pathInfo 	= pathinfo($fromFileName);
		$data 		= $this->make_image_path($pathOriginal);		
		$destFile 	= $pathOriginal.$data['path'].'/'.$data['name'].'.'.$pathInfo['extension'];
		add_to_log("[from $fromFileName][to $destFile]", 'copy_log');
		copy($fromFileName, $destFile);

		chmod($destFile, 0644);
        $params=array(
        	"path"			=> $data['path'],
            "image"			=> array('type'=> $this->get_type_by_extension($pathInfo['extension'])),
            "name"			=> $data['name'],
            "uploadfile"	=> $destFile,
            "path_original"	=> $pathOriginal,
         );
         $image_id = $this->prepare_image($params);
         return array(
            "res"   =>  true,
            "ID"    =>  $image_id,            
         );
         		
	}
	
	function make_image_path($pathOriginal)
	{
        $dir = substr(md5(mt_rand()),0,3);
        $name = md5(microtime(true).mt_rand(0,10000000));
        $path = "$dir/$name";
        $this->prepare_images_path($pathOriginal."$dir/");
        $this->prepare_images_path($pathOriginal."$path/");
       	return array(
			'path' 	=> $path,
			'dir'	=> $dir,
			'name'	=> $name,
		);
	}

    function upload_image($image,$path_original,$rule_name){
        $is_valid = $this->check_image($image,'upload');
        $is_uploaded = false;
		$data 	= $this->make_image_path($path_original);
		$path 	= $data['path'];
		$dir 	= $data['dir'];
		$name	= $data['name'];
        list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);
        $ext = '';
        switch($type){
            case IMAGETYPE_GIF:
                $ext = 'gif';
                break;
            case IMAGETYPE_JPEG:
            case IMAGETYPE_JPEG2000:
                $ext = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $ext = 'png';
                break;
        }
        $fname = $name.'.'.$ext;
        $uploadfile = $path_original."$path/" . $fname;
        $image_id = 0;
        if($is_valid){
            
            if(move_uploaded_file($image['tmp_name'], $uploadfile)){
                $is_uploaded = true;
                $params=array(
                	"path"=>$path,
                	"image"=>$image,
                	"name"=>$name,
                	"uploadfile"=>$uploadfile,
                	"path_original"=>$path_original,
                );
                $image_id = $this->prepare_image($params);
            }else{
                add_to_log("[err can't move uploaded file][tmp_name {$image['tmp_name']}][new_name $uploadfile]","error_image_upload");
            }
        }else{
            add_to_log("[err image is not valid][tmp_name {$image['tmp_name']}]","error_image_upload");
        }
        return array(
            "res"=>$is_uploaded,
            "ID"=>$image_id,
        );
    }

    function prepare_image($params){
        $fields = array(
            "owner_id"=>0,
            "owner_type"=>"unknown",
            "path"=>$params['path'],
            "img_type"=>$params['image']['type'],
            "fname"=>$params['name'],
        );
        SQLInsert("images",$fields,$this->dbh);
        $image_id = SQLInsId($this->dbh);
		$index = '';
		if(preg_match("/\.gif/i", $params['uploadfile'])) $index = "[0]";
        $ret = @system("{$this->imagemagick}convert {$params['uploadfile']}$index -quality 95 ".$params['path_original']."{$params['path']}/".$params['name'].".png",$convert_result);
        add_to_log("[ID $image_id][res $convert_result][ret $ret]","image_convert");
        $h = fopen($params['path_original']."{$params['path']}/".$params['name'].".dat","w");
        if($h){
            $fields['ID'] = $image_id;
            $fields['approve_state'] = 0;
            $fields['is_public'] = 0;
            fwrite($h,serialize($fields));
        }
        fclose($h);
        return $image_id;
    }

    function assign_image($image_id,$owner_id,$owner_type){
        $fields = array(
        	"owner_id"		=> $owner_id,
        	"owner_type"	=> $owner_type,
        );
        SQLUpdate("images",$fields,"WHERE id=".SQLQuote($image_id),$this->dbh);
    }

    function check_image($image,$rule_name){
        $rule = $this->get_rule($rule_name);
        if( $rule === false) return false;

        //echo "rule ok";
        if( $image['size'] >= $rule['size'] ) return false;
        //echo "size ok";
        if( !isset( $rule['img_types'][$image['type']] )) return false;
        return true;
    }

    function get_rule($rule_name){
        if(!isset($this->rules[$rule_name])) return false;
        return $this->rules[$rule_name];

    }

    function prepare_images_path($path){
        if(!@dir($path)){
        	$res = mkdir($path);
			chmod($path, 0777);
            return $res;
        }
        return true;
    }

    function get_image_extension_by_type($type){
        $type = strtolower($type);

        $ext = 'none';
        switch ($type){
            case "image/gif":
            $ext = 'gif';
            break;

            case "image/jpeg":
            $ext = 'jpg';
            break;
            
            case "image/png":
            $ext = 'png';
            break;			
        }

        return $ext;
    }


    function get_type_by_extension($ext){
        $ext = strtolower($ext);

        $type = "image/unknown";

        switch ($ext){
            case "gif":
            $type = "image/gif";
            break;

            case "jpg":
            $type = "image/jpeg";
            break;
			
            case "png":
            $type = "image/png";
            break;
        }

        return $type;
    }


    function get_image_url($ID,$w,$h,$ext){
        $query="
			SELECT *
			FROM images
			WHERE id=".SQLQuote($ID)." AND approve_state <> 2
			LIMIT 1
		";
        $row = SQLGet($query,$this->dbh);
        $url = false;
        if($row !== false){
            $url = "{$row["path"]}/".$ID."_".$w."_".$h.".".$ext;
        }
        return $url;
    }

    function get_image_url_main_h($ID, $maxH, $ext){
        $query="
            SELECT *
            FROM images
            WHERE id=".SQLQuote($ID)." AND approve_state <> 2
            LIMIT 1
        ";
        $row = SQLGet($query,$this->dbh);
        $url = false;
        if($row !== false){
            $url = "{$row["path"]}/maxh_".$ID."_".$maxH.".".$ext;
        }
        return $url;        
    }
	
    function get_image_url_center_square($ID, $width, $ext){
        $query="
            SELECT *
            FROM images
            WHERE id=".SQLQuote($ID)." AND approve_state <> 2
            LIMIT 1
        ";
        $row = SQLGet($query, $this->dbh);
        //var_dump($row);exit;
        $url = false;
        if($row !== false){
            $url = "{$row["path"]}/scenter_".$ID."_".$width.".".$ext;
        }
        return $url;        
    }	

    function get_image_data($path_original,$path_s,$path_b){
        $data = unserialize(file_get_contents($path_original."$path_s/$path_b/$path_b.dat"));

        return $data;
    }
    
    function get_original_image_size($imageId, $pathOriginal)
    {
        $query = "
            SELECT *
            FROM images
            WHERE id = ".SQLQuote($imageId)."
        ";

        $data = SQLGet($query,$this->dbh);

        if($data === false) return false;        
        list($width, $height, $type, $attr) = getimagesize($pathOriginal.$data['path'].'/'.$data['fname'].'.png');
        return array(
            'width' => $width,
            'height' => $height,
        );
    }

    function show_image($filename,$type){
        if(!file_exists($filename)) {
        	add_to_log("[error no file][filename $filename][type $type]",'image');
        	return '';
		}
        $imagedata = file_get_contents($filename);
        $length = strlen($imagedata);
        header('Last-Modified: '.date('r'));
        header('Accept-Ranges: bytes');
        header('Content-Length: '.$length);
        header('Content-Type: '.$type);
	header("Cache-Control: max-age=3600");
        echo $imagedata;
    }


    function cache_image($original_image,$cache_image,$w,$h){
        if(!file_exists($original_image)){
            add_to_log("[error cannot find file][original $original_image]","error_image_convert_cache");
            return false;
        }
		$index = '';
		if(preg_match("/\.gif/i", $original_image)) $index = "[0]";		
        $convert_cmd = "{$this->imagemagick}convert $original_image".$index." -resize $w"."x"."$h -quality 95 $cache_image";
        $ret = @system($convert_cmd,$convert_result);
        add_to_log("[cmd $convert_cmd][original $original_image][cache $cache_image][res $convert_result][ret $ret]","image_convert_cache");
        return true;
    }
    
    function cache_image_main_h($original_image, $cache_image, $maxH){
        if(!file_exists($original_image)){
            add_to_log("[error cannot find file][original $original_image]","error_image_convert_cache");
            return false;
        }
        $size   = getimagesize($original_image);
        $percent = ceil($maxH / $size[1] * 100);      
		$index = '';
		if(preg_match("/\.gif/i", $original_image)) $index = "[0]";		        
        $convert_cmd = "{$this->imagemagick}convert $original_image".$index." -resize ".$percent."% -quality 95 $cache_image";
        $ret = @system($convert_cmd,$convert_result);
        add_to_log("[cmd $convert_cmd][original $original_image][cache $cache_image][res $convert_result][ret $ret]","image_convert_cache");
        return true;
    } 
    
    function cache_image_center_square($original_image, $cache_image, $width){
        if(!file_exists($original_image)){
            add_to_log("[error cannot find file][original $original_image]","error_image_convert_cache");
            return false;
        }
        $size   	= getimagesize($original_image);
        $maxWidth 	= $size[0];
		$maxHeight 	= $size[1];
        $wStart 	= ceil(($maxWidth - $width) / 2); 
		$hStart 	= ceil(($maxHeight - $width) / 2);
		$wStart     = 0;
        $hStart     = 0;
		
		$pWidth     = ceil($width / $maxWidth * 100); 
		$pHeigth    = ceil($width / $maxHeight * 100); 
        $percent    = ($pWidth > $pHeigth) ? $pWidth : $pHeigth;
		$index = '';
		if(preg_match("/\.gif/i", $original_image)) $index = "[0]";        
        $convert_cmd = "{$this->imagemagick}convert $original_image".$index." -resize ".$percent."% -crop ".$width."x".$width."+".$wStart."+".$hStart." +repage -quality 95 $cache_image";
        $ret = @system($convert_cmd,$convert_result);
        add_to_log("[cmd $convert_cmd][original $original_image][cache $cache_image][res $convert_result][ret $ret]","image_convert_cache");
        return true;
    }       

    function delete_image($image_id,$path_original){
        $query = "
		  SELECT *
		  FROM images
		  WHERE id = ".SQLQuote($image_id)."
	    ";

        $data = SQLGet($query,$this->dbh);

        if($data === false) return false;

        $query = "DELETE FROM images WHERE id=".SQLQuote($image_id);
        SQLQuery($query,$this->dbh);

        if ($handle = opendir($path_original."{$data['path']}")) {
            while (false !== ($file = readdir($handle))) {
                if(preg_match("/^".$data['fname']."./i",$file)) {
                    unlink($path_original."{$data['path']}/".$file);
                    add_to_log("[id $image_id][file $file]","image_delete");
                }
            }

            closedir($handle);
        }

    }

}

?>