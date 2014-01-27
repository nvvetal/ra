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
                    //alert($(this).attr('imageId'));
                    //break;
                    $('#comments').html('');
                    $('#votings').html('');
                    $('#album').html('');
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
<div class="title">
    {"User Album Photos"|i18n} <span style="font-size: 110%"><br/>
    <a href="{$http_project_path}?s={$s}&go=profile&user_id={$smarty.request.user_id}">{$User->get_value($smarty.request.user_id,'p_last_name')} {$User->get_value($smarty.request.user_id,'p_first_name')}</a> {$userAlbum->name}</span>
</div>
<div class="photo_menu_links">
<ul>
<li>
<a href="{$http_project_path}photo/?s={$s}">{"Back to Photo Albums"|i18n}
</li>
<li>
<a href="{$http_project_path}photo/?go=user_albums&s={$s}&user_id={$smarty.request.user_id}">{"Back to User Albums"|i18n}</a>
</li>
<li>
<a href="{$http_project_path}?go=profile&s={$s}&user_id={$user_id}#user_photoalbums">{"My Albums"|i18n}</a>
</li>
</ul>
</div>
<div>
{foreach name="photo" from=$userPhotos.items item=userPhoto}
{if $smarty.foreach.photo.first == true}
    <div id="gallery">
{/if}
    <a href="{$userPhoto->getOriginalUrl()}" id="image_{$userPhoto->id}"><img src="{$userPhoto->getUrlCenterSquare(50)}" alt="{$userPhoto->name}"/></a>
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


<div id="votings" style="width:680px;"></div>
<br clear="all"/>
<div id="album" style="width:680px;"></div>
<br clear="all"/>
<div id="comments" style="width:680px;"></div>
<div id="dialog-full-image" style="display: none;">
{include file='footer.tpl'}