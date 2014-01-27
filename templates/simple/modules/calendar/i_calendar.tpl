<h2 class="main"><img src="{$http_images_static_path}hmeropriayatia.jpg" alt=""/></h2>
{if isset($smarty.request.current_month) && $smarty.request.current_month != ''}
    {assign var="current_year" value=$smarty.request.current_year}
    {assign var="current_month" value=$smarty.request.current_month}
{else}
    {assign var="current_year" value="now"|date_format:"%Y"}
    {assign var="current_month" value="now"|date_format:"%m"}
{/if}
{assign var="next_month" value=$Utils->get_next_month($current_year,$current_month,'+')}
{assign var="prev_month" value=$Utils->get_next_month($current_year,$current_month,"-")}

{if $Session->get_value($s,'is_logged') != 0 && $isAddCalendar==1}
    <a href="{$http_project_path}calendar/index.php?s={$s}&go=add_calendar">{"Add calendar action"|i18n:'calendar'}</a><br/><br/>
{/if}
<div class="calendar" id="cal-tabs">
    <ul>
        {foreach name="month_data" from=$Utils->get_months() item=month_data}
            <li><a href="#cal-tabs-{$smarty.foreach.month_data.index}">{$month_data.month|i18n:'calendar'}</a></li>
        {/foreach}
    </ul>
    {if $current_month == $month_data.month_short}selected{/if}
    {foreach name="month_data" from=$Utils->get_months() item=month_data}
        <div id="cal-tabs-{$smarty.foreach.month_data.index}">
            <table class="caltable" width="100%">
                <tr align="center">
                    <td>{"Date"|i18n:'calendar'}</td>
                    <td>{"City"|i18n:'calendar'}</td>
                    <td>{"Category"|i18n:'calendar'}</td>
                    <td>{"Name"|i18n:'calendar'}</td>
                    <td>{"Organizator"|i18n:'calendar'}</td>
                </tr>
                {assign var="counter" value=0}
                {foreach from=$Utils->get_month_days($current_year,$month_data.month_short) item=day_data}
                    {assign var="calendars" value=$calendar->get_calendars_by_month($current_year,$month_data.month_short)}
                    {assign var="cur_day" value=$day_data.ymd_representation}
                    {if isset($calendars[$day_data.ymd_representation])}
                        {foreach name="clz" from=$calendars[$day_data.ymd_representation] item=current_calendar}
                            {assign var="counter" value=1}
                            <tr>
                                {if $cur_day != 0}
                                    <td rowspan="{$smarty.foreach.clz.total}">{$day_data.ymd_representation|date_format:'%d.%m.%Y'}</td>
                                    {assign var=cur_day value=0}
                                {/if}
                                <td {if $current_calendar.is_vip == 'Y'}style="font-weight: bold"{/if}>
                                    {assign var="city" value=$Geo->get_city($current_calendar.city_id)}
                                    {$city.name}
                                </td>
                                <td {if $current_calendar.is_vip == 'Y'}style="font-weight: bold"{/if}>
                                    {assign var="category" value=$calendar->get_category($current_calendar.category_id)}
                                    {$category.name}
                                </td>
                                <td {if $current_calendar.is_vip == 'Y'}style="font-weight: bold"{/if}>
                                    <a href="{$http_project_path}calendar/?go=view_calendar&s={$s}&calendar_id={$current_calendar.id}&current_year={$current_year}&current_month={$current_month}">{$current_calendar.name}</a>
                                </td>
                                <td {if $current_calendar.is_vip == 'Y'}style="font-weight: bold"{/if}>
                                    {$current_calendar.organizator_name}
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                {/foreach}
                {if $counter == 0}
                    <tr>
                        <td colspan="5" align="center">{"calendar no actions"|i18n:'calendar'}</td>
                    </tr>
                {/if}
            </table>
        </div>
    {/foreach}

</div>