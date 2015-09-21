<?php
/**
*
* acp_groups [Russian]
*
* @package language
* @version $Id: groups.php,v 1.28 2007/07/02 14:05:21 kellanved Exp $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
   exit;
}

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
	'ACP_GROUPS_MANAGE_EXPLAIN'		=> 'C помощью этой панели вы можете управлять всеми группами пользователей. Вы можете удалять их, создавать новые и редактировать существующие. Кроме того, вы можете назначать лидеров, изменять открытый/скрытый/закрытый статус групп, а также задавать названия и описания групп.',
	'ADD_USERS'						=> 'Добавление пользователей',
	'ADD_USERS_EXPLAIN'				=> 'Здесь вы можете добавлять новых пользователей в группу. Вы можете выбрать, станет ли эта группа группой по умолчанию для выбранных пользователей. Также здесь же можно назначать лидеров группы. Вводите имя каждого пользователя на новой строке.',

	'COPY_PERMISSIONS'				=> 'Копировать права доступа из группы',
	'COPY_PERMISSIONS_EXPLAIN'		=> 'После создания группа будет иметь те же права доступа, что и выбранная здесь.',
	'CREATE_GROUP'					=> 'Создать группу',

	'GROUPS_NO_MEMBERS'				=> 'В этой группе нет пользователей',
	'GROUPS_NO_MODS'				=> 'Лидеры группы не назначены',

	'GROUP_APPROVE'					=> 'Принять кандидата в группу',
	'GROUP_APPROVED'				=> 'Участники группы',
	'GROUP_AVATAR'					=> 'Аватара группы',
	'GROUP_AVATAR_EXPLAIN'			=> 'Этот рисунок будет отображаться в панели управления группой.',
	'GROUP_CLOSED'					=> 'Закрытая',
	'GROUP_COLOR'					=> 'Цвет группы',
	'GROUP_COLOR_EXPLAIN'			=> 'Цвет имён пользователей — участников группы. Оставьте поле пустым для использования цвета по умолчанию.',
	'GROUP_CONFIRM_ADD_USER'		=> 'Вы уверены, что желаете добавить пользователя %1$s в группу?',
	'GROUP_CONFIRM_ADD_USERS'		=> 'Вы уверены, что желаете добавить пользователей %1$s в группу?',
	'GROUP_CREATED'					=> 'Группа успешно создана.',
	'GROUP_DEFAULT'					=> 'Сделать группой по умолчанию',
	'GROUP_DEFS_UPDATED'			=> 'Для всех выбранных пользователей установлена группа по умолчанию.',
	'GROUP_DELETE'					=> 'Удалить пользователя из группы',
	'GROUP_DELETED'					=> 'Группа удалена и для её участников успешно установлены новые группы по умолчанию.',
	'GROUP_DEMOTE'					=> 'Снять лидера группы',
	'GROUP_DESC'					=> 'Описание группы',
	'GROUP_DETAILS'					=> 'Сведения о группе',
	'GROUP_EDIT_EXPLAIN'			=> 'Здесь можно изменить настройки существующей группы. Вы можете изменить название, описание и тип группы (открытая, закрытая и т.п.). Также можно установить некоторые дополнительные параметры, такие, как цвет, звание и т.п. Текущие настройки пользователей будут заменены в соответствии с произведёнными здесь изменениями. Участники групп могут изменять аватары групп на свои только если вы предоставили им для этого соответствующие права.',
	'GROUP_ERR_USERS_EXIST'			=> 'Указанные пользователи уже являются участниками этой группы.',
	'GROUP_FOUNDER_MANAGE'			=> 'Управляется только основателем',
	'GROUP_FOUNDER_MANAGE_EXPLAIN'	=> 'Ограничить управление этой группой только основателями. Пользователи, имеющие групповые права доступа, смогут видеть данную группу и её членов.',
	'GROUP_HIDDEN'					=> 'Скрытая',
	'GROUP_LANG'					=> 'Язык группы',
	'GROUP_LEAD'					=> 'Лидеры группы',
	'GROUP_LEADERS_ADDED'			=> 'Новые лидеры успешно добавлены в группу.',
	'GROUP_LEGEND'					=> 'Отображать группу в легенде',
	'GROUP_LIST'					=> 'Текущие участники группы',
	'GROUP_LIST_EXPLAIN'			=> 'Это полный список пользователей, являющихся в настоящее время участниками этой группы. Вы можете удалять участников (за исключением некоторых специальных групп) или добавлять новых.',
	'GROUP_MEMBERS'					=> 'Участники группы',
	'GROUP_MEMBERS_EXPLAIN'			=> 'Это полный список участников группы. Он состоит из отдельных разделов для лидеров, кандидатов, ожидающих вступления в группу, и действующих участников. Отсюда вы можете управлять всеми аспектами членства и распределения ролей в группе. Чтобы удалить лидера, но оставить его в группе, используйте опцию «Снять лидера группы» вместо «Удалить пользователя из группы». А чтобы сделать обычного участника руководителем группы, выберите опцию «Назначить лидером группы».',
	'GROUP_MESSAGE_LIMIT'			=> 'Лимит личных сообщений в каждой папке',
	'GROUP_MESSAGE_LIMIT_EXPLAIN'	=> 'Эта настройка отменит общий для пользователей лимит сообщений. Значение 0 означает, что будет использоваться пользовательский лимит по умолчанию.',
	'GROUP_MODS_ADDED'				=> 'Новые лидеры группы успешно добавлены.',
	'GROUP_MODS_DEMOTED'			=> 'Выбранные лидеры группы успешно сняты.',
	'GROUP_MODS_PROMOTED'			=> 'Выбранные участники группы успешно назначены лидерами.',
	'GROUP_NAME'					=> 'Название группы',
	'GROUP_NAME_TAKEN'				=> 'Введённое название группы уже существует. Введите другое название.',
	'GROUP_OPEN'					=> 'Открытая',
	'GROUP_PENDING'					=> 'Кандидаты на вступление в группу',
	'GROUP_MAX_RECIPIENTS'			=> 'Maximum number of allowed recipients per private message',
	'GROUP_MAX_RECIPIENTS_EXPLAIN'	=> 'The maximum number of allowed recipients in a private message. If 0 is entered, the board-wide setting is used.',
	'GROUP_OPTIONS_SAVE'			=> 'Group wide options',
	'GROUP_PROMOTE'					=> 'Назначить лидером группы',
	'GROUP_RANK'					=> 'Звание группы',
	'GROUP_RECEIVE_PM'				=> 'Группа может получать личные сообщения',
	'GROUP_RECEIVE_PM_EXPLAIN'		=> 'Примечание: скрытые группы не могут получать личные сообщения, независимо от этой опции.',
	'GROUP_REQUEST'					=> 'По запросу',
	'GROUP_SETTINGS_SAVE'			=> 'Настройки группы',
    'GROUP_SKIP_AUTH'				=> 'Exempt group leader from permissions',
    'GROUP_SKIP_AUTH_EXPLAIN'		=> 'If enabled group leader no longer inherit permissions from the group.',
	'GROUP_TYPE'					=> 'Тип группы',
	'GROUP_TYPE_EXPLAIN'			=> 'Эта группа настроек определяет, кто может вступать или просматривать эту группу.',
	'GROUP_UPDATED'					=> 'Настройки группы успешно обновлены.',

	'GROUP_USERS_ADDED'				=> 'Новые пользователи успешно добавлены в группу.',
	'GROUP_USERS_EXIST'				=> 'Выбранные пользователи уже являются участниками группы.',
	'GROUP_USERS_REMOVE'			=> 'Пользователи удалены из группы и для них успешно установлены новые группы по умолчанию.',

	'MAKE_DEFAULT_FOR_ALL'	=> 'Сделать группой по умолчанию для каждого её участника',
	'MEMBERS'				=> 'Участники',

	'NO_GROUP'					=> 'Группа не определена.',
	'NO_GROUPS_CREATED'			=> 'Группы ещё не созданы.',
	'NO_PERMISSIONS'			=> 'Не копировать права доступа',
	'NO_USERS'					=> 'Вы не задали ни одного пользователя.',
	'NO_USERS_ADDED'			=> 'No users were added to the group.',
	'NO_VALID_USERS'			=> 'You haven’t entered any users eligible for that action.',
	'SPECIAL_GROUPS'			=> 'Предустановленные группы',
	'SPECIAL_GROUPS_EXPLAIN'	=> 'Предустановленные группы — это специальные группы, которые не могут быть удалены или изменены напрямую. Тем не менее, вы можете добавлять пользователей в эти группы и изменять основные настройки этих групп.',

	'TOTAL_MEMBERS'				=> 'Участники',

	'USERS_APPROVED'				=> 'Пользователи успешно одобрены.',
	'USER_DEFAULT'					=> 'По умолчанию для пользователя',
	'USER_DEF_GROUPS'				=> 'Пользовательские группы',
	'USER_DEF_GROUPS_EXPLAIN'		=> 'Эти группы созданы вами или другим администратором. Вы можете управлять участниками групп, изменять настройки групп и удалять ненужные группы.',
	'USER_GROUP_DEFAULT'			=> 'Сделать группой по умолчанию',
	'USER_GROUP_DEFAULT_EXPLAIN'	=> 'Установка этой группы в качестве группы по умолчанию для добавляемых в группу пользователей.',
	'USER_GROUP_LEADER'				=> 'Назначить лидером группы',
));

?>