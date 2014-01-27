<?php

/*------------------------------------------------------*/
/* CREATED BY nvvetal 2006 Sat Jun 24 12:25:01 EEST 2006		
/* USING FOR: generating trees with checkboxes	
/*------------------------------------------------------*/
function smarty_function_html_tester_tree_checkboxes($params, &$smarty)
{
	if(!isset($params["tree_check_all"])){
		$tree_check_all=false;
	}else{
		$tree_check_all=$params["tree_check_all"];
	}	
	
	if(!isset($params["tree_test_name"])){
		$tree_test_name="test";
	}else{
		$tree_test_name=$params["test_name"];
	}
	
	if(!isset($params["have_overlib"])){
		$have_overlib=false;
	}else{
		$have_overlib=$params["have_overlib"];
	}	
	
	if(!isset($params["tree_id"])){
		$tree_id="tree";
	}else{
		$tree_id=$params["tree_id"];
	}	
	
	if(!isset($params["tree_dir"])){
		$tree_dir="";
	}else{
		$tree_dir=$params["tree_dir"];
	}
	
	if(!isset($params["show_max_items"])){
		$params["show_max_items"]=false;
	}	
	
	$tree_script="";

	$tree_value="
		<A href=\"#\" onClick=\"expandTree('$tree_id'); return false;\">Expand All</A>&nbsp;&nbsp;&nbsp;
		<A href=\"#\" onClick=\"collapseTree('$tree_id'); return false;\">Collapse All</A>&nbsp;&nbsp;&nbsp;
		<A href=\"#\" onClick=\"check_all_tests(true);set_all_max();recount_all_chapters_and_tests();return false;\">Check All</A>&nbsp;&nbsp;&nbsp;
		<A href=\"#\" onClick=\"check_all_tests(false);zero_max();recount_all_chapters_and_tests();return false;\">Uncheck All</A>&nbsp;&nbsp;&nbsp;
		<input type=\"text\" name=\"check_by_count\" id=\"check_by_count\" value=\"100\" style=\"width:40px;\"><A href=\"#\" onClick=\"check_tests_by_count(document.getElementById('check_by_count').value);recount_all_chapters_and_tests();return false;\">Check by count</A>&nbsp;&nbsp;&nbsp;

	";

	if(!is_array($params["tree"])){
		
		return "Chapters and tests not setted for this profession!";
	}
	//reset($params["tree"]);
	//print_r($params["tree"]);
	reset($params["tree"]);
	$tree_script.="<script type=\"text/javascript\">\n";
	$tree_value.="<ul class=\"mktree\" id=\"$tree_id\">\n";
	#chapters
	while(list($key,)=each($params["tree"])){
			
		$chapter_id=$params["tree"]["$key"]["id"];
		$max_tests=$params["tree"]["$key"]["max_tests"];

		$tree_script.="var chapterGroup$chapter_id = new CheckBoxGroup();\n";

		
		$can_check_chapter=true;
		#tests
		$tests=$params["tree"]["$key"]["tests"];
		$max_count=count($params["tree"]["$key"]["tests"]);
		$items_count=0;
		reset($tests);
		$test_tree_value="";
		while(list($key2,)=each($tests)){
			$test_id=$tests["$key2"]["id"];
			$test_full_name=$tests["$key2"]["test"];
			$test_name=htmlspecialchars($tests["$key2"]["test"]);
			if(strlen($test_name)>70){
				$test_name=substr($test_name,0,70)."...";
			}
			
			if($tree_check_all==true){
				$items_count++;
				$is_checked=" checked";
			}else{
				if($tests["$key2"]["selected"]==1){
					$items_count++;
					$is_checked=" checked";
				}else{
					$is_checked="";
				}
				if($tests["$key2"]["selected"]==0){
					$can_check_chapter=false;
				}
			}
			
			if($have_overlib){
				
				$popup=" onmouseover=\"return overlib('".trim(htmlspecialchars($test_full_name))."',CAPTION,'Full text',FGCOLOR,'white');\" onmouseout=\"nd();\"";
				
			}else{
				$popup="";
			}
			
			$test_tree_value.="<li$popup><INPUT TYPE=\"checkbox\" NAME=\"$tree_test_name"."[$test_id]\" chapter_id=\"$chapter_id\" VALUE=\"$test_id\" onclick=\"chapterGroup$chapter_id.check(this,$chapter_id);recount_max_chapter_tests($chapter_id);recount_all_chapters_and_tests();\" $is_checked />$test_name</li>\n";
			$tree_script.="chapterGroup$chapter_id.addToGroup(\"$tree_test_name"."[$test_id]\");\n";
		}
		/*
		if($tree_check_all==true){
			$chapter_is_checked=" checked";
		}else{
			if($can_check_chapter){
				$chapter_is_checked=" checked";
			}else{
				$chapter_is_checked="";
			}
		}
		*/
		if($items_count>0){
			$chapter_is_checked=" checked";
		}else{
			$chapter_is_checked="";
		}
		if($params["show_max_items"]){
			if(!empty($max_tests))$items_count=$max_tests;
		}
					
		$tree_value.="<li><INPUT TYPE=\"checkbox\" NAME=\"chapter"."$chapter_id"."_all\" chapter_id=\"$chapter_id\" VALUE=\"all\" onclick=\"chapterGroup$chapter_id.check(this,$chapter_id);recount_max_chapter_tests($chapter_id);recount_all_chapters_and_tests();\" $chapter_is_checked/>Chose <input id=\"chose[$chapter_id]\" s_type=\"chose\" chapter_id=\"$chapter_id\" type=\"text\" name=\"chose[$chapter_id]\" value=\"$items_count\" style=\"width:50;\" onkeyup=\"check_max_tests_count($chapter_id);recount_all_chapters_and_tests();\" />Max ".sprintf("%03d",$max_count)." <font color=\"blue\">{$params["tree"]["$key"]["name"]}</font>\n";
		$tree_value.="<ul>\n";
		
		$tree_value.=$test_tree_value;			
		$tree_value.="</ul>\n";
		
		$tree_script.="chapterGroup$chapter_id.setControlBox(\"chapter"."$chapter_id"."_all\");\n";

		$tree_value.="</li>\n";
		$tree_script.="chapterGroup$chapter_id.setMasterBehavior(\"some\");\n";
		
	}
	
	$tree_script.="</script>\n";
	$tree_value.="</ul>\n";
	$tree=$tree_script.$tree_value;
	
	return $tree;
}//end function smarty_function_html_tree_checkboxes
?>