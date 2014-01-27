<?php
/***************************************************************************
*
* @package Medals Mod for phpBB3
* @version $Id: medals.php,v 0.7.0 2008/01/14 Gremlinn$
* @copyright (c) 2008 Nathan DuPra (mods@dupra.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
***************************************************************************/

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'IMG_ICON_POST_APPROVE'			=> 'Одобрить',
	'ACP_MEDALS_INDEX'				=> 'ACP медалей',
	'ACP_MEDALS_INDEX_EXPLAIN'		=> 'Medals Index Explain',
	'ACP_MEDALS_TITLE'				=> 'Управление медалями',
	'ACP_MEDALS_SETTINGS'			=> 'Конфигурация',

	'MEDALS_MOD_INSTALLED'			=> 'Установлен мод медалей версии %s',
	'MEDALS_MOD_UPDATED'			=> 'Мод медалей обновлен до версии %s',
	'MEDALS_MOD_MANUAL'				=> 'Вы пользуетесь устаревшей версией мода медалей.<br />Вам нужно сначала деинсталлировать эту версию<br />Для начала убедитесь что вы сделали запасные копии файлов.',

	'acl_u_award_medals'			=>  array('lang' => 'Можно наградить медалями пользователей', 'cat' => 'misc'),
	'acl_a_manage_medals'			=>  array('lang' => 'Можно использовать модуль настройки медалей', 'cat' => 'misc'),

// Medals Management
	'ACP_MEDAL_MGT_TITLE'				=> 'Настройка медалей',
	'ACP_MEDAL_MGT_DESC'				=> 'Здесь вы можете смотреть, создавать, изменять и удалять категории медалей',

	'ACP_MEDALS'						=> 'Медали',
	'ACP_MEDALS_DESC'					=> 'Здесь вы можете смотреть, создавать, изменять и удалять медали этой категории.',
	'ACP_MULT_TO_USER'					=> 'Число награждений пользователя',
	'ACP_USER_NOMINATED'				=> 'Пользователь был номинирован',
	'ACP_MEDAL_LEGEND'					=> 'Медаль',
	'ACP_MEDAL_TITLE_EDIT'				=> 'Редактировать медаль',
	'ACP_MEDAL_TEXT_EDIT'				=> 'Изменить существующую медаль',
	'ACP_MEDAL_TITLE_ADD'				=> 'Создать медаль',
	'ACP_MEDAL_TEXT_ADD'				=> 'Создать новую медаль с нуля',
	'ACP_MEDAL_DELETE_GOOD'				=> 'Медаль успешно удалена.<br /><br /> Нажмите <a href="%s">здесь</a> для возврата к предыдущей категории',
	'ACP_MEDAL_EDIT_GOOD'				=> 'Медаль успешно обновлена.<br /><br /> Нажмите <a href="%s">здесь</a> для перехода к категории медали',
	'ACP_MEDAL_ADD_GOOD'				=> 'Медаль успешно добавлена.<br /><br /> Нажмите <a href="%s">здесь</a> для перехода к категории медали',
	'ACP_CONFIRM_MSG_1'					=> 'Вы уверены что хотите удалить эту медаль? При этом вы удалите эту медаль у всех пользователей, которые были ею награждены. <br /><br /><form method="post"><fieldset class="submit-buttons"><input class="button1" type="submit" name="confirm" value="Да" />&nbsp;<input type="submit" class="button2" name="cancelmedal" value="Нет" /></fieldset></form>',
	'ACP_NAME_TITLE'					=> 'Название медали',
	'ACP_NAME_DESC'						=> 'Описание медали',
	'ACP_IMAGE_TITLE'					=> 'Изображение медали',
	'ACP_IMAGE_EXPLAIN'					=> 'Изображение для медали в формате gif в папке images/medals/ ',
	'ACP_DEVICE_TITLE'					=> 'Изображение устройства',
	'ACP_DEVICE_EXPLAIN'				=> 'Базовое имя изображения в формате gif в папке images/medals/devices, для возможности динамического создания медалей.<br /> Например устройство-2.gif = устройство',
	'ACP_PARENT_TITLE'					=> 'Категория медали',
	'ACP_PARENT_EXPLAIN'				=> 'Категория, в которую помещена медаль',
	'ACP_DYNAMIC_TITLE'					=> 'Динамическое изображение медали',
	'ACP_DYNAMIC_EXPLAIN'				=> 'Динамическое создание изображений для многих награждений.',
	'ACP_NOMINATED_TITLE'				=> 'Номинации медали',
	'ACP_NOMINATED_EXPLAIN'				=> 'Могут пользователи номинировать других пользователей на эту медаль?',
	'ACP_CREATE_MEDAL'					=> 'Создать медаль',
	'ACP_NO_MEDALS'						=> 'Нет медалей',
	'ACP_NUMBER'						=> 'Количество награждений',
	'ACP_NUMBER_EXPLAIN'				=> 'Установить сколько раз эта медаль может быть вручена пользователю.',
	'ACP_POINTS'						=> 'Поинты',
	'ACP_POINTS_EXPLAIN'				=> 'Установить как поинты зарабатываются (или отнимаются) для получения этой медали.<br />Также работает с модом Simple Points Mod.',

	'ACP_MEDALS_MGT_INDEX'				=> 'Категории медалей',
	'ACP_MEDAL_TITLE_CAT'				=> 'Редактировать категорию',
	'ACP_MEDAL_TEXT_CAT'				=> 'Изменить существующую категорию',
	'ACP_MEDAL_LEGEND_CAT'				=> 'Категория',
	'ACP_NAME_TITLE_CAT'				=> 'Название категории',
	'ACP_CREATE_CAT'					=> 'Создать категорию',
	'ACP_CAT_ADD_FAIL'					=> 'Не перечислены названия категорий для добавления.<br /><br /> Нажмите <a href="%s">здесь</a> для возврата к списку категорий',
	'ACP_CAT_ADD_GOOD'					=> 'Категория была успешно добавлена.<br /><br /> Нажмите <a href="%s">здесь</a> для возврата к списку категорий',
	'ACP_CAT_EDIT_GOOD'					=> 'Категория была успешно отредактирована.<br /><br /> Нажмите <a href="%s">здесь</a> для возврата к списку категорий',
	'ACP_CAT_DELETE_CONFIRM'			=> 'В какую категорию вы хотите переместить все медали из данной категории после ее удаления? <br /><form method="post"><fieldset class="submit-buttons"><select name="newcat">%s</select><br /><br /><input class="button1" type="submit" name="moveall" value="Переместить все медали" />&nbsp;<input class="button2" type="submit" name="deleteall" value="Удалить все медали" />&nbsp;<input type="submit" class="button2" name="cancelcat" value="Отменить удаление" /></fieldset></form>',
	'ACP_CAT_DELETE_CONFIRM_ELSE'		=> 'Нет других категорий для перемещения этих медалей.<br />Вы уверены что хотите удалить эту категорию и все ее медали?<br /><form method="post"><fieldset class="submit-buttons"><br /><input class="button2" type="submit" name="deleteall" value="Да" />&nbsp;<input type="submit" class="button2" name="cancelcat" value="Нет" /></fieldset></form>',
	'ACP_CAT_DELETE_GOOD'				=> 'Эта категория, все ее содержимое, и все ее содержимое, которое было вручено, было успешно удалено<br /><br /> Нажмите <a href="%s">здесь</a> для возврата к списку категорий',
	'ACP_CAT_DELETE_MOVE_GOOD'			=> 'Все медали из "%1$s" были перемещены в "%2$s" и категория успешно удалена.<br /><br /> Нажмите <a href="%3$s">здесь</a> для возврата к списку категорий',
	'ACP_NO_CATS'						=> 'Нет категорий',

