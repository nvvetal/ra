<select name="city_id" style="width:100%">						
{foreach from=$Geo->get_cities_by_subdivision($subdivision_id) item=city_data}
<option value="{$city_data.id}" {if $city_id == $city_data.id}selected{/if}>{$city_data.name}</option>
{/foreach}
</select>