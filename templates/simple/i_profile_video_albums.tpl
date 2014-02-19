<div>
    {if $canAddVideoAlbum == 1}
        <a href="{$http_project_path}video/?go=my_album_video_add&s={$s}&no_album=1">{"Add new video"|i18n:'video'}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{$http_project_path}video/?go=my_album_add&s={$s}">{"Add album"|i18n:'video'}</a>
        <br/><br/>
    {/if}
    {foreach name="albumData" from=$userVideoAlbums.items item=albumData}
        {assign var="firstVideoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
        <div style="display:inline;text-align:center;width:100px;float:left;padding-right:10px;">
            <a href="{$http_project_path}video/?go=user_album_videos&s={$s}&album_id={$albumData->id}&user_id={$profile_user_id}"><img src="{$firstVideoUrl}" alt="" width="100" height="100" /></a><br/>
            <a href="{$http_project_path}video/?go=user_album_videos&s={$s}&album_id={$albumData->id}&user_id={$profile_user_id}">{$albumData->name}</a>
        </div>
    {/foreach}
    {foreach name="lastComment" from=$userVideoLastComments item=lastComment}
        {assign var="comment" value=$lastComment.comment}
        {assign var="commentItem" value=$lastComment.commentItem}
        {assign var="firstVideoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
        {if $smarty.foreach.lastComment.first == true}
            <table style="width: 100%;margin-top:20px;">
            <tr>
                <td colspan="4" align="center">{"New comments"|i18n:'video'}</td>
            </tr>
        {/if}
        <tr valign="top" align="center">
            <td>
                {$comment->timeCreated|date_format:'%d.%m.%Y'}
            </td>
            <td>
                <a href="{$http_project_path}video/?go=user_album_videos&s={$s}&album_id={$commentItem->album_id}&user_id={$profile_user_id}"><img src="{$firstVideoUrl}" alt="" width="100" height="100" /></a>
            </td>
            <td>
                <a href="{$http_project_path}?go=profile&user_id={$comment->createdBy}&s={$s}">{$User->get_value($comment->createdBy, 'login')}</a>
            </td>
            <td>
                {$comment->comment|strip_tags}
            </td>
        </tr>

        {if $smarty.foreach.lastComment.last == true}
            </table>
        {/if}
    {/foreach}
</div>
<div style="clear:both; float:none"></div>
