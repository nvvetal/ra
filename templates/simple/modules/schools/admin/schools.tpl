{include file='modules/schools/i_javascript.tpl'}
{assign var="page" value=$smarty.request.page|default:1}
{assign var="per_page" value=$smarty.request.per_page|default:1000}
{assign var="city_id" value=$smarty.request.city_id|default:'all'}


<table width="100%" align="center">
    <tr>
	<td>{"ID"|i18n}</td>
	<td>{"City"|i18n}</td>
	<td>{"Name"|i18n}</td>
	<td>{"Info"|i18n}</td>
	<td>{"Operations"|i18n}</td>
    </tr>
    {foreach name="simple" from=$school->get_schools($page,$per_page,$city_id,0) item="schoolData"}
	<tr>
	    <td>
    		{$schoolData.id}
	    </td>    
	    <td>
            {assign var="city" value=$Geo->get_city($schoolData.city_id)}
            {$city.name|default:'Unknown city'|i18n}
	    </td>    
	    <td>
    		{$schoolData.name}
	    </td>    
        <td>
            <a href="?s={$s}&ago=edit_school&school_id={$schoolData.id}&r_go=schools&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Edit"|i18n}</a>
            <a href="?s={$s}&action=school_top&school_id={$schoolData.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Make school Top"|i18n}</a>
            <br/>
            {if $school->is_school_vip_active($schoolData.id) == true}
             	{assign var="VIPData" value=$school->get_vip_school_data($schoolData.id)}
              	{"School VIP valid till"|i18n} {$VIPData.end_time|date_format:'%d.%m.%Y %H:%M'}
            {else}           
               	<a href="?s={$s}&action=school_vip&school_id={$schoolData.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Make school VIP"|i18n}</a>
            {/if}            
        </td>
	    <td>
            {if $schoolData.is_approved == 1}
                <a href="javascript:void(0);" onclick="return disable_school('?s={$s}&action=disable_school&school_id={$schoolData.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}');">{"Disable"|i18n}</a>
            {else}
                <a href="?s={$s}&action=enable_school&school_id={$schoolData.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Enable"|i18n}</a>
            {/if}
            <a href="?s={$s}&action=delete_school&school_id={$schoolData.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Delete"|i18n}</a>
	    </td>
	</tr>
    {foreachelse}
	<tr align="center">
		<td colspan="5">
		    {"No schools found"|i18n}
		</td>
	</tr>
    {/foreach}
</table>