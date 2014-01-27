{"Subdivision"|i18n}
<select name="subdivision_id">
<option value="">{"Please select"|i18n}</option>
{foreach from=$Geo->get_subdivisions($country_id) item=subdivision}
<option value="{$subdivision.id}" {if $subdivision.id == $subdivision_id}selected{/if}>{$subdivision.name}</option>
{/foreach}
</select>
<br/>