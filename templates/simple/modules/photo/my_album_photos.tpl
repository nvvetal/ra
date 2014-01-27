{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
{literal}
<script>
	$(document).ready(function() {
		// Handler for .ready() called.
		Galleria.loadTheme('{/literal}{$http_project_path}{literal}galleria/themes/classic/galleria.classic.min.js');

		$('#gallery').galleria({
			width:680,
			height:500,
			show: getImageGalleryIndex('image_{/literal}{$smarty.request.photo_id}{literal}'),
			dummy: '{/literal}{$http_images_static_path}no_album.jpg{literal}',
			debug: false
		});

		Galleria.ready(function(options) {
			this.bind("image", function(e) {
				var idx = e.index;
				$('span[name^="galleriaImages"]').each(function(i){
					if(idx == i) {
						$('#comments').html('');
						$('#votings').html('');
						$('#album').html('');
						$('#additional').html('<a href="{/literal}{$http_project_path}{literal}photo/?go=my_album_photos&s={/literal}{$s}{literal}&action=my_album_photo_remove&photo_id='+$(this).attr('imageId')+'&album_id={/literal}{$smarty.request.album_id}{literal}">{/literal}{"remove photo"|i18n}{literal}</a>');
						xajax_getPhotoAdditional($(this).attr('imageId'), '{/literal}{$s}{literal}', true);
					}
				});

				$(e.imageTarget).bind("dblclick", function(){
					viewPhotoFullBySrc($(e.imageTarget).attr('src'));
				});
			});

		});
	});
</script>
{/literal}

<div class="title">{"My Album Photos"|i18n} <span style="font-size: 110%">{$userAlbum->name}</span></div>
<div class="photo_menu_links">
	<ul>
		<li>
			<a href="{$http_project_path}photo/?go=my_album_photo_add&s={$s}&album_id={$smarty.request.album_id}">{"Add photo"|i18n}</a>
		</li>
        <li>
            <a href="{$http_project_path}photo/?go=my_albums&s={$s}&action=my_album_remove&album_id={$userAlbum->id}">{"Remove Album"|i18n}</a><br/>
        </li>
		<li>
			<a href="{$http_project_path}photo/?go=my_albums&s={$s}">{"Back to Albums"|i18n}</a>
		</li>
	</ul>
</div>
<div>

	{foreach name="photo" from=$userPhotos.items item=userPhoto}
		{if $smarty.foreach.photo.first == true}
			<div id="gallery">
		{/if}
		<a href="{$userPhoto->getOriginalUrl()}" id="image_{$userPhoto->id}"><img src="{$userPhoto->getUrlCenterSquare(50)}" alt="{$userPhoto->name}"/></a>
		<!--a href="{$http_project_path}photo/?go=my_album_photos&s={$s}&action=my_album_photo_remove&photo_id={$userPhoto->id}&album_id={$smarty.request.album_id}">{"remove photo"|i18n}</a-->
		{if $smarty.foreach.photo.last == true}
			</div>
		{/if}
		{foreachelse}
		{"No photos"|i18n}
	{/foreach}

	{foreach name="photo" from=$userPhotos.items item=photo}
		{if $smarty.foreach.photo.first == true}
			<div style="display:none;padding:0;margin:0">
		{/if}
		<span name="galleriaImages_{$photo->id}" imageId="{$photo->id}">{$photo->id}</span>
		{if $smarty.foreach.photo.last == true}
			</div>
		{/if}
	{/foreach}
	<div id="additional"></div>
	<div id="votings" style="width:680px;"></div>
	<br clear="all"/>
	<div id="album" style="width:680px;"></div>
	<br clear="all"/>
	<div id="comments" style="width:680px;"></div>

	<div id="dialog-full-image" style="display: none;">
{include file='footer.tpl'}