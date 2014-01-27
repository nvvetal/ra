{"votes"|i18n} {$rateAgr->rateCnt}, {"Total points"|i18n} {$rateAgr->ratePoints} <img src="{$http_images_static_path}rating/{$rateAgr->rateAvgRound}b.gif" style="vertical-align: middle" alt=""/>
{if $user_id > 0 && $cannotVote != true && $disableVoting != true}
<span class="videoDataRatingChoose">
	<input type="button" name="{"set rating"|i18n}" value="{"set rating"|i18n}" onclick="showSelectVideoRating('{$videoId}');"/>
</span>
{/if}
<div id="dialog-select-video-rating" style="display: none;">
<div style="text-align:center;">
<a href="javascript:void(0);" onclick="xajax_setVideoRating(lastVideoId, 5, '{$s}');$( '#dialog-select-video-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/5b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setVideoRating(lastVideoId, 4, '{$s}');$( '#dialog-select-video-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/4b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setVideoRating(lastVideoId, 3, '{$s}');$( '#dialog-select-video-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/3b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setVideoRating(lastVideoId, 2, '{$s}');$( '#dialog-select-video-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/2b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setVideoRating(lastVideoId, 1, '{$s}');$( '#dialog-select-video-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/1b.gif" alt=""/></a><br/>
</div>
</div>