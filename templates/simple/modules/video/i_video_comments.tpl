{foreach from=$videoComments item=videoComment}
<div class="videoComment">
	<div class="videoCommentAuthor"><a href="{$http_project_path}?s={$s}&go=profile&user_id={$videoComment->createdBy}">{$videoComment->getLogin()}</a></div>
	<div class="videoCommentData">{$videoComment->comment|htmlspecialchars}</div>	
</div>
{foreachelse}
<div class="videoCommentsNotAvailable">{"No comments yet"|i18n}</div>
{/foreach}
<br clear="all"/>