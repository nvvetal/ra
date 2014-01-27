<a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=country_add">{"add country"|i18n}</a>
<a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=country_subdivision_add">{"add subdivision"|i18n}</a>
<a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=city_add">{"add city"|i18n}</a>
<table width="100%" border="1">
{foreach from=$Geo->get_countries() item=country}
    <tr>
        <td align="center" colspan="2">
            <h1>{$country.name}</h1>
            <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=country_edit&country_id={$country.id}">{"edit country"|i18n}</a>
            <a href="javascript:void(0);" onclick="if(confirm('{"Are you sure?"|i18n}'))window.location.href='{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=city&action=country_delete&country_id={$country.id}'">{"delete country"|i18n}</a>
        </td>
    </tr>
    {foreach from=$Geo->get_subdivisions($country.id) item=subdivision}
        <tr>
            <td width="80%">
                <b>{$subdivision.name}</b>
            </td>
            <td>
                <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=country_subdivision_edit&subdivision_id={$subdivision.id}">{"edit subdivision"|i18n}</a>
                <a href="javascript:void(0);" onclick="if(confirm('{"Are you sure?"|i18n}'))window.location.href='{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=city&action=country_subdivision_delete&subdivision_id={$subdivision.id}';">{"delete subdivision"|i18n}</a>
            </td>
        </tr>
        {foreach from=$Geo->get_cities_by_subdivision($subdivision.id) item=city}
        <tr>
            <td width="80%">
                {$city.name}
            </td>
            <td>
                <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=city_edit&city_id={$city.id}">{"edit city"|i18n}</a>
                <a href="javascript:void(0);" onclick="if(confirm('{"Are you sure?"|i18n}'))window.location.href='{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=city&action=city_delete&city_id={$city.id}';">{"delete city"|i18n}</a>
            </td>
        </tr>
        {foreachelse}
        <tr>
            <td colspan="2">
                {"No cities found"|i18n}
            </td>
        </tr>    
        {/foreach}
    {foreachelse}
    <tr>
        <td colspan="2">
            {"No subdivisions found"|i18n}
        </td>
    </tr>
    {/foreach}
{foreachelse}
    <tr>
        <td>
            {"No countries found"|i18n}
        </td>
    </tr>
{/foreach}
</table>