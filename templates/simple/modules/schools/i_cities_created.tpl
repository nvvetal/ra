<select name="city_id">		
<option value="">{"Please select City"|i18n}</option>
{foreach from=$school->get_school_cities_by_subdivision($subdivision_id) item=city_data}
<option value="{$city_data.id}" {if $city_id == $city_data.id}selected{/if}>{$city_data.name}</option>
{/foreach}
</select>