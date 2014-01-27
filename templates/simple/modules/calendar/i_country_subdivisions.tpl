<select name="subdivision_id" onchange="xajax_get_calendar_subdivision_cities(this.options[this.selectedIndex].value);" style="width:100%">
<option value="">{"Please select"|i18n}</option>
{foreach from=$Geo->get_subdivisions($country_id) item=subdivision_data}
<option value="{$subdivision_data.id}" {if $subdivision_data.id == $subdivision_id}selected{/if}>{$subdivision_data.name}</option>
{/foreach}
</select>
<br/>