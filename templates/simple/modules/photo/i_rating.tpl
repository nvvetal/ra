<div class="rating">
<div class="rating-title">{"Rating"|i18n}</div>
<div class="rating-points"><div class="rating-points-count">{"votes"|i18n} {$rateAgr->rateCnt}, {"Total points"|i18n} {$rateAgr->ratePoints}</div><div class="rating-points-divider">/</div>
<div class="rating-points-avg"><img src="{$http_images_static_path}rating/{$rateAgr->rateAvgRound}b.gif" alt=""/></div>
{if $user_id > 0 && $cannotVote != 1}
<div class="rating-choose">
<input type="button" name="{"set rating"|i18n}" value="{"set rating"|i18n}" onclick="showSelectPhotoRating();"/>
</div>
{/if}
</div>
<div id="dialog-select-photo-rating" style="display: none;">
<div style="text-align:center;">
<a href="javascript:void(0);" onclick="xajax_setPhotoRating('{$photoId}', 5, '{$s}');$( '#dialog-select-photo-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/5b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setPhotoRating('{$photoId}', 4, '{$s}');$( '#dialog-select-photo-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/4b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setPhotoRating('{$photoId}', 3, '{$s}');$( '#dialog-select-photo-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/3b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setPhotoRating('{$photoId}', 2, '{$s}');$( '#dialog-select-photo-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/2b.gif" alt=""/></a><br/>
<a href="javascript:void(0);" onclick="xajax_setPhotoRating('{$photoId}', 1, '{$s}');$( '#dialog-select-photo-rating' ).dialog( 'close' );"><img src="{$http_images_static_path}rating/1b.gif" alt=""/></a><br/>
</div>
</div>