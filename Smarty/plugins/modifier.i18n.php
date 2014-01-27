<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty i18n modifier plugin
 *
 * Type:     modifier<br>
 * Name:     i18n<br>
 * Date:     Dec 3, 2003
 * Purpose:  translate a value to a specified language
 * Input:    string to translate
 * Example:  {$var|i18n:"en"}
 * @author   Grinchisihn Vitaliy
 * @version 1.0
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_i18n($string, $module='', $language="")
{
    $lang = Registry::get('lang');
    if(!empty($language)) $lang = $language;
    $i18n = Registry::get('i18n');
    if(!empty($module)){
        
        $value = $i18n->get_translate($lang,$string,$module);
    }else{
        $value = $i18n->get_translate($lang,$string);

    }
    return $value;
}

/* vim: set expandtab: */

?>
