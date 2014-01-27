{literal}
<script type="text/javascript" src="{/literal}{$http_project_path}{literal}galleria/galleria-1.2.5.min.js"></script>
<script type="text/javascript">
    function addPhotoComment(sender, data, s)
    {
        $(sender).attr('disabled', 'disabled');
        xajax_addPhotoComment(data, s);
    }

    function showSelectPhotoRating()
    {

        $( "#dialog-select-photo-rating" ).dialog({
            height: 270,
            width: 200,
            title: {/literal}"{"Rating set up"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function getImageGalleryIndex(imageId)
    {
        var idx = 0;
        var i = 0
        var isFound = false;
        $('a[id^="image"]').each(function(i){

            if($(this).attr('id') == imageId) {
                isFound = true;
                return false;
            }
            idx++;
        });
        if(isFound == true) return idx;
        return 0;
    }

    function viewPhotoFullBySrc(src)
    {
        var re 	= new RegExp("(\\d+)_(\\d+)\\.\\w+$");
        var m 	= re.exec(src);
        var w = Math.min($(window).width() - 30, parseInt(m[1]));
        var h = Math.min($(window).height() - 30, parseInt(m[2]));
        if(w / h > m[1] / m[2]){
            w = m[1] / m[2] * h;
        }else{
            h = w * m[2] / m[1];
        }
        $( "#dialog-full-image" ).dialog({
            title: {/literal}"{"Image"|i18n}"{literal},
            modal: true,
            width: w,
            height: h,
            buttons: {
                {/literal}"{"Close image"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        $( "#dialog-full-image" ).css('text-align', 'center');
        $( "#dialog-full-image" ).html('<img src="'+src+'" alt="" style="max-height:100%;max-width:100%;" />');
    }

    function showEditPhoto(photoId, s)
    {
        $( "#ajax-dialog" ).dialog({
            height: 300,
            width: 400,
            title: {/literal}"{"Edit Photo"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                },
                {/literal}"{"Save"|i18n}"{literal}: function() {
                    xajax_savePhotoData($('#photo_edit_'+photoId).serialize(), s);
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function showPhotoAlbumEdit(photoAlbumId, sessionId)
    {
        $("#dialog-photo-album-update-"+photoAlbumId).html('');
        xajax_showPhotoAlbumEdit(photoAlbumId, sessionId);
        $( "#dialog-photo-album-update-"+photoAlbumId ).dialog({
            height: 150,
            width: 300,
            title: {/literal}"{"Edit photo album data"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                },
                {/literal}"{"Save changes"|i18n}"{literal}: function() {
                    xajax_setPhotoAlbumName($('#photoAlbum_'+photoAlbumId).serialize());
                }
            }
        });
    }

    function closePhotoAlbumEdit(photoAlbumId)
    {
        //alert(videoId);
        $("#dialog-photo-album-update-"+photoAlbumId).dialog('close');
    }

</script>
{/literal}