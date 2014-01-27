<div class="comments">
<div class="comments-title">{"Comments"|i18n}</div>
{foreach name="comment" from=$photoComments item=comment}
<div class="comment-container">
    <div class="comment-user">
        <a href="{$http_project_path}?s={$s}&go=profile&user_name={$User->get_value($comment->createdBy,'login')}" target="_blank">{$User->get_value($comment->createdBy,'login')}</a>
    </div>
    <div class="comment">
        {$comment->comment|strip_tags}
    </div>
</div>
{foreachelse}
{"No comments"|i18n}
{/foreach}
</div>
{if $user_id > 0}
<form id="comment">
<textarea name="comment" style="width:95%;height:200px"></textarea>
<input type="button" name="btnSubmit" value="{"Submit"|i18n}" onclick="addPhotoComment(this, $('#comment').serialize(), '{$s}');" />
<input type="hidden" name="photo_id" value="{$photoId}" />
<input type="hidden" name="s" value="{$s}" />
</form>
{else}
<div style="clear:both">{"Please login!"|i18n}</div>
{/if}