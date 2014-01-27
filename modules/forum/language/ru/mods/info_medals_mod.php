<?php
/***************************************************************************
*
* @package Medals Mod for phpBB3
* @version $Id: medals.php,v 0.7.0 2008/01/23 Gremlinn$
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
// pms
	'PM_MESSAGE'					=> '%1$s' . "\n" . '[b]%3$s наградил вас медалью "%2$s".' . "\n" . '%3$s также отправил вам следующее сообщение:[/b]' . "\n\n",
	'PM_MESSAGE_POINTS_EARN'		=> '<br />Вы заработали %1$s поинт%2$s.' . "\n\n",
	'PM_MESSAGE_POINTS_DEDUCT'		=> '<br />%1$s поинт%2$s был вычислен.' . "\n\n",
	'PM_MESSAGE_NOMINATED'			=> '%1$s' . "\n" . '[b]%3$s наградил вас медалью "%2$s" будучи номинированным на нее %4$s.' . "\n" . '%3$s также отправил вам следующее сообщение:[/b]' . "\n\n",
	'PM_MSG_SUBJECT'				=> '%s наградил вас медалью!',

// medals awarding
	'AWARDED_BY'					=> 'Вручена от',
	'AWARDED_MEDAL'					=> 'Полученные медали',
	'AWARDED_MEDAL_TO'				=> 'Полученные медали за',
	'AWARD_MEDAL'					=> 'Наградить медалью',
	'AWARD_TIME'					=> 'Время награждения',
	'AWARD_TO'						=> 'Вручить медаль',
	'MEDAL_AWARD_GOOD'				=> 'Медаль успешно вручена!<br /><br /><a href="%s">Вернуться на предыдущую страницу</a>',
	'NOT_MEDALS_AWARDED'			=> 'Медаль не может быть вручена следующему(им) пользователю(ям):<br />%s<br /><br /><a href="%s">Вернуться на предыдущую страницу</a>',
	'MEDAL_REMOVE_GOOD'				=> 'Медаль успешно удалена!<br /><br /><a href="%s">Вернуться к предыдущей странице</a>',
	'MEDAL_EDIT'					=> 'Редактировать',

// medals nominate
	'APPROVE'						=> 'Одобрить',
	'USER_NOMINATED'				=> 'Пользователь номинирован',
	'USER_IS_NOMINATED'				=> ' [<a href="%s" title="Этот пользователь номинирован на медаль!">!</a>]',
	'MEDAL_NOMINATE_GOOD'			=> 'Медаль успешно номинирована!<br /><br /><a href="%s">Вернуться к предыдущей странице</a>',
	'NOMINATABLE'					=> '[Номинации]',
	'NOMINATE'						=> 'Номинировать медаль',
	'NOMINATE_FOR'					=> 'Номинировать медаль за',
	'NOMINATE_MEDAL'				=> 'Управление номинированием',
	'NOMINATE_MESSAGE'				=> '<b>%1$s номинировал этого пользователя на медаль "%2$s" по следующей причине:</b>' . "\n\n",
	'NOMINATE_USER_LOG'				=> 'Управление номинациями за %s',
	'NOMINATED_BY'					=> '[Номинирован %s]',
	'NOMINATED_EXPLAIN'				=> 'Могут пользователи номинировать других пользователей на эту медаль?',
	'NOMINATED_TITLE'				=> 'Номинации медалей',
	'NO_MEDALS_NOMINATED'			=> 'Медаль не вручалась',
	'NOMINATIONS_REMOVE_GOOD'		=> 'Номинации успешно удалены!<br /><br /><a href="%s">Вернуться к предыдущей странице</a>',

// Images
	'IMAGE_PREVIEW'					=> 'Обзор',
	'MEDAL_IMG'						=> 'Изображение',

// medals view
	'MEDAL'							=> 'Медаль',
	'MEDALS'						=> 'Медали',
	'MEDALS_VIEW_BUTTON'			=> 'Просмотреть детали',
	'MEDALS_VIEW'					=> 'Медали',
	'MEDAL_DETAIL'					=> 'Детали медали',
	'MEDAL_DESCRIPTION'				=> 'Описание медали',
	'MEDAL_DESC'					=> 'Описание',
	'MEDAL_AWARDED'					=> 'Получатели',
	'MEDAL_AWARDED_EXPLAIN'			=> '<br>Нажмите на имени пользователя, чтобы управлять его медалями',
	'MEDAL_AWARD_REASON'			=> 'Причина награждения',
	'MEDAL_AWARD_REASON_EXPLAIN'	=> '<br>Введите причину награждения этой медалью.',
	'MEDAL_AWARD_USER_EXPLAIN'		=> '<br>Введите пользователей чтобы вручить им эту медаль (каждое имя на отдельной строке.',
	'MEDAL_INFORMATION'				=> 'Информация о медали',
	'MEDAL_INFO'					=> 'Информация',
	'MEDAL_MOD'						=> 'Наградить',
	'MEDAL_NAME'					=> 'Имя',
	'NO_MEDALS_ISSUED'				=> 'Медаль не назначена',
	'MEDAL_CP'						=> 'Центр управления медалями',
	'MEDAL_NOM_BY'					=> 'Вручил',
	'MEDAL_AMOUNT'					=> 'Количество',

// Error messages
	'CANNOT_AWARD_MULTIPLE'			=> 'Этот пользователь награжден максимально возможным числом наград.<br /><br /><a href="%s">Вернуться на предыдущую страницу</a>',
	'IMAGE_ERROR'					=> 'Вы не можете выбрать эту медаль для награждения',
	'IMAGE_ERROR_NOM'				=> 'Вы не можете выбрать эту медаль для номинации',
	'NO_CAT_ID'						=> 'Не выбрано ID категории.',
	'NO_CATS'						=> 'Нет категорий',
	'NO_GOOD_PERMS'					=> 'Вы не имеете необходимых полномочий для доступа на эту страницу.<br /><br /><a href="index.php">Вернуться на форум</a>',
	'NO_MEDAL_ID'					=> 'Не выбрано ID медали',
	'NO_MEDAL_MSG'					=> 'Поле сообщения пусто.<br /><br /><a href="%s">Вернуться на предыдущую страницу</a>',
	'NO_MEDALS'						=> 'Нет медалей',
	'NO_MEDALS_TO_NOMINATE'			=> 'Нет доступных медалей для номинации этого пользователя<br /><br /><a href="%s">Вернуться на предыдущую страницу</a>',
	'NO_USER_ID'					=> 'Не выбрано ID пользователя',
	'NO_USER_MEDALS'				=> 'Этот пользователь не был награжден никакими медалями',
	'NO_USER_NOMINATIONS'			=> 'Этот пользователь не был номинирован ни на какие медали',
	'NO_SWAP_ID'					=> 'Не выбрано ID обмена',
	'NOT_SELF'						=> 'Вы не можете номинировать себя',

));

?>