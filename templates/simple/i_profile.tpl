{assign var="current_city_id" value=$User->get_value($profile_user_id,'p_city_id')}
{assign var="city" value=$Geo->get_city($current_city_id)}
{assign var="country" value=$Geo->get_country($city.country_id)}
{assign var="subdivision" value=$Geo->get_subdivision($city.subdivision_id)}
<table width="600" border="0">
    <tr valign="top">
        <td width="170">
            {if $User->get_value($profile_user_id,'image_id') > 0}
                <img src="{$http_images_path}{$Images->get_image_url_center_square($User->get_value($profile_user_id,'image_id'), 150, 'jpg')}" alt="{"User Image"|i18n}" width="150" height="150" />
            {else}
                <img src="{$http_images_static_path}u_{$User->get_value($profile_user_id,'p_sex')}.png" / >
            {/if}        
        </td>
        <td>
            <strong>{$User->get_value($profile_user_id,'p_last_name')} {$User->get_value($profile_user_id,'p_first_name')}</strong>
            <div class="linkDiv"></div>
            <a href="{$http_project_path}forum/memberlist.php?mode=viewprofile&u={$User->get_value($profile_user_id,'forum')}"><img src="{$http_images_static_path}icon_user_profile.gif" alt=""/></a>
            <div class="linkDiv"></div>
            <a href="{$http_project_path}shop/?user_id={$profile_user_id}&s={$s}"><img src="{$http_images_static_path}icon_gift.png" alt=""></a>
            <div class="linkDiv"></div>
            <a href="{$http_project_path}forum/ucp.php?i=pm&mode=compose&u={$User->get_value($profile_user_id,'forum')}"><img src="{$http_project_path}/forum/styles/subsilver2/imageset/ru/icon_contact_pm.gif" alt=""/></a>
            <div class="linkDiv"></div>
            <a href="mailto:{$User->get_value($profile_user_id,'email')}"><img src="{$http_project_path}/forum/styles/subsilver2/imageset/ru/icon_contact_email.gif" alt=""/></a>
            <div class="linkDiv"></div>
            {if $profile_user_id == $user_id}
                <a href="{$http_project_path}?s={$s}&go=my_profile">{"Edit Profile"|i18n}</a>
            {/if}
        </td>
    </tr>
    <!--tr valign="top" style="background-color: #ffeebc;">
        <td>
            {"Status"|i18n}
        </td>
        <td>
            {foreach name="userStatus" from=$userStatuses.items item=userStatus}
                {if $smarty.foreach.userStatus.first == true}
                    <div>{$userStatus->status|strip_tags} ({$userStatus->created_time|date_format:'%d.%m.%Y %H:%I'})</div>
                {/if}
                {if $smarty.foreach.userStatus.first == false}
                    <hr/>
                    <div style="margin-left:30px;">{$userStatus->status|strip_tags} ({$userStatus->created_time|date_format:'%d.%m.%Y %H:%I'})</div>
                {/if}
            {/foreach}
        </td>
    </tr-->

    <tr valign="top">
        <td>
            {"Sex"|i18n}
        </td>
        <td>
            <img  src="{$http_images_static_path}{$User->get_value($profile_user_id,'p_sex')}.jpg" / > {$User->get_value($profile_user_id,'p_sex')|i18n}
        </td>
    </tr>
    <tr valign="top">
        <td>
            {"Reputation"|i18n}
        </td>
        <td>
            <a href="{$http_project_path}forum/viewreputation.php?id={$User->get_value($profile_user_id,'forum')}">{$User->get_value($profile_user_id,'user_reputation')}</a>
        </td>
    </tr>    
    <tr valign="top">
        <td>
            {"First Name"|i18n}
        </td>
        <td>
            {$User->get_value($profile_user_id,'p_first_name')}
        </td>
    </tr>
    <tr valign="top">
        <td>
            {"Last Name"|i18n}
        </td>
        <td>
            {$User->get_value($profile_user_id,'p_last_name')}
        </td>
    </tr>
    <tr valign="top">
        <td>
            {"From where?"|i18n}
        </td>
        <td>
        	{if $country.name ne '' && $city.name ne ''}
            {$country.name}, {$subdivision.name}, {$city.name}
            {/if}
        </td>
    </tr>            
    {if $User->get_value($profile_user_id,'p_birthday') ne ''}
    <tr valign="top">
        <td>
            {"Birthday Date"|i18n}
        </td>
        <td>
            {$User->get_value($profile_user_id,'p_birthday')|date_format:'%d.%m.%Y'}
        </td>
    </tr>
    {/if}
    {if $User->get_value($profile_user_id,'p_profession') ne ''}
    <tr valign="top">
        <td>
            {"Profession"|i18n}
        </td>
        <td>
            {$User->get_value($profile_user_id,'p_profession')}
        </td>
    </tr> 
    {/if}
    {if $User->get_value($profile_user_id,'p_hobby') ne ''}
    <tr valign="top">
        <td>
            {"Hobby"|i18n}
        </td>
        <td>
            {$User->get_value($profile_user_id,'p_hobby')}
        </td>
    </tr> 
    {/if}
    {if $User->get_value($profile_user_id,'p_url') ne ''}
    <tr valign="top">
        <td>
            {"URL"|i18n}
        </td>
        <td>
            <a href="{$User->get_value($profile_user_id,'p_url')|proto:'http'}" target="_blank">{$User->get_value($profile_user_id,'p_url')}</a>
        </td>
    </tr> 
    {/if}
    {if $User->get_value($profile_user_id,'p_icq') ne ''}
    <tr valign="top">
        <td>
            <img src="{$http_images_static_path}icq.jpg" alt="{"ICQ"|i18n}" height="20" width="20"/>
        </td>
        <td>
            {$User->get_value($profile_user_id,'p_icq')}
        </td>
    </tr> 
    {/if}
    {if $User->get_value($profile_user_id,'p_skype') ne ''}
    <tr valign="top">
        <td>
            <img src="{$http_images_static_path}skype.jpg" alt="{"Skype"|i18n}" height="20" width="20"/>
        </td>
        <td>
            {$User->get_value($profile_user_id,'p_skype')}
        </td>
    </tr>
    {/if}
    {if $user_id == $profile_user_id}
    <tr valign="top">
        <td>
            {"Raks Money"|i18n}
        </td>
        <td>
            {$User->get_raks_money($user_id)}<br/>
            <a href="{$http_project_path}?s={$s}&go=payment_prepay">{"Buy Raks Money"|i18n}</a>
        </td>
    </tr>                       
    {/if}
</table>