{assign var="category" value=$calendar->get_category($smarty.request.category_id)}
{include file='i_error.tpl'}
<form method="post" action="{$http_module_path}index.php">

{"Calendar category name"|i18n} <input type="text" name="name" value="{$smarty.request.name|default:$category.name}" />
<br/>
{"Calendar Forum"|i18n}<br/>
{include file='modules/calendar/admin/i_calendar_forums.tpl' pid=0 iteration=0 forumIdS=$category.forum_id}
<br/>
<input type="submit" name="btnSubmit" value="{"Edit calendar category"|i18n}" />
<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendar_categories'" />

<input type="hidden" name="s" value="{$s}">
<input type="hidden" name="ago" value="calendar_categories">
<input type="hidden" name="action" value="calendar_category_edit">
<input type="hidden" name="category_id" value="{$smarty.request.category_id}">
<input type="hidden" name="a_id" value="{$smarty.request.a_id}">
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}">
</form>