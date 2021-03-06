<?php
/**
*
* acp_board [Russian]
*
* @package language
* @version $Id: board.php,v 1.92 2007/08/23 13:41:34 naderman Exp $
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

// Board Settings
$lang = array_merge($lang, array(
	'ACP_BOARD_SETTINGS_EXPLAIN'	=> 'Здесь вы можете устанавливать основные настройки конференции, от имени сайта и регистрации пользователей до личных сообщений.',
	'CUSTOM_DATEFORMAT'				=> 'Другой…',
	'DEFAULT_DATE_FORMAT'			=> 'Формат даты',
	'DEFAULT_DATE_FORMAT_EXPLAIN'	=> 'Совпадает с форматом даты функции <code>date</code> языка PHP.',
	'DEFAULT_LANGUAGE'				=> 'Язык по умолчанию',
	'DEFAULT_STYLE'					=> 'Стиль по умолчанию',
	'DISABLE_BOARD'					=> 'Отключить конференцию',
	'DISABLE_BOARD_EXPLAIN'			=> 'Конференция станет недоступна для пользователей. Вы также можете ввести короткое (до 255 сомволов) сообщение для посетителей.',
	'OVERRIDE_STYLE'				=> 'Заменять стиль пользователя',
	'OVERRIDE_STYLE_EXPLAIN'		=> 'Стиль, выбранный пользователем, будет заменён на стиль по умолчанию.',
	'SITE_DESC'						=> 'Описание сайта',
	'SITE_NAME'						=> 'Имя сайта',
	'SYSTEM_DST'					=> 'Сейчас действует летнее время (<abbr title="Летнее время">DST</abbr>)',
	'SYSTEM_TIMEZONE'				=> 'Часовой пояс конференции',
	'WARNINGS_EXPIRE'				=> 'Длительность предупреждения',
	'WARNINGS_EXPIRE_EXPLAIN'		=> 'Количество дней, которое должно пройти до того, как предупреждение будет автоматически снято с пользователя',
	'WARNINGS_BAN'					=> 'Numbers of warnings before users will be banned',
	'WARNINGS_BAN_EXPLAIN'			=> 'Numbers of warnings before users will be automatically banned.',
	'WARNINGS_BAN_EXPIRE'			=> 'Expire time for automatic bans',
	'WARNINGS_BAN_EXPIRE_EXPLAIN'	=> 'The time (In minutes) that the automatic ban by x warnings expires.',	
));

// Board Features
$lang = array_merge($lang, array(
	'ACP_BOARD_FEATURES_EXPLAIN'	=> 'Здесь вы можете включать и выключать некоторые функции конференции',

	'ALLOW_ATTACHMENTS'			=> 'Разрешить вложения',
	'ALLOW_BIRTHDAYS'			=> 'Разрешить дни рождения',
	'ALLOW_BIRTHDAYS_EXPLAIN'	=> 'Разрешить указывать дни рождения и отображения возраста в профиле. Учтите, что список дней рождения на странице списка форумов включается отдельно в настройках нагрузки на сервер.',
	'ALLOW_BOOKMARKS'			=> 'Разрешить закладки',
	'ALLOW_BOOKMARKS_EXPLAIN'	=> 'Пользователь сможет сохранять персональные закладки',
	'ALLOW_BBCODE'				=> 'Разрешить BBCode',
	'ALLOW_FORUM_NOTIFY'		=> 'Разрешить подписку на форумы',
	'ALLOW_NAME_CHANGE'			=> 'Разрешить смену имени пользователя',
	'ALLOW_NO_CENSORS'			=> 'Разрешить отключение автоцензора',
	'ALLOW_NO_CENSORS_EXPLAIN'	=> 'Пользователи смогут по выбору отключать автоцензор в обычных и личных сообщениях.',
	'ALLOW_PM_ATTACHMENTS'		=> 'Разрешить вложения в личных сообщениях',
	'ALLOW_PM_REPORT'			=> 'Allow users to report private messages',
	'ALLOW_PM_REPORT_EXPLAIN'	=> 'If this setting is enabled, users have the option of reporting a private message they have received or sent to the board’s moderators. These private messages will then be visible in the Moderator Control Panel.',
	'ALLOW_QUICK_REPLY'			=> 'Разрешить быстрый ответ',
	'ALLOW_QUICK_REPLY_EXPLAIN'	=> 'This setting defines if quick reply is enabled or not. If this setting is enabled, forums need to have their quick reply option enabled too.',

	'ALLOW_SIG'					=> 'Разрешить подписи',
	'ALLOW_SIG_BBCODE'			=> 'Разрешить BBCode в подписях пользователей',
	'ALLOW_SIG_FLASH'			=> 'Разрешить использование тега BBCode <code>[FLASH]</code> в подписях пользователей',
	'ALLOW_SIG_IMG'				=> 'Разрешить использование тега BBCode <code>[IMG]</code> в подписях пользователей',
	'ALLOW_SIG_LINKS'			=> 'Разрешить ссылки в подписях пользователей',
	'ALLOW_SIG_LINKS_EXPLAIN'	=> 'В случае запрета тег BBCode <code>[URL]</code> и автоматическое преобразование текста в ссылки будут отключены.',
	'ALLOW_SIG_SMILIES'			=> 'Разрешить смайлики в подписях пользователей',
	'ALLOW_SMILIES'				=> 'Разрешить смайлики',
	'ALLOW_TOPIC_NOTIFY'		=> 'Разрешить подписку на темы',
    'BIRTHDAY_EMAILS'           => 'Поздравлять с днем рождения',
    'BIRTHDAY_EMAILS_EXPLAIN'   => 'Посылает поздравление пользователю по почте, в его день рождения.' ,
	
	'BOARD_PM'					=> 'Личные сообщения',
	'BOARD_PM_EXPLAIN'			=> 'Включение или отключение личных сообщений для всех пользователей.',
));

// Avatar Settings
$lang = array_merge($lang, array(
	'ACP_AVATAR_SETTINGS_EXPLAIN'	=> 'Аватары - это небольшие индивидуальные изображения, которые пользователи могут ассоциировать со своими учётными записями. В зависимости от выбранного стиля, аватары обычно отображаются под именем пользователя при просмотре тем. Здесь вы можете настроить применение аватар пользователями. Пожалуйста, учтите, что для загрузки аватар необходимо создать папку, имя которой задаётся ниже, и удостовериться в том, что вебсервер имеет права на запись в эту папку. Учтите также, что ограничение на размер файлов накладываются только на загружаемые на сервер аватары, и не распространяются на удалённые изображения.',

    'ALLOW_AVATARS'					=> 'Enable avatars',
    'ALLOW_AVATARS_EXPLAIN'			=> 'Allow general usage of avatars;<br />If you disable avatars in general or avatars of a certain mode, the disabled avatars will no longer be shown on the board, but users will still be able to download their own avatars in the User Control Panel.',
	'ALLOW_LOCAL'					=> 'Разрешить галерею аватар',
	'ALLOW_REMOTE'					=> 'Разрешить удалённые аватары',
	'ALLOW_REMOTE_EXPLAIN'			=> 'Ссылки на аватары, находящиеся на других сайтах',
    'ALLOW_REMOTE_UPLOAD'			=> 'Enable remote avatar uploading',
    'ALLOW_REMOTE_UPLOAD_EXPLAIN'	=> 'Allow uploading of avatars from another website.',
	'ALLOW_UPLOAD'					=> 'Разрешить загрузку аватар',
	'AVATAR_GALLERY_PATH'			=> 'Путь к галерее аватар',
	'AVATAR_GALLERY_PATH_EXPLAIN'	=> 'Путь относительно корневой папки phpBB для предустановленных изображений, например <samp>images/avatars/gallery</samp>',
	'AVATAR_STORAGE_PATH'			=> 'Путь к аватарам',
	'AVATAR_STORAGE_PATH_EXPLAIN'	=> 'Путь относительно корневой папки phpBB, например  <samp>images/avatars/upload</samp>',
	'MAX_AVATAR_SIZE'				=> 'Максимальные размеры аватары',
	'MAX_AVATAR_SIZE_EXPLAIN'		=> '(высота x ширина в пикселах)',
	'MAX_FILESIZE'					=> 'Максимальный размер файла аватары',
	'MAX_FILESIZE_EXPLAIN'			=> 'Для загружаемых файлов аватар',
	'MIN_AVATAR_SIZE'				=> 'Минимальные размеры аватары',
	'MIN_AVATAR_SIZE_EXPLAIN'		=> '(высота x ширина в пикселах)',
));

// Message Settings
$lang = array_merge($lang, array(
	'ACP_MESSAGE_SETTINGS_EXPLAIN'		=> 'Здесь вы можете задать все настройки по умолчанию для личных сообщений (ЛС)',

	'ALLOW_BBCODE_PM'			=> 'Разрешить BBCode в ЛС',
	'ALLOW_FLASH_PM'			=> 'Разрешить тег BBCode <code>[FLASH]</code>',
	'ALLOW_FLASH_PM_EXPLAIN'	=> 'Учтите, что возможность использования flash, если она включена здесь, зависит также от установленных прав доступа.',
	'ALLOW_FORWARD_PM'			=> 'Разрешить пересылку ЛС',
	'ALLOW_IMG_PM'				=> 'Разрешить тег BBCode <code>[IMG]</code>',
	'ALLOW_MASS_PM'				=> 'Разрешить отправку ЛС нескольким пользователям или группам пользователей',
	'ALLOW_MASS_PM_EXPLAIN'		=> 'Sending to groups can be adjusted per group within the group settings page.',
	'ALLOW_PRINT_PM'			=> 'Разрешить печатный вид в ЛС',
	'ALLOW_QUOTE_PM'			=> 'Разрешить цитаты в ЛС',
	'ALLOW_SIG_PM'				=> 'Разрешить подписи в ЛС',
	'ALLOW_SMILIES_PM'			=> 'Разрешить смайлики в ЛС',
	'BOXES_LIMIT'				=> 'Максимальное количество ЛС в папке',
	'BOXES_LIMIT_EXPLAIN'		=> 'Пользователи не смогут сохранять больше, чем указанное количество сообщений, в каждой из папок для ЛС. Установите 0 для снятия ограничений.',
	'BOXES_MAX'					=> 'Максимальное количество папок для ЛС',
	'BOXES_MAX_EXPLAIN'			=> 'По умолчанию пользователи не смогут создавать больше указанного количества папок для ЛС.',
	'ENABLE_PM_ICONS'			=> 'Разрешить использование значков тем в ЛС',
	'FULL_FOLDER_ACTION'		=> 'Действие по умолчанию для переполненной папки',
	'FULL_FOLDER_ACTION_EXPLAIN'=> 'Действие по умолчанию, выполняемое для переполненной папки пользователя, в случае, если выбранное пользователем действие для папки неприменимо. Единственным исключением является папка «Отправленные», для которой действием по умолчанию всегда является удаление старых сообщений.',
	'HOLD_NEW_MESSAGES'			=> 'Отложить новые сообщения',
	'PM_EDIT_TIME'				=> 'Ограничить время редактирования',
	'PM_EDIT_TIME_EXPLAIN'		=> 'Ограничить время, в течение которого доступно редактирование отправленного, но ещё не полученного адресатом личного сообщения. Установите 0 для снятия ограничений.',
    'PM_MAX_RECIPIENTS'			=> 'Maximum number of allowed recipients',
    'PM_MAX_RECIPIENTS_EXPLAIN'	=> 'The maximum number of allowed recipients in a private message. If 0 is entered, an unlimited number is allowed. This setting can be adjusted for every group within the group settings page.',
));

// Post Settings
$lang = array_merge($lang, array(
	'ACP_POST_SETTINGS_EXPLAIN'			=> 'Здесь вы можете задать все настройки по умолчанию для сообщений',
	'ALLOW_POST_LINKS'					=> 'Разрешить ссылки в обычных/личных сообщениях',
	'ALLOW_POST_LINKS_EXPLAIN'			=> 'В случае запрета тег BBCode <code>[URL]</code> и автоматическое преобразование текста в ссылки будут отключены.',
	'ALLOW_POST_FLASH'					=> 'Разрешить тег BBCode <code>[FLASH]</code> в сообщениях. ',
	'ALLOW_POST_FLASH_EXPLAIN'			=> 'Если тег BBCode <code>[FLASH]</code> запрещён, он будет отключен в сообщениях. Определить пользователей, имеющих право использовать тег BBCode <code>[FLASH]</code>, можно с помощью системы управления правами доступа.',

    'BUMP_INTERVAL'					=> 'Задержка поднятия темы',
	'BUMP_INTERVAL_EXPLAIN'			=> 'Количество минут, часов или дней с последнего сообщения, по прошествию которых можно поднимать тему.',
	'CHAR_LIMIT'					=> 'Максимальное количество символов в сообщении',
	'CHAR_LIMIT_EXPLAIN'			=> 'Количество символов, разрешённое в сообщении. Установите 0 для снятия ограничений.',
    'DELETE_TIME'					=> 'Limit deleting time',
    'DELETE_TIME_EXPLAIN'			=> 'Limits the time available to delete a new post. Setting the value to 0 disables this behaviour.',
	'DISPLAY_LAST_EDITED'			=> 'Отображать сведения о последнем редактировании',
	'DISPLAY_LAST_EDITED_EXPLAIN'	=> 'Выберите для отображения информации о последнем редактировании сообщения',
	'EDIT_TIME'						=> 'Ограничить время редактирования',
	'EDIT_TIME_EXPLAIN'				=> 'Ограничить время, в течение которого доступно редактирование нового сообщения. Установите 0 для отключения этой функции.',
	'FLOOD_INTERVAL'				=> 'Задержка флуда',
	'FLOOD_INTERVAL_EXPLAIN'		=> 'Количество секунд, которое должно пройти между двумя сообщениями пользователя. Чтобы разрешить пользователям игнорировать это ограничение, установите им соответствующие права.',
	'HOT_THRESHOLD'					=> 'Сообщений в популярной теме',
	'HOT_THRESHOLD_EXPLAIN'			=> 'Необходимое количество сообщений в теме для того, чтобы она приобрела статус популярной. Установите 0 для отключения популярных тем.',
	'MAX_POLL_OPTIONS'				=> 'Максимальное количество вариантов ответа в опросах',
	'MAX_POST_FONT_SIZE'			=> 'Максимальный размер шрифта в сообщении',
	'MAX_POST_FONT_SIZE_EXPLAIN'	=> 'Максимальный размер шрифта, разрешенный в сообщении. Установите 0 для снятия ограничений.',
	'MAX_POST_IMG_HEIGHT'			=> 'Максимальная высота изображения в сообщении',
	'MAX_POST_IMG_HEIGHT_EXPLAIN'	=> 'Максимальная высота изображений/flash в сообщениях. Установите 0 для снятия ограничений.',
	'MAX_POST_IMG_WIDTH'			=> 'Максимальная ширина изображения в сообщении',
	'MAX_POST_IMG_WIDTH_EXPLAIN'	=> 'Максимальная ширина изображений/flash в сообщениях. Установите 0 для снятия ограничений.',
	'MAX_POST_URLS'					=> 'Максимальное количество ссылок в сообщении',
	'MAX_POST_URLS_EXPLAIN'			=> 'Максимальное количесво ссылок URL в сообщении. Установите 0 для снятия ограничений.',
    'MIN_CHAR_LIMIT'				=> 'Minimum characters per post/message',
    'MIN_CHAR_LIMIT_EXPLAIN'		=> 'The minimum number of characters the user need to enter within a post/private message.',
	'POSTING'						=> 'Сообщений',
	'POSTS_PER_PAGE'				=> 'Сообщений на страницу',
	'QUOTE_DEPTH_LIMIT'				=> 'Максимальное количество вложенных цитат в сообщении',
	'QUOTE_DEPTH_LIMIT_EXPLAIN'		=> 'Максимальное количество вложенных цитат в сообщении. Установите 0 для снятия ограничений.',
	'SMILIES_LIMIT'					=> 'Максимальное количество смайликов в сообщении',
	'SMILIES_LIMIT_EXPLAIN'			=> 'Максимальное количество смайликов в сообщении. Установите 0 для снятия ограничений.',
    'SMILIES_PER_PAGE'				=> 'Smilies per page',
	'TOPICS_PER_PAGE'				=> 'Тем на страницу',
));

// Signature Settings
$lang = array_merge($lang, array(
	'ACP_SIGNATURE_SETTINGS_EXPLAIN'	=> 'Здесь вы можете задать все настройки по умолчанию для подписей',

	'MAX_SIG_FONT_SIZE'				=> 'Максимальный размер шрифта в подписи',
	'MAX_SIG_FONT_SIZE_EXPLAIN'		=> 'Максимальный размер шрифта, разрешённый в подписях пользователей. Установите 0 для снятия ограничений',
	'MAX_SIG_IMG_HEIGHT'			=> 'Максимальная высота изображения в подписи',
	'MAX_SIG_IMG_HEIGHT_EXPLAIN'	=> 'Максимальная высота изображения/flash в подписях пользователей. Установите 0 для снятия ограничений.',
	'MAX_SIG_IMG_WIDTH'				=> 'Максимальная ширина изображения в подписи',
	'MAX_SIG_IMG_WIDTH_EXPLAIN'		=> 'Максимальная ширина изображения/flash в подписях пользователей. Установите 0 для снятия ограничений.',
	'MAX_SIG_LENGTH'				=> 'Максимальная длина подписи',
	'MAX_SIG_LENGTH_EXPLAIN'		=> 'Максимальное количество символов в подписях пользователей.',
	'MAX_SIG_SMILIES'				=> 'Максимум смайликов в подписи',
	'MAX_SIG_SMILIES_EXPLAIN'		=> 'Максимальное количество смайликов, разрешённое в подписях пользователей. Установите 0 для снятия ограничений.',
	'MAX_SIG_URLS'					=> 'Максимум ссылок в подписи',
	'MAX_SIG_URLS_EXPLAIN'			=> 'Максимальное количество ссылок в подписях пользователей. Установите 0 для снятия ограничений.',
));

// Registration Settings
$lang = array_merge($lang, array(
	'ACP_REGISTER_SETTINGS_EXPLAIN'		=> 'Здесь вы можете задать настройки, связанные с регистрацией и профилями пользователей',

	'ACC_ACTIVATION'			=> 'Активация учётной записи',
	'ACC_ACTIVATION_EXPLAIN'	=> 'Определить, должен ли пользователь получить немедленный доступ к конференции, или для этого требуется подтверждение регистрации. Вы можете также полностью отключить регистрацию новых пользователей.',
    'NEW_MEMBER_POST_LIMIT'			=> 'New member post limit',
    'NEW_MEMBER_POST_LIMIT_EXPLAIN'	=> 'New members are within the <em>Newly Registered Users</em> group until they reach this number of posts. You can use this group to keep them from using the PM system or to review their posts. <strong>A value of 0 disables this feature.</strong>',
    'NEW_MEMBER_GROUP_DEFAULT'		=> 'Set Newly Registered Users group to default',
    'NEW_MEMBER_GROUP_DEFAULT_EXPLAIN'	=> 'If set to yes and a new member post limit is specified newly registered users will be not only put into the <em>Newly Registered Users</em> group, but this group also being their default one. This may come in handy if you want to assign a group default rank and/or avatar the user then inherits.',
	'ACC_ADMIN'					=> 'Администратором',
	'ACC_DISABLE'				=> 'Отключено',
	'ACC_NONE'					=> 'Нет',
	'ACC_USER'					=> 'Пользователем',
//	'ACC_USER_ADMIN'			=> 'User + Admin',
	'ALLOW_EMAIL_REUSE'			=> 'Разрешить повторное использование email-адреса',
	'ALLOW_EMAIL_REUSE_EXPLAIN'	=> 'Разные пользователи смогут регистрироваться с одинаковым email-адресом.',
	'COPPA'						=> 'COPPA',
	'COPPA_FAX'					=> 'Номер факса для COPPA',
	'COPPA_MAIL'				=> 'Почтовый адрес для COPPA',
	'COPPA_MAIL_EXPLAIN'		=> 'Почтовый адрес, на который родители должны отправлять формы регистрации COPPA',
	'ENABLE_COPPA'				=> 'Включить COPPA',
	'ENABLE_COPPA_EXPLAIN'		=> 'От пользователя потребуется подтвердить, достиг ли он возраста 13 лет или старше, для соответствия требованиям U.S. COPPA Act. Если отключено, специальные группы COPPA больше не будут отображены.',
	'MAX_CHARS'					=> 'макс.',
	'MIN_CHARS'					=> 'мин.',
	'NO_AUTH_PLUGIN'			=> 'Не найдено подходящего модуля авторизации.',
	'PASSWORD_LENGTH'			=> 'Длина пароля',
	'PASSWORD_LENGTH_EXPLAIN'	=> 'Минимальное и максимальное количество символов в паролях.',
	'REG_LIMIT'					=> 'Попытки регистрации',
	'REG_LIMIT_EXPLAIN'			=> 'Количество попыток регистрации с кодом подтверждения, которое могут сделать пользователи в течение одной сессии.',
	'USERNAME_ALPHA_ONLY'		=> 'Только буквенно-цифровые',
	'USERNAME_ALPHA_SPACERS'	=> 'Буквенно-цифровые и разделители',
	'USERNAME_ASCII'			=> 'ASCII (без международного юникода)',
	'USERNAME_LETTER_NUM'		=> 'Любые буквы и цифры',
	'USERNAME_LETTER_NUM_SPACERS'	=> 'Любые буквы, цифры и разделители',
	'USERNAME_CHARS'			=> 'Ограничения на символы в имени пользователя',
	'USERNAME_CHARS_ANY'		=> 'Любые символы',
	'USERNAME_CHARS_EXPLAIN'	=> 'Символы, которые могут быть использованы в именах пользователей. Разделителями считаются символы пробела, -, +, _, [ и ]',
	'USERNAME_LENGTH'			=> 'Длина имени пользователя',
	'USERNAME_LENGTH_EXPLAIN'	=> 'Минимальное и максимальное количество символов в именах пользователей.',
));

// Feeds
$lang = array_merge($lang, array(
    'ACP_FEED_MANAGEMENT'				=> 'General Syndication Feeds settings',
    'ACP_FEED_MANAGEMENT_EXPLAIN'		=> 'This Module makes available various ATOM Feeds, parsing any BBCode in posts to make them readable in external feeds.',

    'ACP_FEED_ENABLE'					=> 'Enable Feeds',
    'ACP_FEED_ENABLE_EXPLAIN'			=> 'Turns on or off ATOM Feeds for the entire board.<br />Disabling this switches off all Feeds, no matter how the options below are set.',
    'ACP_FEED_LIMIT'					=> 'Number of items',
    'ACP_FEED_LIMIT_EXPLAIN'			=> 'The maximum number of feed items to display.',

    'ACP_FEED_OVERALL_FORUMS'			=> 'Enable overall forums feed',
    'ACP_FEED_OVERALL_FORUMS_EXPLAIN'	=> 'This feed displays the latest posts from all forums topics.',
    'ACP_FEED_OVERALL_FORUMS_LIMIT'		=> 'Number of items per page to display in the forums feed',

    'ACP_FEED_OVERALL_TOPIC'			=> 'Enable overall topics feed',
    'ACP_FEED_OVERALL_TOPIC_EXPLAIN'	=> 'Enables the “All Topics” feed',
    'ACP_FEED_OVERALL_TOPIC_LIMIT'		=> 'Number of items per page to display in the topics feed',
    'ACP_FEED_FORUM'					=> 'Enable Per-Forum Feeds',
    'ACP_FEED_FORUM_EXPLAIN'			=> 'Single forum new posts.',
    'ACP_FEED_TOPIC'					=> 'Enable Per-Topic Feeds',
    'ACP_FEED_TOPIC_EXPLAIN'			=> 'Single topics new posts.',
    'ACP_FEED_NEWS'						=> 'News Feeds',
    'ACP_FEED_NEWS_EXPLAIN'				=> 'Pull the first post from these forums. Select no forums to disable news feed.<br />Select multiple forums by holding <samp>CTRL</samp> and clicking.',

    'ACP_FEED_GENERAL'					=> 'General Feed Settings',

    'ACP_FEED_ITEM_STATISTICS'			=> 'Item statistics',
    'ACP_FEED_ITEM_STATISTICS_EXPLAIN'	=> 'Display individual statistics underneath feed items<br />(Posted by, date and time, Replies, Views)',
    'ACP_FEED_EXCLUDE_ID'				=> 'Exclude these forums',
    'ACP_FEED_EXCLUDE_ID_EXPLAIN'		=> 'Content from these will be <strong>not included in feeds</strong>. Select no forum to pull data from all forums.<br />Select/Deselect multiple forums by holding <samp>CTRL</samp> and clicking.',
));

// Visual Confirmation Settings
$lang = array_merge($lang, array(
	'ACP_VC_SETTINGS_EXPLAIN'		=> 'Здесь вы можете задать настройки по умолчанию для визуального подтверждения регистрации и CAPTCHA.',
    'AVAILABLE_CAPTCHAS'					=> 'Available plugins',
    'CAPTCHA_UNAVAILABLE'					=> 'The CAPTCHA cannot be selected as its requirements are not met.',
	'CAPTCHA_GD'							=> 'GD CAPTCHA',
    'CAPTCHA_GD_3D'							=> 'GD 3D Captcha',
	'CAPTCHA_GD_FOREGROUND_NOISE'			=> 'GD CAPTCHA с шумом на переднем плане',
	'CAPTCHA_GD_EXPLAIN'					=> 'Использовать библиотеку GD для создания усовершенствованной CAPTCHA.',
	'CAPTCHA_GD_FOREGROUND_NOISE_EXPLAIN'	=> 'Использовать шум для создания усложнённой CAPTCHA.',
	'CAPTCHA_GD_X_GRID'						=> 'Фоновой шум CAPTCHA по оси X',
	'CAPTCHA_GD_X_GRID_EXPLAIN'				=> 'Используйте меньшее значение для создания более сложной CAPTCHA. Введите 0 для отключения создания шума по оси X.',
	'CAPTCHA_GD_Y_GRID'						=> 'Фоновой шум CAPTCHA по оси Y',
	'CAPTCHA_GD_Y_GRID_EXPLAIN'				=> 'Используйте меньшее значение для создания более сложной CAPTCHA. Введите 0 для отключения создания шума по оси Y.',
	'CAPTCHA_GD_WAVE'						=> 'GD CAPTCHA wave distortion',
	'CAPTCHA_GD_WAVE_EXPLAIN'				=> 'This applies a wave distortion to the CAPTCHA.',
	'CAPTCHA_GD_3D_NOISE'					=> 'Add 3D-noise objects',
	'CAPTCHA_GD_3D_NOISE_EXPLAIN'			=> 'This adds additional objects to the CAPTCHA, over the letters.',
	'CAPTCHA_GD_FONTS'						=> 'Use different fonts',
	'CAPTCHA_GD_FONTS_EXPLAIN'				=> 'This setting controls how many different letter shapes are used. You can just use the default shapes or introduce altered letters. Adding lowercase letters is also possible.',
	'CAPTCHA_FONT_DEFAULT'					=> 'Default',
	'CAPTCHA_FONT_NEW'						=> 'New Shapes',
	'CAPTCHA_FONT_LOWER'					=> 'Also use lowercase',
    'CAPTCHA_NO_GD'							=> 'CAPTCHA without GD',
    'CAPTCHA_PREVIEW_MSG'					=> 'Your changes to the visual confirmation setting were not saved. This is just a preview.',
    'CAPTCHA_PREVIEW_EXPLAIN'				=> 'The CAPTCHA as it would look like using the current selection.',

    'CAPTCHA_SELECT'						=> 'Installed CAPTCHA plugins',
    'CAPTCHA_SELECT_EXPLAIN'				=> 'The dropdown holds the CAPTCHA plugins recognized by the board. Gray entries are not available right now and might need configuration prior to use.',
    'CAPTCHA_CONFIGURE'						=> 'Configure CAPTCHAs',
    'CAPTCHA_CONFIGURE_EXPLAIN'				=> 'Change the settings for the selected CAPTCHA.',
    'CONFIGURE'								=> 'Configure',
    'CAPTCHA_NO_OPTIONS'					=> 'This CAPTCHA has no configuration options.',

	'VISUAL_CONFIRM_POST'					=> 'Визуальное подтверждение для гостей',
	'VISUAL_CONFIRM_POST_EXPLAIN'			=> 'Для предотвращения массовой отправки сообщений анонимные пользователи при размещении сообщений должны будут ввести код подтверждения, показываемый им на картинке.',
	'VISUAL_CONFIRM_REG'					=> 'Визуальное подтверждение при регистрации',
	'VISUAL_CONFIRM_REG_EXPLAIN'			=> 'Для предотвращения автоматических регистраций новые пользователи при регистрации должны будут ввести код подтверждения, показываемый им на картинке.',
    'VISUAL_CONFIRM_REFRESH'				=> 'Enable users to refresh the confirmation image',
    'VISUAL_CONFIRM_REFRESH_EXPLAIN'		=> 'Allows users to request new confirmation codes, if they are unable to solve the VC during registration.',
));

// Cookie Settings
$lang = array_merge($lang, array(
	'ACP_COOKIE_SETTINGS_EXPLAIN'		=> 'Здесь производится настрока куков (cookies), отправляемых браузерам пользователей. В большинстве случаев достаточно значений по умолчанию. Если вам нужно изменить что-либо, делайте это с осторожностью, неверные установки могут сделать невозможным вход пользователей на конференцию.',

	'COOKIE_DOMAIN'				=> 'Домен куки',
	'COOKIE_NAME'				=> 'Имя куки',
	'COOKIE_PATH'				=> 'Путь куки',
	'COOKIE_SECURE'				=> 'Безопасные куки [ https ]',
	'COOKIE_SECURE_EXPLAIN'		=> 'Если ваш сервер работает через SSL, включите этот параметр, в противном случае оставьте выключенным. Включение этого параметра, если сервер работает не через SSL, приведёт к ошибкам при переходах на страницы конференции и при переадресации.',
	'ONLINE_LENGTH'				=> 'Временной диапазон онлайн статистики',
	'ONLINE_LENGTH_EXPLAIN'		=> 'Количество минут, по прошествию которых неактивные пользователи перестанут быть видимыми в списке «Кто сейчас на конференции». Увеличение этого значения повышает расход ресурсов сервера на создание списка.',
	'SESSION_LENGTH'			=> 'Длительность сессии',
	'SESSION_LENGTH_EXPLAIN'	=> 'Сессия будет завершена по прошествию указанного времени, в секундах.',
));

// Load Settings
$lang = array_merge($lang, array(
	'ACP_LOAD_SETTINGS_EXPLAIN'	=> 'Здесь вы можете включать и отключать некоторые функции конференции для снижения нагрузки на сервер. Для большинства серверов не требуется отключать какие-либо функции. Однако, на некоторых системах или коллективных хостингах может быть полезным отключение возможностей, которые вам не требуются. Вы можете также задать ограничения для нагрузки на сервер и активных сессий, при превышении которых конференция будет отключена.',

	'CUSTOM_PROFILE_FIELDS'			=> 'Дополнительные поля профиля',
	'LIMIT_LOAD'					=> 'Ограничить нагрузку на сервер',
	'LIMIT_LOAD_EXPLAIN'			=> 'Если средняя ежеминутная нагрузка на сервер превышает заданное значение, конференция будет автоматически отключена. Значение, равное 1.0, означает ~100% использование ресурсов одного процессора. Эта возможность применима только для серверов на основе UNIX.',
	'LIMIT_SESSIONS'				=> 'Ограничить сессии',
	'LIMIT_SESSIONS_EXPLAIN'		=> 'Если количество сессий превышает заданное значение в течение одной минуты, конференция будет автоматически отключена. Установите 0 для снятия ограничений.',
	'LOAD_CPF_MEMBERLIST'			=> 'Разрешить отображение дополнительных полей профиля в списке пользователей',
	'LOAD_CPF_VIEWPROFILE'			=> 'Показывать дополнительные поля в профилях пользователей',
	'LOAD_CPF_VIEWTOPIC'			=> 'Показывать дополнительные поля профиля при просмотре тем',
	'LOAD_USER_ACTIVITY'			=> 'Показать активность пользователя',
	'LOAD_USER_ACTIVITY_EXPLAIN'	=> 'Отображение темы/форума, в которых пользователь наиболее активен, в его профиле и личном разделе. Рекомендуется отключить эту функцию на конференциях с более чем одним миллионом сообщений.',
	'RECOMPILE_STYLES'				=> 'Перекомпилировать старые шаблоны',
	'RECOMPILE_STYLES_EXPLAIN'		=> 'Проверять обновление файлов шаблонов на сервере и перекомпилировать их.',
	'YES_ANON_READ_MARKING'			=> 'Включить маркировку тем для гостей',
	'YES_ANON_READ_MARKING_EXPLAIN'	=> 'Сохранять информацию о статусе «прочитано/не прочитано» для гостей. Если отключено, сообщения для гостей всегда помечены как прочитанные.',
	'YES_BIRTHDAYS'					=> 'Включить список дней рождения',
	'YES_BIRTHDAYS_EXPLAIN'			=> 'Если список дней рождения отключен, он не будет отображаться. Для того, чтобы эта настройка работала, должна быть также включена функция дней рождения.',
	'YES_JUMPBOX'					=> 'Включить отображение быстрого перехода',
	'YES_MODERATORS'				=> 'Включить отображение модераторов',
	'YES_ONLINE'					=> 'Включить информацию об активных пользователях',
	'YES_ONLINE_EXPLAIN'			=> 'Отображать информацию об активных пользователях на главной странице, при просмотре форумов и тем.',
	'YES_ONLINE_GUESTS'				=> 'Включить отображение гостей в списках активных пользователей',
	'YES_ONLINE_GUESTS_EXPLAIN'		=> 'Разрешить отображение информации о гостях при просмотре «Кто сейчас на конференции».',
	'YES_ONLINE_TRACK'				=> 'Включить отображение информации о пользователе «в сети/не в сети»',
	'YES_ONLINE_TRACK_EXPLAIN'		=> 'Отображать информацию о нахождении пользователя в сети в профилях и при просмотре тем.',
	'YES_POST_MARKING'				=> 'Включить свои темы',
	'YES_POST_MARKING_EXPLAIN'		=> 'Указывать, оставлял ли пользователь сообщения в теме.',
	'YES_READ_MARKING'				=> 'Включить маркировку тем на сервере',
	'YES_READ_MARKING_EXPLAIN'		=> 'Сохранять информацию о статусе «прочитано/не прочитано» в базе данных, а не в куках (cookies).',
));

// Auth settings
$lang = array_merge($lang, array(
	'ACP_AUTH_SETTINGS_EXPLAIN'	=> 'phpBB поддерживает расширения аутентификации, или модули. Они позволяют вам установить способ аутентификации пользователей при их входе на конференцию. По умолчанию доступны три модуля: DB, LDAP and Apache. Не все методы требуют дополнительной информации, поэтому заполняйте только те поля, которые необходимы для выбранного метода.',

	'AUTH_METHOD'				=> 'Выбрать метод аутентификации',

	'APACHE_SETUP_BEFORE_USE'	=> 'Вы должны настроить аутентификацию apache при переключении phpBB на этот метод. Помните, что имя пользователя для аутентификации в Apache должно совпадать с вашим именем пользователя в phpBB.',

	'LDAP_DN'						=> 'Основное имя LDAP [ <var>dn</var> ]',
	'LDAP_DN_EXPLAIN'				=> 'Уникальное имя (Distinguished Name), определяющее информацию о пользователе, например <samp>o=My Company,c=US</samp>',
	'LDAP_EMAIL'					=> 'Email-атрибут LDAP',
	'LDAP_EMAIL_EXPLAIN'			=> 'Задайте имя атрибута email пользователя (если он существует), для автоматического присвоения email-адресов новым пользователям. Если это поле оставлено пустым, email-адреса пользователей, которые впервые вошли на конференцию, также будут пустыми.',
	'LDAP_INCORRECT_USER_PASSWORD'	=> 'Попытка связи с сервером LDAP с указанным именем/паролем не удалась.',
	'LDAP_NO_EMAIL'					=> 'Указанный атрибут email не существует.',
	'LDAP_NO_IDENTITY'				=> 'Не удалось найти идендтификатор входа в систему для %s',
	'LDAP_PASSWORD'					=> 'Пароль LDAP',
	'LDAP_PASSWORD_EXPLAIN'			=> 'Оставьте поле пустым для анонимного соединения. В противном случае введите пароль для указанного выше пользователя. Требуется для серверов Active Directory. <strong>ВНИМАНИЕ:</strong> Этот пароль будет сохранён в незашифрованном виде в базе данных, и будет виден всем, кто имеет доступ к ней или к этой странице конфигурации.',
	'LDAP_PORT'						=> 'Порт сервера LDAP',
	'LDAP_PORT_EXPLAIN'				=> 'Вы можете указать порт, который должен использоваться для соединения с сервером LDAP вместо порта по умолчанию 389.',
	'LDAP_SERVER'					=> 'Имя сервера LDAP',
	'LDAP_SERVER_EXPLAIN'			=> 'Если используется LDAP, укажите хост или IP-адрес сервера LDAP. Вы можете указать ссылку, например ldap://hostname:port/',
	'LDAP_UID'						=> 'Идентификационный номер LDAP [ <var>uid</var> ]',
	'LDAP_UID_EXPLAIN'				=> 'Это ключ, с помощью которого производится поиск заданного идентификатора входа в систему, например <var>uid</var>, <var>sn</var>, и т.п.',
	'LDAP_USER'						=> 'Пользователь LDAP [ <var>dn</var> ]',
	'LDAP_USER_EXPLAIN'				=> 'Оставьте пустым для анонимного соединения. Если поле заполнено, phpBB использует указанное имя при соединении с сервером LDAP для поиска правильного пользователя, например, например <samp>uid=Username,ou=MyUnit,o=MyCompany,c=US</samp>. Требуется для серверов Active Directory.',
	'LDAP_USER_FILTER'				=> 'Фильтр имени пользователя LDAP',
	'LDAP_USER_FILTER_EXPLAIN'		=> 'Вы можете в дальнейшем ограничить диапазон искомых объектов с помощью дополнительных фильтров. Например, результатом <samp>objectClass=posixGroup</samp> будет <samp>(&(uid=$username)(objectClass=posixGroup))</samp>',
));

// Server Settings
$lang = array_merge($lang, array(
	'ACP_SERVER_SETTINGS_EXPLAIN'	=> 'Здесь задаются настройки, связанные с сервером и доменом. Удостоверьтесь в точности указанных вами данных, ошибки приведут к рассылке email-сообщений, содержащих неверную информацию. Задавая имя домена, помните, что оно должно включать  http:// или префикс другого протокола. Изменяйте номер порта только в случае, если вам точно известно, что сервер использует другое значение, порт 80 подходит в большинстве случаев.',

	'ENABLE_GZIP'				=> 'Включить сжатие GZip',
	'ENABLE_GZIP_EXPLAIN'		=> 'Генерируемое содержимое будет сжиматься с помощью GZip перед отправкой пользователю. Включение этой опции помогает уменьшить расход сетевого трафика, но в то же время увеличивает использование центрального процессора, как на стороне клиента, так и на сервере.',
	'FORCE_SERVER_VARS'			=> 'Принудительные настройки URL сервера',
	'FORCE_SERVER_VARS_EXPLAIN'	=> 'Если выбрано, то указанные здесь настройки будут использованы вместо автоматически определённых значений',
	'ICONS_PATH'				=> 'Путь к значкам сообщений',
	'ICONS_PATH_EXPLAIN'		=> 'Путь относительно корневой папки phpBB, например <samp>images/icons</samp>',
	'PATH_SETTINGS'				=> 'Настройки путей',
	'RANKS_PATH'				=> 'Путь к картинкам званий',
	'RANKS_PATH_EXPLAIN'		=> 'Путь относительно корневой папки phpBB, например <samp>images/ranks</samp>',
	'SCRIPT_PATH'				=> 'Путь к конференции',
	'SCRIPT_PATH_EXPLAIN'		=> 'Путь к папке, содержащей  phpBB, относительно имени домена, например, <samp>/phpBB3</samp>',
	'SERVER_NAME'				=> 'Имя домена',
	'SERVER_NAME_EXPLAIN'		=> 'Имя домена, на котором работает эта конференция (например: <samp>www.example.com</samp>)',
	'SERVER_PORT'				=> 'Порт сервера',
	'SERVER_PORT_EXPLAIN'		=> 'Порт, на котором запущен сервер, обычно это порт 80, изменяйте тольно в случае, если сервер использует другой порт',
	'SERVER_PROTOCOL'			=> 'Протокол сервера',
	'SERVER_PROTOCOL_EXPLAIN'	=> 'Используется в качестве протокола сервера, если эти настройки включены принудительно. Если не задано или не включено принудительно, протокол будет определён по настройкам безопасных куков (<samp>http://</samp> или <samp>https://</samp>)',
	'SERVER_URL_SETTINGS'		=> 'Настройки URL сервера',
	'SMILIES_PATH'				=> 'Путь к смайликам',
	'SMILIES_PATH_EXPLAIN'		=> 'Путь относительно корневой папки phpBB, например <samp>images/smilies</samp>',
	'UPLOAD_ICONS_PATH'			=> 'Путь к значкам групп расширений',
	'UPLOAD_ICONS_PATH_EXPLAIN'	=> 'Путь относительно корневой папки phpBB, например <samp>images/upload_icons</samp>',
));

// Security Settings
$lang = array_merge($lang, array(
	'ACP_SECURITY_SETTINGS_EXPLAIN'		=> 'Здесь вы можете задать установки, связанные с сессией и входом на конференцию',

	'ALL'							=> 'Полная',
	'ALLOW_AUTOLOGIN'				=> 'Разрешить автоматический вход на конференцию',
	'ALLOW_AUTOLOGIN_EXPLAIN'		=> 'Определяет, могут ли пользователи автоматически входить на конференцию при её посещении.',
	'AUTOLOGIN_LENGTH'				=> 'Время действия автоматического входа (дней)',
	'AUTOLOGIN_LENGTH_EXPLAIN'		=> 'Количество дней, в течение которого пользователь может автоматически входить на конференцию. Установите 0 для снятия ограничений.',
	'BROWSER_VALID'					=> 'Проверка браузера',
	'BROWSER_VALID_EXPLAIN'			=> 'Включает проверку браузера при каждой сессии для повышения безопасности.',
	'CHECK_DNSBL'					=> 'Проверить IP-адрес по чёрному списку DNS (DNS Blackhole List)',
	'CHECK_DNSBL_EXPLAIN'			=> 'Если включено, IP-адрес пользователя будет проверен с помощью следующих служб  DNSBL при регистрации или отправке сообщений: <a href="http://spamcop.net">spamcop.net</a>, <a href="http://dsbl.org">dsbl.org</a> и <a href="http://www.spamhaus.org">www.spamhaus.org</a>. Эта процедура может занять некоторое время, в зависимости от конфигурации сервера. В случае замедления работы сервера или большого количества ложных срабатываний рекомендуется отключить эту проверку.',
	'CLASS_B'						=> 'A.B',
	'CLASS_C'						=> 'A.B.C',
	'EMAIL_CHECK_MX'				=> 'Проверить правильность почтовой записи в DNS (MX Record) домена email-адреса',
	'EMAIL_CHECK_MX_EXPLAIN'		=> 'Если включено, домен email-адреса, указанный при регистрации или изменении профиля, проверяется на правильность  почтовой записи в DNS (MX Record).',
	'FORCE_PASS_CHANGE'				=> 'Принудительная смена пароля',
	'FORCE_PASS_CHANGE_EXPLAIN'		=> 'Пользователь должен будет сменить свой пароль по прошествии заданного количества дней. Установите 0 для отключения этой функции.',
	'FORM_TIME_MAX'					=> 'Максимальное время для отправки формы',
	'FORM_TIME_MAX_EXPLAIN'			=> 'Время, за которое пользователь должен отправить форму. Установите -1 для отключения этой функции. Учтите, что форма может устареть по истечении сессии, независимо от данной настройки.',
	'FORM_SID_GUESTS'				=> 'Привязать формы к гостевым сессиям',
	'FORM_SID_GUESTS_EXPLAIN'		=> 'Если включено, формы, отправляемые гостями, будут привязаны к конкретным сессиям. Это может вызвать проблемы с некоторыми Интернет-провайдерами.',
	'FORWARDED_FOR_VALID'			=> 'Проверка заголовка <var>X_FORWARDED_FOR</var>',
	'FORWARDED_FOR_VALID_EXPLAIN'	=> 'Сессия будет продолжена только в случае, если отправленный заголовок <var>X_FORWARDED_FOR</var> соответствует отправленному в предыдущем запросе. Блокировка доступа по IP-адресу будет осуществляться по IP-адресам из заголовка <var>X_FORWARDED_FOR</var>.',
	'IP_VALID'						=> 'Проверка IP-адреса сессии',
	'IP_VALID_EXPLAIN'				=> 'Определяет, какая часть IP-адреса пользователя используется для проверки сессии. <samp>Полная</samp> означает проверку всего адреса, <samp>A.B.C</samp> - первых трёх чисел (x.x.x), <samp>A.B</samp> - первых двух чисел (x.x), <samp>Нет</samp> отключает проверку.',
	'MAX_LOGIN_ATTEMPTS'			=> 'Максимальное количество попыток входа',
	'MAX_LOGIN_ATTEMPTS_EXPLAIN'	=> 'После указанного количества неудачных попыток входа на конференцию пользователь должен будет дополнительно подтвердить свой вход (визуальное подтверждение)',
	'NO_IP_VALIDATION'				=> 'Нет',
	'NO_REF_VALIDATION'				=> 'Нет',
	'PASSWORD_TYPE'					=> 'Сложность пароля',
	'PASSWORD_TYPE_EXPLAIN'			=> 'Определяет, насколько сложным должен быть пароль при его установке или изменении. Каждый следующий вариант ограничения включает в себя предыдущие.',
	'PASS_TYPE_ALPHA'				=> 'Должен содержать буквенно-цифровые символы',
	'PASS_TYPE_ANY'					=> 'Требования отсутствуют',
	'PASS_TYPE_CASE'				=> 'Должен содержать символы разного регистра',
	'PASS_TYPE_SYMBOL'				=> 'Должен содержать символы',
    'REF_HOST'						=> 'Only validate host',
    'REF_PATH'						=> 'Also validate path',
    'REFERER_VALID'					=> 'Validate Referer',
    'REFERER_VALID_EXPLAIN'			=> 'If enabled, the referer of POST requests will be checked against the host/script path settings. This may cause issues with boards using several domains and or external logins.',

	'TPL_ALLOW_PHP'					=> 'Разрешить php в шаблонах',
	'TPL_ALLOW_PHP_EXPLAIN'			=> 'Если эта функция включена, команды <code>PHP</code> и <code>INCLUDEPHP</code> будут распознаваться и выполняться в шаблонах.',
));

// Email Settings
$lang = array_merge($lang, array(
	'ACP_EMAIL_SETTINGS_EXPLAIN'	=> 'Эта информация используется для отправки конференцией email-сообщений пользователям. Удостоверьтесь в правильности указанных email-адресов, все возвращённые или не доставленные сообщения будут, вероятно, отправлены на них. Если ваш сервер не обеспечивает использование встроенной (в PHP) службы email, вы можете отправлять сообщения напрямую с использованием SMTP. Для этого необходим адрес подходящего сервера (если нужно, спросите об этом у провайдера). Если сервер требует аутентификации (и только в этом случае), введите необходимые имя, пароль и метод аутентификации.',

	'ADMIN_EMAIL'					=> 'Обратный email-адрес',
	'ADMIN_EMAIL_EXPLAIN'			=> 'Этот адрес будет использован для возврата всех email-сообщений, как email-адрес для технических контактов. Он всегда будет использоватся в качестве адресов <samp>Return-Path</samp> и <samp>Sender</samp> в email-сообщениях.',
	'BOARD_EMAIL_FORM'				=> 'Рассылка email-сообщений через конференцию',
	'BOARD_EMAIL_FORM_EXPLAIN'		=> 'Пользователи смогут отправлять email-сообщения через конференцию вместо их обычной отправки.',
	'BOARD_HIDE_EMAILS'				=> 'Скрывать email-адреса',
	'BOARD_HIDE_EMAILS_EXPLAIN'		=> 'Эта функция полностью сохраняет в тайне email-адреса.',
	'CONTACT_EMAIL'					=> 'Контактный email-адрес',
	'CONTACT_EMAIL_EXPLAIN'			=> 'Этот адрес будет использоваться при каждой необходимости контакта, например, в случае спама, ошибок и т.п. Он всегда будет использоваться в качестве адресов <samp>From</samp> и <samp>Reply-To</samp> в email-сообщениях.',
	'EMAIL_FUNCTION_NAME'			=> 'Имя функции email',
	'EMAIL_FUNCTION_NAME_EXPLAIN'	=> 'Функция email, используемая для отправки сообщений через PHP.',
	'EMAIL_PACKAGE_SIZE'			=> 'Размер пакета email',
	'EMAIL_PACKAGE_SIZE_EXPLAIN'	=> 'Маскимальное количество email-сообщений, отправляемых за один раз. Эта настройка применяется для внутренней очереди сообщений; установите 0 при возникновении проблем, связанных с неотправленными уведомлениями по email.',
	'EMAIL_SIG'						=> 'Подпись в email-сообщении',
	'EMAIL_SIG_EXPLAIN'				=> 'Этот текст будет добавлен во все email-сообщения, отправляемые конференцией.',
	'ENABLE_EMAIL'					=> 'Включить email-сообщения',
	'ENABLE_EMAIL_EXPLAIN'			=> 'Если выключено, отправка любых email-сообщений с конференции производится не будет.',
	'SMTP_AUTH_METHOD'				=> 'Метод аутентификации для SMTP',
	'SMTP_AUTH_METHOD_EXPLAIN'		=> 'Используется только в случае, если заданы имя/пароль. Спросите у своего провайдера, еслы не уверены, какой метод аутентификации использовать.',
	'SMTP_CRAM_MD5'					=> 'CRAM-MD5',
	'SMTP_DIGEST_MD5'				=> 'DIGEST-MD5',
	'SMTP_LOGIN'					=> 'LOGIN',
	'SMTP_PASSWORD'					=> 'Пароль SMTP',
	'SMTP_PASSWORD_EXPLAIN'			=> 'Вводите пароль только в случае, если сервер SMTP требует этого.',
	'SMTP_PLAIN'					=> 'PLAIN',
	'SMTP_POP_BEFORE_SMTP'			=> 'POP-BEFORE-SMTP',
	'SMTP_PORT'						=> 'Порт сервера SMTP',
	'SMTP_PORT_EXPLAIN'				=> 'Изменяйте только в случае, если вам точно известно, что сервер использует другой порт.',
	'SMTP_SERVER'					=> 'Адрес сервера SMTP',
	'SMTP_SETTINGS'					=> 'Настройки SMTP',
	'SMTP_USERNAME'					=> 'Имя пользователя SMTP',
	'SMTP_USERNAME_EXPLAIN'			=> 'Вводите имя только в случае, если сервер SMTP требует этого.',
	'USE_SMTP'						=> 'Использовать SMTP для отправки email-сообщений',
	'USE_SMTP_EXPLAIN'				=> 'Выберите «Да», если вы хотите или должны отправлять email-сообщения через сервер вместо локальной функции mail.',
));

// Jabber settings
$lang = array_merge($lang, array(
	'ACP_JABBER_SETTINGS_EXPLAIN'	=> 'Здесь вы можете включать и управлять использованием Jabber для мгновенных сообщений и уведомлений с конференции. Jabber - это протокол с открытым исходным кодом и, следовательно, доступный для использования всеми желающими. Некоторые серверы Jabber имеют шлюзы или протоколы передачи, позволяющие связываться с пользователями в других сетях. Не все серверы предлагают все виды протоколов передачи, а изменения в протоколах могут не позволить им правильно работать. Удостоверьтесь, что введены данные уже существующей учётной записи - phpBB будет использовать их в том виде, в котором они заданы.',

	'JAB_ENABLE'				=> 'Включить Jabber',
	'JAB_ENABLE_EXPLAIN'		=> 'Включение позволяет использовать Jabber для отправки мгновенных сообщений и уведомлений',
	'JAB_GTALK_NOTE'			=> 'Учтите, что GTalk не будет работать, так как функция <samp>dns_get_record</samp> не найдена. Указанная функция недоступна в PHP4, и не реализована на Windows-платформах. В настоящее время функция также не работает на BSD-системах, включая Mac OS.',
	'JAB_PACKAGE_SIZE'			=> 'Размер пакета Jabber',
	'JAB_PACKAGE_SIZE_EXPLAIN'	=> 'Количество сообщений, отправляемых в одном пакете. Если установлен 0, сообщение отправляется немедленно, без постановки в очередь для последующей отправки.',
	'JAB_PASSWORD'				=> 'Пароль Jabber',
	'JAB_PORT'					=> 'Порт Jabber',
	'JAB_PORT_EXPLAIN'			=> 'Оставьте пустым, если вам известно, что используется порт, отличный от 5222',
	'JAB_SERVER'				=> 'Сервер Jabber',
	'JAB_SERVER_EXPLAIN'		=> 'Посетите %sjabber.org%s для получения списка серверов',
	'JAB_SETTINGS_CHANGED'		=> 'Настройки Jabber успешно изменены.',
	'JAB_USE_SSL'				=> 'Использовать SSL для соединения',
	'JAB_USE_SSL_EXPLAIN'		=> 'Если включено, будет произведена попытка установить безопасное соединение. Порт Jabber будет изменён на 5223, если ранее был указан порт 5222.',
	'JAB_USERNAME'				=> 'Имя пользователя Jabber',
	'JAB_USERNAME_EXPLAIN'		=> 'Укажите имя зарегистрированного пользователя. Заданное имя не будет проверено на достоверность.',
));


/*
 * Welcome PM on First Login (WPM)
 * By DualFusion
 */
