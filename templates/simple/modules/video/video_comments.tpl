{include file='header.tpl' script='modules/video/i_javascript.tpl'}

<div class="title">{$video->name}</div>
{include file="modules/video/i_video.tpl" video=$video disableComments=true disableTitle=true}
<a href="{$smarty.request.from}">{"Back"|i18n}</a>
<div class="videoCommentsTitle">{"Video comments"|i18n}</div>
<div class="videoComments" id="videoComments">
	{include file="modules/video/i_video_comments.tpl"}
</div>
{if $Session->get_value($s,'is_logged') == 1}
<div><input type="button" onclick="showNewComment({$smarty.request.video_id});" value="{"Add comment"|i18n}" /></div>
{/if}
<div id="dialog-video-comment" style="display: none;">
<form id="formComment">
<textarea name="comment" id="comment" style="width:95%;height:180px"></textarea>
<input type="hidden" name="video_id" value="{$smarty.request.video_id}" />
<input type="hidden" name="s" value="{$s}" />
</form>
</div>
{include file='footer.tpl'}