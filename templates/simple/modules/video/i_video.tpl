<div class="videoData{$from}" id="videoData_{$video->id}">
	<div class="videoDataVideo">	
		{include file='modules/video/i_youtube_video.tpl' videoWidth=$videoWidth|default:'480' videoHeight=$videoHeight|default:'320' youtubeId=$video->youtube_id}
	</div>
	<div class="videoDataInfo" {if $disableContentEdit != true}id="videoDataInfo_{$video->id}"{/if}>
		{include file='modules/video/i_video_content.tpl'}
	</div>
</div>
{if $disableContentEdit != true}
<div id="dialog-video-update-{$video->id}" style="display:none;"></div>
{/if}