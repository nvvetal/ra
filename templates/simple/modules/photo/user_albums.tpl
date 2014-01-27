{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
<div class="title">{"User Albums"|i18n} :: {$userLogin}</div>
{include file='i_error.tpl'}
<div>
{foreach from=$userAlbums.items item=albumData}
    {assign var="firstPhotoUrl" value=$albumData->getFirstPhotoUrl(100)}
    {if $firstPhotoUrl == false}
    {assign var="firstPhotoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
    {/if}
    <div class="photo_container">
    <a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}"><img src="{$firstPhotoUrl}" alt="" width="100" height="100" /></a><br/>
    <center><a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}">{$albumData->name}</a></center>
    </div>
{foreachelse}
    {"No user albums"|i18n}
{/foreach}
</div>
{include file='footer.tpl'}