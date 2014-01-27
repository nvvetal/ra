<div>
{if $canAddVideoAlbum == 1}
<a href="{$http_project_path}video/?go=my_album_video_add&s={$s}&no_album=1">{"Add new video"|i18n:'video'}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$http_project_path}video/?go=my_album_add&s={$s}">{"Add album"|i18n:'video'}</a>
<br/><br/>
{/if}
{foreach name="albumData" from=$userVideoAlbums.items item=albumData}
    {assign var="firstVideoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
    <div style="display:inline;text-align:center;width:100px;float:left;padding-right:10px;">
    <a href="{$http_project_path}video/?go=user_album_videos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}"><img src="{$firstVideoUrl}" alt="" width="100" height="100" /></a><br/>
    <a href="{$http_project_path}video/?go=user_album_videos&s={$s}&album_id={$albumData->id}&user_id={$smarty.request.user_id}">{$albumData->name}</a>
    </div>
{/foreach}
</div>
<div style="clear:both; float:none"></div>
