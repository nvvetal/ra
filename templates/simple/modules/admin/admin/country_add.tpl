{include file='i_error.tpl'}
<form method="post" action="{$http_module_path}index.php">

{"Country name"|i18n} <input type="text" name="name" value="{$smarty.request.name}" /><br/>
{"Country short name"|i18n} <input type="text" name="short_name" size="3" value="{$smarty.request.short_name}" /><br/>

<input type="submit" name="btnSubmit" value="{"Add country"|i18n}" />
<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=city'" />

<input type="hidden" name="s" value="{$s}">
<input type="hidden" name="ago" value="city">
<input type="hidden" name="action" value="country_add">
<input type="hidden" name="a_id" value="{$smarty.request.a_id}">
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}">
</form>