$lang = array_merge($lang, array(
	'ACP_WELCOME_PM_EXPLAIN'	=> 'Here you are able to define what message newly registered users will recieve.',

	'WPM_SETTINGS'				=> 'Settings',
	'WPM_ENABLE'				=> 'Enable Welcome PM',
	'WPM_SEND_ID'				=> 'PM Sender ID',
	'WPM_SEND_ID_EXPLAIN'		=> 'The user id of the users that will "send" the PM.',

	'WPM_SUBJECT'				=> 'Subject',
	'WPM_SUBJECT_EXPLAIN'		=> 'The subject of the message that will be sent.',
	'WPM_MESSAGE'				=> 'Message',
	'WPM_MESSAGE_EXPLAIN'		=> 'The body of the message that the PM will contain.',
	'WPM_VARS'					=> 'Dyanamic Variables',
	'WPM_VARS_EXPLAIN'			=> 'Variables that will contain real data of registrant.',
	'WPM_VARIABLES'				=> '<strong>{USERNAME}</strong>: Username<br /><strong>{USER_IP}</strong>: Users\' IP<br /><strong>{USER_REGDATE}</strong>: Date of registration.<br /><strong>{USER_EMAIL}</strong>: User\'s email.<br /><strong>{SITE_NAME}</strong>: Your site\'s name.<br /><strong>{SITE_DESC}</strong>: Your site\'s description.',

	'WPM_PREVIEW'				=> 'Preview',
	'WPM_PREVIEW_EXPLAIN'		=> 'Preview of the message that will be sent.',
));
/* End WPM */


?>