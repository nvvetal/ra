<?php
$module_name = "shop";
require_once("../../lib/config.php");
set_time_limit(500);
$dir = $GLOBALS['PROJECT_ROOT'].'/internal/shop_vetal/';
$DBFactory = Registry::get('DBFactory');
$dbh = $DBFactory->get_db_handle('rakscom');

$Images = Registry::get('Images');
if(!is_dir($dir)){
    die($dir.' is not dir!');
}
try {
    $dh = opendir($dir);
    while (($file = readdir($dh)) !== false) {
        $category = $dir.'/'.$file;
        $categoryName = $file;
        if(!is_dir($category) || $file == '.' || $file == '..') continue;
        $shopCategory = new ShopCategory($dbh);
        $data = array(
            'name'      => iconv('cp1251','utf-8',$categoryName),
            'shop_id'   => 1,
            'is_enabled'=> 'Y',
        );
        $res = $shopCategory->create($data);
        if($res['ok'] == false) continue; 
        $categoryId = $res['id'];
        $dh2 = opendir($category);
        while (($file2 = readdir($dh2)) !== false) {
            $pricePath = $category.'/'.$file2;
            $price = $file2;
            if(!is_dir($pricePath) || $file2 == '.' || $file2 == '..') continue; 
            
            $dh3 = opendir($pricePath);   
            while (($file3 = readdir($dh3)) !== false) {
                $fileName = $pricePath.'/'.$file3;
                //echo $fileName;
                if(!is_file($fileName)) continue;
                $res = $Images->copy_image($fileName, $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']);
                if($res['res'] != true) continue;
                $imageId = $res['ID'];                        
                $shopItem = new ShopGood($dbh);
                $data = array(
                    'name'          => '',
                    'image_id'      => $imageId,
                    'category_id'   => $categoryId,
                    'price'         => iconv('cp1251','utf-8',$price),
                    'is_enabled'    => 'Y',
                );
                $res = $shopItem->create($data);
                $Images->assign_image($imageId, $res['id'], 'shop_item');
            }            
            closedir($dh3);
        }
        closedir($dh2);                                     
    }

    closedir($dh);
}catch(Exception $e){
    exception_handler($e);        
}
