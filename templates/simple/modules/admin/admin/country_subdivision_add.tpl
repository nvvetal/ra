{assign var="country_id" value=$smarty.request.country_id}
{include file='i_error.tpl'}
<form method="post" action="{$http_module_path}index.php">
{"Country"|i18n}
<select name="country_id">
{foreach name="country" from=$Geo->get_countries() item=country}
{if $country_id eq '' && $smarty.foreach.country.first==true}{assign var="country_id" value=$country.id}{/if}
<option value="{$country.id}" {if $country.id == $country_id}selected{/if}>{$country.name}</option>
{/foreach}
</select><br/>
{"Subdivision name"|i18n} <input type="text" name="name" value="{$smarty.request.name}" /><br/>
<input type="submit" name="btnSubmit" value="{"Add subdivision"|i18n}" />
<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=city'" />

<input type="hidden" name="s" value="{$s}">
<input type="hidden" name="ago" value="city">
<input type="hidden" name="action" value="country_subdivision_add">
<input type="hidden" name="a_id" value="{$smarty.request.a_id}">
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}">
</form>