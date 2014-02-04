{include file='header.tpl'}
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
{assign var="current_school" value=$school->get_school($smarty.request.school_id)}
{assign var="city" value=$Geo->get_city($current_school.city_id)}
{assign var="country" value=$Geo->get_country($city.country_id)}
<div class="title_school">{"School"|i18n} "{$current_school.name}"</div>
<center>
    {if $user_id ne ''}
        <a href="{$http_project_path}schools/?s={$s}&go=add_school" title="{"Add school"|i18n}"><img src="{$http_images_static_path}icons/add_24x24.png" alt="{"Add school"|i18n}" /></a>
    {/if}
    {if $current_school.owner_id == $user_id}
        <a href="{$http_project_path}schools/?s={$s}&go=edit_school&school_id={$current_school.id}" title="{"Edit school"|i18n}"><img src="{$http_images_static_path}icons/edit_24x24.png" alt="{"Edit school"|i18n}" /></a>
        {if $school->is_school_vip_active($current_school.id) == false}
            <a href="{$http_project_path}schools/?s={$s}&go=schoolVIP&school_id={$current_school.id}" title="{"Make my school VIP"|i18n}"><img src="{$http_images_static_path}icons/star_24x24.png" alt="{"Make my school VIP"|i18n}" /></a>
        {/if}
        <a href="{$http_project_path}schools/?s={$s}&go=schoolTop&school_id={$current_school.id}" title="{"Make my school Top"|i18n}"><img src="{$http_images_static_path}icons/up_arrow_24x24.png" alt="{"Make my school Top"|i18n}" /></a>
        <a href="{$http_project_path}schools/?s={$s}&go=my_schools&action=delete_school&school_id={$current_school.id}" title="{"Delete school"|i18n}"><img src="{$http_images_static_path}icons/delete_24x24.png" alt="{"Delete school"|i18n}" /></a>
        <a href="{$http_project_path}photo/?go=school_albums&s={$s}&school_id={$smarty.request.school_id}" title="{"School Albums"|i18n}"><img src="{$http_images_static_path}icons/database_24x24.png" alt="{"School Albums"|i18n}" /></a>
        <br/>
        {if $school->is_school_vip_active($current_school.id) == true}
            {assign var="VIPData" value=$school->get_vip_school_data($current_school.id)}
            {"School VIP valid till"|i18n} {$VIPData.end_time|date_format:'%d.%m.%Y %H:%M'}<br/>
        {/if}
    {/if}
</center>
{include file='i_error.tpl'}
<div>
    <div style="float: left; padding-right: 10px;">
        {if $current_school.image_id > 0}
            <img src="{$http_images_path}{$Images->get_image_url_center_square($current_school.image_id, 200,'jpg')}" alt="{"School Image"|i18n}" />
        {else}
            <img src="{$http_images_static_path}/no_school.jpg" alt="{"School Image"|i18n}" />
        {/if}
    </div>
    <b>{"Address"|i18n}</b> {$country.name}, {$city.name}, {$current_school.address}
    <br/>
    <br/>
    <b>{"School phone 1"|i18n}</b> {$current_school.phone_1}
    {if $current_school.phone_2 ne ''}
        <br/>
        <b>{"School phone 2"|i18n}</b> {$current_school.phone_2}
    {/if}
    <br/>
    <br/>
    <b>{"URL"|i18n}</b> {if $current_school.url ne ''}<a href="{$current_school.url}">{$current_school.url}</a>{else}{"Url not available"|i18n}{/if}
    <br/>
    <br/>
    <b>{"Email"|i18n}</b> {$current_school.email}
    <br/>
    <br/>
    {if $current_school.icq != 0}
        <b>{"ICQ"|i18n}</b> {$current_school.icq}
        <br/>
        <br/>
    {/if}
    <b>{"School owner"|i18n}</b> <a href="{$http_project_path}?s={$s}&go=profile&user_id={$current_school.owner_id}">{$User->get_value($current_school.owner_id,'login')}</a>
</div>
<br clear="all"/>
<div>
    <center><b>{"School description"|i18n}:</b><br/></center>
    {$current_school.description|bbcode}
</div>


<div style="padding-left:5px">
    {foreach from=$schoolAlbums.items item=albumData}
        {assign var="firstPhotoUrl" value=$albumData->getFirstPhotoUrl(100)}
        {if $firstPhotoUrl == false}
            {assign var="firstPhotoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
        {/if}
        <div class="photo_container">
            <a href="{$http_project_path}photo/?go=school_album_photos&s={$s}&album_id={$albumData->id}&school_id={$smarty.request.school_id}"><img src="{$firstPhotoUrl}" alt="" width="100" height="100" /></a><br/>
            <center><a href="{$http_project_path}photo/?go=school_album_photos&s={$s}&album_id={$albumData->id}&school_id={$smarty.request.school_id}">{$albumData->name}</a></center>
        </div>
    {/foreach}
</div>
{include file='footer.tpl'}