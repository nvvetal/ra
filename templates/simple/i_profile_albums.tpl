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
    {foreach name="lastComment" from=$userPhotoLastComments item=lastComment}
        {assign var="comment" value=$lastComment.comment}
        {assign var="item" value=$lastComment.commentItem}
        {if $smarty.foreach.lastComment.first == true}
            <table style="width: 100%;">
        {/if}

        <tr valign="top" align="center">
            <td>
                {$comment->timeCreated|date_format:'%d.%m.%Y'}
            </td>
            <td>
                <a href="{$http_project_path}photo/?s={$s}&go=user_album_photos&album_id={$item->album_id}&photo_id={$item->id}&user_id={$item->owner_id}"><img src="{$item->getUrlCenterSquare(150)}" alt="{$item->name}"/></a>
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
    </table>
</div>
<div style="clear:both; float:none"></div>
