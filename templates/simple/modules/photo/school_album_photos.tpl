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
<div class="title">{"School Album Photos"|i18n} <span style="font-size: 110%">{$schoolCurrent.name}</span></div>
{if $isOwner == 1}
<a href="{$http_project_path}photo/?go=school_album_photo_add&s={$s}&album_id={$smarty.request.album_id}&school_id={$smarty.request.school_id}">{"Add photo"|i18n}</a>
<a href="{$http_project_path}photo/?go=school_albums&s={$s}&action=school_album_remove&album_id={$schoolAlbum->id}&school_id={$smarty.request.school_id}">{"Remove Album"|i18n}</a><br/>
{/if}
<a href="{$http_project_path}photo/?go=school_albums&s={$s}&school_id={$smarty.request.school_id}">{"Back to Albums"|i18n}</a><br/>
<a href="{$http_project_path}schools/?go=school&s={$s}&school_id={$smarty.request.school_id}">{"Back to School"|i18n}</a><br/>

<div>
{foreach name="photo" from=$schoolPhotos.items item=schoolPhoto}
    {if $smarty.foreach.photo.first == true}
    <div id="gallery">
    {/if}
    <a href="{$schoolPhoto->getOriginalUrl()}"  id="image_{$schoolPhoto->id}" alt="{$schoolPhoto->name}" ><img src="{$schoolPhoto->getUrlCenterSquare(50)}" alt="{$schoolPhoto->name}"/></a>
    {if $smarty.foreach.photo.last == true}
        </div>
    {/if}
    <!--
    {if $isOwner == 1}
    <br/>
    <a href="{$http_project_path}photo/?go=school_album_photos&s={$s}&action=school_album_photo_remove&photo_id={$schoolPhoto->id}&school_id={$smarty.request.school_id}&album_id={$smarty.request.album_id}">Remove</a>
    {/if}
    -->
{foreachelse}
    {"No photos"|i18n}
{/foreach}
</div>
{foreach name="photo" from=$schoolPhotos.items item=photo}
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