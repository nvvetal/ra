{include file='header.tpl' script='modules/video/i_javascript.tpl'}
<div class="title">{"User Albums"|i18n}</div>
{include file='i_error.tpl'}
<div>
{foreach from=$userAlbums.items item=albumData}
    {assign var="firstVideoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
    <div class="video_container" style="width:100px;height:176px;">
    <a href="{$http_project_path}video/?go=my_album_videos&s={$s}&album_id={$albumData->id}"><img src="{$firstVideoUrl}" alt="" width="100" height="100" /></a><br/>
    <center><a href="{$http_project_path}video/?go=my_album_videos&s={$s}&album_id={$albumData->id}">{$albumData->name}</a></center>
    </div>
{foreachelse}
    {"No user albums"|i18n}
{/foreach}
</div>
{include file='footer.tpl'}