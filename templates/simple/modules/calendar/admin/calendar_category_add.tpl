{include file='i_error.tpl'}
<form method="post" action="{$http_module_path}index.php">

{"Calendar category name"|i18n} <input type="text" name="name" value="{$smarty.request.name}" />
<br/>
{"Calendar Forum"|i18n}<br/>
{include file='modules/calendar/admin/i_calendar_forums.tpl' pid=0 iteration=0}
<br/>
<input type="submit" name="btnSubmit" value="{"Add calendar category"|i18n}" />
<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendar_categories'" />

<input type="hidden" name="s" value="{$s}">
<input type="hidden" name="ago" value="calendar_categories">
<input type="hidden" name="action" value="calendar_category_add">
<input type="hidden" name="a_id" value="{$smarty.request.a_id}">
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}">
</form>