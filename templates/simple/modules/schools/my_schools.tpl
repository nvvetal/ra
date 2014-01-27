{include file='header.tpl'}
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
{assign var="page" value=$smarty.request.page|default:1}
{assign var="per_page" value=$smarty.request.per_page|default:10}
<div class="title">{"My Schools"|i18n}</div>
<table width="100%" align="center">
    <tr align="center">
        <td colspan="6">
            <a href="{$http_project_path}schools/?go=add_school&s={$s}" title="{"Add school"|i18n}"><img src="{$http_images_static_path}icons/add_24x24.png" alt="{"Add school"|i18n}" /></a>&nbsp;<a href="{$http_project_path}schools/?s={$s}&go=schools" title="{"Dancing Schools"|i18n}"><img src="{$http_images_static_path}icons/database_24x24.png" alt="{"Dancing Schools"|i18n}" /></a>
        </td>
    </tr>
    {foreach name="simple" from=$school->get_user_schools($user_id) item="current_school"}
        <tr valign="top" style="height: 70px;">
            <td>
                {math equation="(page - 1) * per_page + cur_pos" page=$page per_page=$per_page cur_pos = $smarty.foreach.simple.iteration}.
            </td>
            <td>
                <a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$current_school.id}">{$current_school.name}</a>
            </td>
            <td style="font-size:80%;">
                <a href="{$http_project_path}schools/?s={$s}&go=edit_school&school_id={$current_school.id}">{"Edit school"|i18n}</a>
            </td>
            <td style="font-size:80%;">
                <a href="{$http_project_path}schools/?s={$s}&go=my_schools&action=delete_school&school_id={$current_school.id}">{"Delete school"|i18n}</a>
            </td>
            <td style="font-size:80%;">
                {if $current_school.is_approved == 1}
                {if $school->is_school_vip_active($current_school.id) == true}
                	{assign var="VIPData" value=$school->get_vip_school_data($current_school.id)}
                	{"School VIP valid till"|i18n} {$VIPData.end_time|date_format:'%d.%m.%Y %H:%M'}<br/>                 
                {else}           
                	<a href="{$http_project_path}schools/?s={$s}&go=schoolVIP&school_id={$current_school.id}">{"Make my school VIP"|i18n}</a><br/>
                {/if}
                <a href="{$http_project_path}schools/?s={$s}&go=schoolTop&school_id={$current_school.id}">{"Make my school Top"|i18n}</a><br/>
                {/if}
            </td>
            <td style="font-size:80%;">
                {if $current_school.is_approved == 1}
                    {"School was approved"|i18n}
                {elseif $current_school.is_approved == 0}
                    {"School was not moderated yet"|i18n}
                {elseif $current_school.is_approved == -1}
                    {"School was moderated and stricted"|i18n}
                {/if}           
            </td>
        </tr>
    {foreachelse}
        <tr align="center">
            <td colspan="6">
                {"You doesn't have schools"|i18n}
            </td>
        </tr>
    {/foreach}
</table>
{include file='footer.tpl'}