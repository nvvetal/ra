{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
<div class="title">{"My Albums"|i18n}</div>
{include file='i_error.tpl'}
<a href="{$http_project_path}photo/?go=my_album_add&s={$s}">{"Add album"|i18n}</a><br/>
<div>
{foreach from=$userAlbums.items item=albumData}
    {assign var="firstPhotoUrl" value=$albumData->getFirstPhotoUrl(100)}
    {if $firstPhotoUrl == false}
    {assign var="firstPhotoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
    {/if}
    <div class="photo_container">
    <a href="{$http_project_path}photo/?go=my_album_photos&s={$s}&album_id={$albumData->id}"><img src="{$firstPhotoUrl}" alt="" width="100" height="100" /></a><br/>
    <center>
        <a href="{$http_project_path}photo/?go=my_album_photos&s={$s}&album_id={$albumData->id}">{$albumData->name}</a>
        <img src="{$http_images_static_path}icons/edit_24x24.png" alt="" onclick="showPhotoAlbumEdit('{$albumData->id}', '{$s}')" />
    </center>
    </div>
    <div id="dialog-photo-album-update-{$albumData->id}" style="display:none;"></div>
{foreachelse}
    {"No user albums"|i18n}
{/foreach}
</div>

{include file='footer.tpl'}