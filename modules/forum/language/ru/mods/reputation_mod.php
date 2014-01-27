<?php
/**
*
* groups [English]
*
* @author idiotnesia pungkerz@gmail.com - http://www.phpbbindonesia.com
*
* @package language
* @version 0.2.0a
* @copyright (c) 2008 phpbbindonesia.com
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	
	'ACP_REPUTATION_SETTINGS_EXPLAIN'	=> 'Здесь вы можете разместить настроечные параметры пунктов пользовательской репутации.',
	'ACP_REP_RANKS_EXPLAIN'				=> 'Используя эту форму можно добавлять, радактировать, удалять ранги репутации. ',
	'RP_BLOCK_PER_POINTS'		=> 'Блокируйте за пункты',
	'RP_BLOCK_PER_POINTS_EXPLAIN'	=> 'Добавить 1 блокировку при достижении Х пунктов репутации.',
	'RP_COMMENTS'				=> 'Комментарии',
	'RP_DISABLED'				=> 'Извините, Админ заблокировал эту возможность.',
	'RP_ENABLE'					=> 'Включить репутацию пользователей',
	'RP_FROM'					=> 'От',
	'RP_SAME_POST'				=> 'Вы уже дали репу за этот пост',
	'RP_MAX_BLOCK'				=> 'Максимальный блок',
	'RP_MAX_BLOCK_EXPLAIN'		=> 'Максимальное число показанного блока.',
	'RP_MAX_CHARS'				=> 'Максимум символов в комментарии',
	'RP_MAX_CHARS_EXPLAIN'		=> 'Число символов доступное в камментарии, поставте 0 для снятия ограничения.',
	'RP_MAX_POWER'				=> 'Максимальный уровень репутации',
	'RP_MAX_POWER_EXPLAIN'		=> 'Максимальный уровень репутации достигнут.',
	'RP_MEMBERSHIP_DAYS'		=> 'Фактор времени пользователя',
	'RP_MEMBERSHIP_DAYS_EXPLAIN'	=> 'Пользователь получает 1 репу через каждые Х дней.',
	'RP_MIN_POSTS'				=> 'Минимум сообщений',
	'RP_MIN_POSTS_EXPLAIN'		=> 'Минимум сообщений до появления репутации.',
	'RP_POINTS'					=> 'Пункты',
	'RP_POWER'					=> 'Ранг репутации',
	'RP_RECENT_POINTS'			=> 'Назавние пунктов репутации',
	'RP_RECENT_POINTS_EXPLAIN'	=> 'Репутация показывается в профиле пользователя.',
	'RP_SELF'					=> 'Подымать репу себе это все равно что ...',
	'RP_SENT'					=> 'Your reputation point has been sent successfully',
	'RP_TIMES_LIMIT'			=> 'Ваш пункт репутации отправлен успешно.',
	'RP_TIME_LIMITATION'		=> 'Лимит времени',
	'RP_TIME_LIMITATION_EXPLAIN'	=> 'Минимальное время перед тем как пользователю можно дать еще репутацию.',
	'RP_TITLE'					=> 'Пункты репутации пользователя',
	'RP_TOO_LONG_COMMENT'		=> 'Ваш комментарий содержит %1$d Символов. Максимально возможное число символов %2$d.',
	'RP_TOTAL_POINTS'			=> 'Пункты репутации',
	'RP_TOTAL_POSTS'			=> 'Фактор сообщений',
	'RP_TOTAL_POSTS_EXPLAIN'	=> 'Пользователь получает 1 репу через каждые Х постов.',
	'RP_USER_DISABLED'			=> 'Вы не можете дать репутацию.',
	'RP_USER_SELF_DISABLED'		=> 'Этот пользователь заблокировал репутацию.',
	
	'RP_EMPTY_DATA'				=> 'Пользователь не получил репутации.',
	
	'RP_USER_SPREAD'			=> 'Распространение репутации',
	'RP_USER_SPREAD_EXPLAIN'	=> 'Дайте репутацию каому нибудь другому прежде чем снова дать ее этому пользователю.',
	'RP_USER_SPREAD_FIRST'		=> 'Вы должны сначала дать репутацию кому нибудь другому прежде чем повторно давать ее одному пользователю.',
	'RP_REG_BONUS'				=> 'Бонус репутации при регистрации',
	'RP_REG_BONUS_EXPLAIN'		=> 'После регистрации сразу будет дан бонус репутации.',
	
	'RP_COMMENT'				=> 'Комментарий',
	'RP_POSITIVE'				=> 'Хорошо',
	'RP_NEGATIVE'				=> 'Плохой',
	
	'RP_HIDE'					=> 'Скройте мою репутацию',
	'RP_GROUP_POWER'			=> 'Репутация группы',
	
	'RP_ADD_POINTS'				=> 'Добавить пункт репутации',
	'RP_SUBTRACT_POINTS'		=> 'Вычесть пункт репутации',
	'RP_DISPLAY'				=> 'Показывать репутацию',
	'RP_DISPLAY_TEXT'			=> 'Текст',
	'RP_DISPLAY_BLOCK'			=> 'Блок',
	'RP_DISPLAY_BOTH'			=> 'Оба',
	
	
	'RP_FORCE_COMMENT'			=> 'Комментарий пользователя обязателен',
	'RP_DISABLE_COMMENT'		=> 'Отключить комменты репутации',
	'RP_FORUM_EXCLUSIONS'		=> 'Исключения форума',
	'RP_FORUM_EXCLUSIONS_EXPLAIN'	=> 'Введите ID форума что бы убрать на нем репутацию, eg. 3,4,6',
	'RP_POWER_REP_POINT'		=> 'Факторы пунктов репутации',
	'RP_POWER_REP_POINT_EXPLAIN'	=> 'Пользователю добавляется 1 пункт репы после каждых Х пунктов репы.',
	
	'RP_RANK_TITLE'				=> 'Заглавие',
	'RP_RANK_MINIMUM'			=> 'Минимум пунктов',
	'RP_ADD_RANK'				=> 'Добавить разряд',
	'RP_NO_RANK_TITLE'			=> 'Вы должны ввести заголовок для разряда',
	'RP_RANK_UPDATED'			=> 'Разряд был успешно обновлен.',
	'RP_RANK_ADDED'				=> 'Разряд успешно добавлен.',
	'RP_MUST_SELECT_RANK'		=> 'Вы должны выбрать разряд',
	
	'RP_RESET'					=> 'Сбросить репутацию',
	'RP_RESET_EXPLAIN'			=> 'Удалит все комменты репутации и сбросит репу на 0.',
	'RP_RESET_CONFIRM'			=> 'Вы уверены что хотите сбросить репутацию?<br />Это действие не может быть отменено.',
	
));

?>