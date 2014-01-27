<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty capitalize modifier plugin
 *
 * Type:     modifier<br>
 * Name:     capitalize<br>
 * Purpose:  capitalize words in the string
 * @link http://smarty.php.net/manual/en/language.modifiers.php#LANGUAGE.MODIFIER.CAPITALIZE
 *      capitalize (Smarty online manual)
 * @param string
 * @return string
 */
function smarty_modifier_substr($string,$begin=0,$length=2)
{
	return mb_substr($string,$begin,$length,'UTF-8');
}



?>
