{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
<div class="title">{"User Albums"|i18n} :: {$userLogin}</div>
{include file='i_error.tpl'}
<div>
    {foreach from=$userAlbums.items item=albumData}
        {assign var="firstPhotoUrl" value=$albumData->getFirstPhotoUrl(100)}
        {if $firstPhotoUrl == false}
            {assign var="firstPhotoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
        {/if}
        <div class="photo_container" style="width:100px;">
            <div><a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}"><img src="{$firstPhotoUrl}" alt="" width="100" height="100" /></a></div>
            <div style="text-align: center;word-wrap: break-word;text-overflow: clip;overflow: hidden;"><a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}">{$albumData->name}</a></div>
        </div>
        {foreachelse}
        {"No user albums"|i18n}
    {/foreach}
</div>
{include file='footer.tpl'}