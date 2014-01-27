{include file='modules/calendar/i_javascript.tpl'}
<table width="100%" border="1">
    <tr>
        <td>{"Calendar name"|i18n}</td>
        <td>{"Calendar category"|i18n}</td>
        <td>{"Calendar date"|i18n}</td>
        <td>{"Calendar creator"|i18n}</td>
        <td>{"Calendar organizator"|i18n}</td>
        <td>{"Status"|i18n}</td>        
        <td>{"Calendar options"|i18n}</td>
    </tr>
{foreach from=$calendar->get_calendars_not_approved() item=calendar_data}
{assign var="category" value=$calendar->get_category($calendar_data.category_id)}
    <tr>
        <td>
            {$calendar_data.name|strip_tags}
        </td>
        <td>
            {$category.name}
        </td>
        <td>
            {$calendar_data.bdate|date_format:'%d.%m.%Y'}
        </td>
        <td>
            <a href="{$http_project_path}?s={$s}&go=profile&user_id={$calendar_data.creator_id}" target="_blank">{$User->get_value($calendar_data.creator_id,'login')}</a>
        </td>
        <td>
            {$calendar_data.organizator_name}
        </td>   
	    <td>
	       {if $calendar_data.is_approved == 0}
	           {"Waiting for moderate"|i18n}
	       {else}
	           {"Moderatred, not changed by user"|i18n}
	       {/if}
	    </td>             
        <td>
            <a target="_blank" href="{$http_project_path}calendar/index.php?s={$s}&go=view_calendar&calendar_id={$calendar_data.id}">{"view calendar"|i18n}</a><br/>
            <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendars_not&calendar_id={$calendar_data.id}&action=calendar_approve">{"Approve calendar"|i18n}</a><br/>
            <a href="javascript:void(0);" onclick="return disable_calendar('{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendars_not&calendar_id={$calendar_data.id}&action=calendar_disable');">{"Disable calendar"|i18n}</a><br/>
            <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendars_not&calendar_id={$calendar_data.id}&action=calendar_delete">{"Delete calendar"|i18n}</a><br/>
        </td>
    </tr>
{foreachelse}
    <tr>
        <td colspan="7">
            {"No new calendars found"|i18n}
        </td>
    </tr>
{/foreach}
</table>