// Medals Configuration
	'ACP_CONFIG_TITLE'					=> 'Конфигурации медалей',
	'ACP_CONFIG_DESC'					=> 'Здесь вы можете установить настройки для мода медалей ',
	'ACP_MEDALS_CONF_SETTINGS'			=> 'Настройки конфигурации медалей',
	'ACP_MEDALS_CONF_SAVED'				=> 'Конфигурации медалей сохранены<br /><br /> Нажмите <a href="%s">здесь</a> для перехода к ACP конфигурации медалей',
	'ACP_MEDALS_SM_IMG_WIDTH'			=> 'Ширина изображения иконки медали',
	'ACP_MEDALS_SM_IMG_WIDTH_EXPLAIN'	=> 'Ширина (в пикселях) для отображения медалей на страницах форума и в профилях пользователей.<br />Введите 0 чтобы не менять ширину.',
	'ACP_MEDALS_SM_IMG_HT'				=> 'Высота изображения иконки медали',
	'ACP_MEDALS_SM_IMG_HT_EXPLAIN'		=> 'Высота (в пикселях) для отображения медалей на страницах форума и в профилях пользователей.<br />Введите 0 чтобы не менять высоту.',
	'ACP_MEDALS_VT_SETTINGS'			=> 'Настройки отображения в темах',
	'ACP_MEDALS_TOPIC_DISPLAY'			=> 'Отображение медалей на страницах тем',
	'ACP_MEDALS_TOPIC_ROW'				=> 'Число медалей по горизонтали',
	'ACP_MEDALS_TOPIC_ROW_EXPLAIN'		=> 'Число медалей, отображаемых в темах по горизонтали.',
	'ACP_MEDALS_TOPIC_COL'				=> 'Число медалей по вертикали',
	'ACP_MEDALS_TOPIC_COL_EXPLAIN'		=> 'Число медалей, отображаемых в темах по вертикали.',
	'ACP_MEDALS_PROFILE_ACROSS'			=> 'Медали, отображаемые в профиле по горизонтали',
	'ACP_MEDALS_PROFILE_ACROSS_EXPLAIN'	=> 'Число медалей, отображаемых в профиле по горизонтали.',

));

?>