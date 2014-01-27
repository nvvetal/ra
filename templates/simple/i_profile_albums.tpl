<div>
{if $canAddAlbum == 1}
<a href="{$http_project_path}photo/?go=my_album_add&s={$s}">{"Add album"|i18n photo}</a><br/>
{/if}
{foreach name="albumData" from=$userAlbums.items item=albumData}
    {assign var="firstPhotoUrl" value=$albumData->getFirstPhotoUrl(100)}
    {if $firstPhotoUrl == false}
    {assign var="firstPhotoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
    {/if}
    <div style="display:inline;text-align:center;width:100px;float:left;padding-right:10px;">
    <a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}"><img src="{$firstPhotoUrl}" alt="" width="100" height="100" /></a><br/>
    <a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}">{$albumData->name}</a>
    </div>
{/foreach}
</div>
<div style="clear:both; float:none"></div>
