{assign var="rateAgr" value=$video->getRateAgr()}
{assign var="album" value=$video->getAlbum()}
{assign var="tags" value=$video->getTags()}
{assign var="defaultTitle" value="no name"|i18n}
{assign var="defaultDescription" value="no description"|i18n}
{if $disableAlbum != true}
    <div class="videoDataAlbum">{"Album"|i18n} <a href="{$http_project_path}video/?s={$s}&go=user_album_videos&album_id={$video->album_id}">{$album->name}</a></div>
{/if}
<div class="videoDataOwner">{"Owner"|i18n} <a href="{$http_project_path}?s={$s}&go=profile&user_id={$video->owner_id}">{$video->getOwnerLogin()}</a></div>
{if $disableTitle != true}
    <div class="videoDataTitleContainer" style="width:{$videoWidth}px;overflow: hidden;">
        <div class="videoDataTitle" {if $disableContentEdit != true}id="videoDataTitle_{$video->id}"{/if}><a href="{$http_project_path}video/?go=video_comments&s={$s}&video_id={$video->id}&from={$video->getCommentBackUrl()}">{$video->name|default:$defaultTitle}</a></div>
        {if $video->owner_id == $user_id && $disableContentEdit != true}<div class="videoDataEdit"><a href="javascript:void(0);" onclick="showVideoEdit({$video->id},'{$s}');"><img src="{$http_images_static_path}icons/edit_24x24.png" alt="" /></a></div>{/if}
        <br/>
    </div>
{/if}
{if $disableDescription != true}
    <div class="videoDataDescription" {if $disableContentEdit != true}id="videoDataDescription_{$video->id}"{/if}>{$video->description|default:$defaultDescription}</div>
{/if}

{if $disableVoting != true}
    <div class="videoDataRating" id="video_rating_{$video->id}">
        {include file="modules/video/i_rating_video.tpl" videoId=$video->id cannotVote=$video->isUserRatedVideo($user_id)}
    </div>
{/if}
{if $disableComments != true}
    <div class="videoDataComments"><a href="{$http_project_path}video/?go=video_comments&s={$s}&video_id={$video->id}&from={$video->getCommentBackUrl()}">{"Comments"|i18n} ({$video->getCommentsCount()})</a></div>
{/if}

{if $tags.cnt > 0 && $disableTags != true}
    <div class="videoDataTags" {if $disableContentEdit != true}id="videoDataTags_{$video->id}{/if}">
        {foreach from=$tags.items item=tag}
            <div class="videoDataTag">{$tag->tag}</div>
        {/foreach}
    </div>
{/if}