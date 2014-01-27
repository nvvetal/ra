{assign var="current_city_id" value=$searchFilter.city_id}
{if $current_city_id > 0}
{assign var="city" value=$Geo->get_city($current_city_id)}
{assign var="country" value=$Geo->get_country($city.country_id)}
{assign var="subdivision" value=$Geo->get_subdivision($city.subdivision_id)}
{/if}

{assign var="current_subdivision_id" value=$searchFilter.subdivision_id}
{if $current_subdivision_id > 0}
{assign var="subdivision" value=$Geo->get_subdivision($current_subdivision_id)}
{assign var="country" value=$Geo->get_country($city.country_id)}
{/if}

{assign var="country_id" value=$searchFilter.country_id}
{if $country_id ne ''}
{assign var="country" value=$Geo->get_country($country_id)}
{/if}



<form method="GET" action="index.php">
<input type="hidden" name="go" value="schools" />
<input type="hidden" name="action" value="search_schools" />
<input type="hidden" name="per_page" value="{$per_page}" />
<input type="hidden" name="page" value="{$page}" />
<table width="100%" align="center">
<tr align="center">
    <td align="center">
                    <select name="country_id" onchange="xajax_get_school_country_subdivisions_search(this.options[this.selectedIndex].value);">
                    <option value="">{"Please select country"|i18n}</option>
                    {foreach from=$Geo->get_countries() item=country_data}
                    <option value="{$country_data.id}" {if $country_data.id == $country.id}selected{/if}>{$country_data.name}</option>   
                    {/foreach}
                    </select>                
                    <span id="subdivision_id">
                        {include file='modules/schools/i_search_country_subdivisions.tpl' subdivision_id=$subdivision.id country_id=$country.id }
                    </span>                
                    <span id="city_id">
                        {include file='modules/schools/i_cities_created.tpl' subdivision_id=$subdivision.id city_id=$current_city_id }
                    </span>
    </td>
</tr>
<tr>
    <td align="center">
        {"Order by"|i18n}
        <select name="order_by">
        <option value="last" {if $order_by == 'last'}selected{/if}>{"Last"|i18n}</option>
        <option value="name" {if $order_by == 'name'}selected{/if}>{"Name"|i18n}</option>
        </select>
		
		<input type="submit" name="btnSubmit" value="{"Search school"|i18n}">
	</td>
</tr>

</table>

</form>