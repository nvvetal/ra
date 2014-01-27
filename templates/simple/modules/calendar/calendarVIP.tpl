{include file='header.tpl'}
{assign var="calendarData" value=$calendar->get_calendar($smarty.request.calendar_id)}
<center><h2><img src="{$http_images_static_path}hmeropriayatia.jpg" alt=""/></h2></center>
<div class="title" style="font-size: 120%;font-weight: bold">{"Make Calendar VIP"|i18n} {$calendarData.name}</div>
{if $smarty.request.is_success != 1}
    {include file='i_error.tpl'}
    {"Calendar VIP description text"|i18n}<br/><br/>
    {if $calendarData->is_vip eq 'Y'}
        {"Calendar VIP is active"|i18n}
    {/if}
	{assign var="raks_cost" value=$calendar->get_cost('makeCalendarVIP')}
    {"Calendar VIP costs"|i18n} {$raks_cost} {$raks_cost|raks_name}<br/><br/>
    {include file='i_raks_money.tpl'}<br/>
    <button onclick="window.location.href='{$http_project_path}calendar/?s={$s}&go=calendarVIP&calendar_id={$smarty.request.calendar_id}&action=makeCalendarVIP'">{"Make VIP"|i18n}</button><br/><br/><br/>
{else}
    <br/>{"Calendar VIP success text"|i18n}<br/><br/>
{/if}
<a href="{$http_project_path}calendar/?s={$s}&go=view_calendar&calendar_id={$smarty.request.calendar_id}">{"back to calendar"|i18n}</a>
{include file='footer.tpl'}