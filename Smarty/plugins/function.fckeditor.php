<?php

/*------------------------------------------------------*/
/* CREATED BY nvvetal 2006 Sat Jun 24 12:25:01 EEST 2006		
/* USING FOR: generating trees with checkboxes	
/*------------------------------------------------------*/
function smarty_function_fckeditor($params, &$smarty)
{

	require_once("../../../FCKeditor/fckeditor.php") ;
	
	$value="";
	$sBasePath=$params["path"];
	//$sBasePath = "/tester/FCKeditor/" ;

	if(isset($params["name"])){
		$oFCKeditor[$params["name"]] = new FCKeditor($params["name"]) ;
		$oFCKeditor[$params["name"]]->BasePath	= $sBasePath ;
		$oFCKeditor[$params["name"]]->Value		= $params["value"] ;
		$value=$oFCKeditor[$params["name"]]->CreateHtml() ;
	}
	return $value;
}//end function smarty_function_html_tree_checkboxes
?>