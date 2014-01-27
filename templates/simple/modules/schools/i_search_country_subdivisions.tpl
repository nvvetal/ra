<select name="subdivision_id" onchange="xajax_get_school_subdivision_cities_created(this.options[this.selectedIndex].value);">
<option value="">{"Please select Region"|i18n}</option>
{foreach from=$Geo->get_subdivisions($country_id) item=subdivision_data}
<option value="{$subdivision_data.id}" {if $subdivision_data.id == $subdivision_id}selected{/if}>{$subdivision_data.name}</option>
{/foreach}
</select>