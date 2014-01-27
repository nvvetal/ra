{include file='modules/calendar/i_javascript.tpl'}
{if isset($smarty.request.current_month)}
    {assign var="current_year" value=$smarty.request.current_year}
    {assign var="current_month" value=$smarty.request.current_month}
{else}
    {assign var="current_year" value="now"|date_format:"%Y"}
    {assign var="current_month" value="now"|date_format:"%m"}
{/if}

{assign var="next_month" value=$Utils->get_next_month($current_year,$current_month,'+')}
{assign var="prev_month" value=$Utils->get_next_month($current_year,$current_month,"-")}
{assign var="calendars" value=$calendar->get_calendars_by_month($current_year,$current_month)}
<div class="calendar">
<table width="100%" border="1">
    <tr align="center">
    {foreach from=$Utils->get_months() item=month_data}
        <td {if $current_month == $month_data.month_short}style="background-color:green;"{/if}>
            <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendars&current_year={$current_year}&current_month={$month_data.month_short}">{$month_data.month|i18n}</a>
        </td>
    {/foreach}
    </tr>
</table>
<table border="1" width="100%">
    <tr align="center">
	   <td>{"Date"|i18n}</td>
	   <td>{"City"|i18n}</td>
	   <td>{"Category"|i18n}</td>
	   <td>{"Name"|i18n}</td>
	   <td>{"Small Info"|i18n}</td>
	   <td>{"Organizator"|i18n}</td>
	   <td>{"Operation"|i18n}</td>
    </tr>
{assign var="counter" value=0}    
{foreach from=$Utils->get_month_days($current_year,$current_month) item=day_data} 
 
    {assign var="cur_day" value=$day_data.ymd_representation}
    {if isset($calendars[$day_data.ymd_representation])}
	{foreach name="clz" from=$calendars[$day_data.ymd_representation] item=current_calendar} 
	{assign var="counter" value=1}  
    <tr>
        {if $cur_day != 0}
		<td rowspan="{$smarty.foreach.clz.total}">{$day_data.ymd_representation|date_format:'%d.%m.%Y'}</td>
            {assign var=cur_day value=0}
        {/if}
	    <td>
            {assign var="city" value=$Geo->get_city($current_calendar.city_id)}
            {$city.name}
	    </td>
	    <td>
            {assign var="category" value=$calendar->get_category($current_calendar.category_id)}
            {$category.name}
	    </td>
	    <td>
            <a target="_blank" href="{$http_project_path}calendar/?go=view_calendar&s={$s}&calendar_id={$current_calendar.id}&current_year={$current_year}&current_month={$current_month}">{$current_calendar.name}</a>
	    </td>	    
	    <td>
            {$current_calendar.small_info}
	    </td>
	    <td>
		{$current_calendar.organizator_name}
	    </td>
	    <td>
            <a href="javascript:void(0);" onclick="return disable_calendar('{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendars&calendar_id={$current_calendar.id}&action=calendar_disable&current_year={$current_year}&current_month={$current_month}');">{"Disable calendar"|i18n}</a><br/>
            <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendars_not&calendar_id={$current_calendar.id}&action=calendar_delete&current_year={$current_year}&current_month={$current_month}">{"Delete calendar"|i18n}</a><br/>	       
	    </td>
    </tr>
	{/foreach}
    {/if}    
{/foreach}    
{if $counter == 0}
    <tr>
        <td colspan="7" align="center">{"calendar no actions"|i18n}</td>
    </tr>    
{/if}    
</table>
</div>