{include file='header.tpl' script='modules/video/i_javascript.tpl'}
<div class="title">{"My Albums"|i18n}</div>
{include file='i_error.tpl'}
<a href="{$http_project_path}video/?go=my_album_add&s={$s}">{"Add album"|i18n}</a><br/>
<div>
    {foreach from=$userAlbums.items item=albumData}
        {assign var="firstVideoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
        <div class="video_container" style="width:100px;height:176px;">
            <div>
                <a href="{$http_project_path}video/?go=my_album_videos&s={$s}&album_id={$albumData->id}"><img src="{$firstVideoUrl}" alt="" width="100" height="100" /></a>
            </div>
            <div style="text-align: center;word-wrap: break-word;text-overflow: clip;overflow: hidden;">
                <a href="{$http_project_path}video/?go=my_album_videos&s={$s}&album_id={$albumData->id}">{$albumData->name}</a>
                <a href="javascript:void(0);" onclick="showVideoAlbumEdit({$albumData->id},'{$s}');"><img src="{$http_images_static_path}icons/edit_24x24.png" alt="" onclick="showVideoAlbumEdit({$albumData->id}, '{$s}')" /></a>
            </div>
        </div>
        {foreachelse}
        {"No user albums"|i18n}
    {/foreach}
    <div id="dialog-video-album-update-{$albumData->id}" style="display:none;"></div>
</div>
{include file='footer.tpl'}