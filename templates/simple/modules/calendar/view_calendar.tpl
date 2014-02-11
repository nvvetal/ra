{include file='header.tpl' script='modules/calendar/i_javascript.tpl'}
{assign var="calendar_data" value=$calendar->get_calendar($smarty.request.calendar_id)}
<center><h2><img src="{$http_images_static_path}hmeropriayatia.jpg" alt=""/></h2></center>
<div class="title" style="font-size: 120%;font-weight: bold">{$calendar_data.name|strip_tags}{if $calendar_data.is_vip == 'Y'}<img src="{$http_images_static_path}icons/star_24x24.png" alt="{"VIP"|i18n}"/>{/if}</div>
<br/><br/>
<table align="center" width="100%">
    <tr valign="top">
        <td>{"Begin Date"|i18n}</td>
        <td>{$calendar_data.bdate}</td>
    </tr>

    <tr valign="top">
        <td>{"End Date"|i18n}</td>
        <td>{$calendar_data.edate}</td>
    </tr>

    <tr valign="top">
        <td>{"Address"|i18n}</td>
        <td>
            {assign var="country_id" value=$Geo->get_country_id_by_city($calendar_data.city_id)}
            {assign var="country" value=$Geo->get_country($country_id)}
            {assign var="city" value=$Geo->get_city($calendar_data.city_id)}
            {$country.name} {$city.name} {$calendar_data.address}
        </td>

    </tr>

    <tr valign="top">
        <td>{"Category"|i18n}</td>
        <td>
            {assign var="category" value=$calendar->get_category($calendar_data.category_id)}
            {$category.name}
        </td>
    </tr>

    <tr valign="top">
        <td>{"Name"|i18n}</td>
        <td>
            {$calendar_data.name|strip_tags}
        </td>
    </tr>

    <tr valign="top">
        <td>{"Full info"|i18n}</td>
        <td>
            {$calendar_data.full_info|bbcode}
        </td>
    </tr>

    <tr valign="top">
        <td>{"Organizator full name"|i18n}</td>
        <td>
            {$calendar_data.organizator_name|strip_tags}
        </td>
    </tr>

    {foreach name="lfm" from=$calendar->get_calendar_additional_info($smarty.request.calendar_id,'lfm') item=lfm }
        {assign var="lfm_iteration" value=$smarty.foreach.lfm.iteration-1}
        {assign var="phone" value=$calendar->get_calendar_additional_info($smarty.request.calendar_id,'phone',$lfm_iteration)}
        <tr valign="top">
            <td>
                {"LFM"|i18n}
            </td>
            <td>
                {$lfm}
            </td>
        </tr>
        {if $phone ne ''}
            <tr valign="top">
                <td>
                    {"Phone"|i18n}
                </td>
                <td>
                    {$phone}
                </td>
            </tr>
        {/if}
    {/foreach}
    {foreach name="web" from=$calendar->get_calendar_additional_info($smarty.request.calendar_id,'web') item=web }
        {assign var="web_iteration" value=$smarty.foreach.web.iteration-1}
        <tr valign="top">
            <td>
                {"WEB"|i18n}
            </td>
            <td>
                {$web}
            </td>
        </tr>
    {/foreach}
    {foreach name="email" from=$calendar->get_calendar_additional_info($smarty.request.calendar_id,'email') item=email }
        {assign var="email_iteration" value=$smarty.foreach.email.iteration-1}
        <tr valign="top">
            <td>
                {"EMAIL"|i18n}
            </td>
            <td>
                {mailto address=$email encode="hex"}
            </td>
        </tr>
    {/foreach}
</table>

<center>
    <a href="?go=calendar&s={$s}&current_year={$smarty.request.current_year}&current_month={$smarty.request.current_month}" title="{"Back"|i18n}"><img src="{$http_images_static_path}icons/left_arrow_24x24.png" alt="{"Back"|i18n}"/></a>
    {if $calendar_data.creator_id == $user_id || $User->get_value($user_id,'type') == 'admin' || $User->get_value($user_id,'type') == 'moderator'}
        <a href="?go=edit_calendar&s={$s}&calendar_id={$smarty.request.calendar_id}" title="{"Edit"|i18n}"><img src="{$http_images_static_path}icons/edit_24x24.png" alt="{"Edit"|i18n}"/></a>
        {if $calendar_data.is_vip == 'N'}
            <span id="vip"><a href="?go=calendarVIP&s={$s}&calendar_id={$smarty.request.calendar_id}" title="{"MakeVIP"|i18n}"><img src="{$http_images_static_path}icons/star_24x24.png" alt="{"MakeVIP"|i18n}"/></a></span>
        {/if}
    {/if}
</center>
{include file='footer.tpl'}