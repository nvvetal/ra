{include file='header.tpl'}
{literal}
    <script>
        $(function() {
            $( "#tabs" ).tabs();
        });
    </script>
{/literal}
<center><h2><img src="{$http_images_static_path}hprofile.jpg" alt=""/></h2></center>
{if $User->is_user_id_exists($profile_user_id)}
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">{"User profile"|i18n}</a></li>
            <li><a href="#tabs-2">{"User schools"|i18n}</a></li>
            <li><a href="#user_photoalbums">{"User photo"|i18n}{if "photoComments"|eventsCount > 0 && $profile_user_id == $user_id} (<img src="{$http_images_static_path}new.gif" alt=""/> {"photoComments"|eventsCount}!){/if}</a></li>
            <li><a href="#tabs-4">{"User video"|i18n:'video'}{if "videoComments"|eventsCount > 0 && $profile_user_id == $user_id} (<img src="{$http_images_static_path}new.gif" alt=""/> {"videoComments"|eventsCount}!){/if}</a></li>
            <li><a href="#tabs-5">{"User achievements"|i18n}</a></li>
            <li><a href="#tabs-6">{"User friends"|i18n}</a></li>
            <li><a href="#tabs-7">{"User gits"|i18n}{if "gifts"|eventsCount > 0 && $profile_user_id == $user_id} (<img src="{$http_images_static_path}new.gif" alt=""/> {"gifts"|eventsCount}!){/if}</a></li>
        </ul>
        <div id="tabs-1">
            {include file='i_profile.tpl'}
        </div>
        <div id="tabs-2">
            {include file='i_profile_schools.tpl'}
        </div>
        <div id="user_photoalbums">
            {include file='i_profile_albums.tpl'}
        </div>
        <div id="tabs-4">
            {include file='i_profile_video_albums.tpl'}
        </div>
        <div id="tabs-5">
            {include file='i_profile_achievements.tpl'}
        </div>
        <div id="tabs-6">
            {include file='i_profile_friends.tpl'}
        </div>
        <div id="tabs-7">
            {include file='i_profile_gifts.tpl'}
        </div>
    </div>
{else}
    {"User is not existing!"|i18n}
{/if}

{include file='footer.tpl'}