{literal}
<script type="text/javascript">

    var lastVideoId = 0;

    function clearVideoFields()
    {
        $('#name').val('');
        $('#link').val('');
        $('#description').val('');
    }

    function showSelectVideoRating(videoId)
    {
        lastVideoId = videoId;
        $( "#dialog-select-video-rating" ).dialog({
            height: 270,
            width: 300,
            title: {/literal}"{"Rating set up"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function showNewComment(videoId)
    {
        $('#comment').val('');
        $( "#dialog-video-comment" ).dialog({
            height: 300,
            width: 500,
            title: {/literal}"{"New comment"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                },
                {/literal}"{"Add comment"|i18n}"{literal}: function() {
                    xajax_addVideoComment($('#formComment').serialize());
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function showNewTag(lineId)
    {
        $('#tag').val('');
        $( "#dialog-tag" ).dialog({
            height: 120,
            width: 300,
            title: {/literal}"{"New tag"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                },
                {/literal}"{"Add tag"|i18n}"{literal}: function() {
                    addVideoTag($('#tag').val(), lineId);
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function addVideoTag(tag, lineId)
    {
        var id = new Date().getTime();
        $("#tagContainer_"+lineId).after('<div id="tag_'+id+'" style="display:inline;float:left;padding: 0px 10px 0px 0px"><span style="font-color:blue;">'+tag+'</span> <input type="hidden" name="tags['+lineId+'][]" value="'+tag+'" /><a href="javascript:void(0);" onclick="$(\'#tag_'+id+'\').remove()">X</a></div>');
    }


    function showNewTagVideoId(videoId)
    {
        $('#tag_'+videoId).val('');
        $( "#dialog-tag-"+videoId ).dialog({
            height: 120,
            width: 300,
            title: {/literal}"{"New tag"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                },
                {/literal}"{"Add tag"|i18n}"{literal}: function() {
                    addVideoIdTag($('#tag_'+videoId).val(), videoId);
                    $( this ).dialog( "close" );
                }
            }
        });
    }

    function showVideoEdit(videoId, sessionId)
    {
        $("#dialog-video-update-"+videoId).html('');
        xajax_showVideoEdit(videoId, sessionId);
        $( "#dialog-video-update-"+videoId ).dialog({
            height: 500,
            width: 400,
            title: {/literal}"{"Edit video data"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                },
                {/literal}"{"Save changes"|i18n}"{literal}: function() {
                    xajax_setVideoContent($('#video_'+videoId).serialize());
                }
            }
        });
    }

    function showVideoAlbumEdit(videoAlbumId, sessionId)
    {
        $("#dialog-video-album-update-"+videoAlbumId).html('');
        xajax_showVideoAlbumEdit(videoAlbumId, sessionId);
        $( "#dialog-video-album-update-"+videoAlbumId ).dialog({
            height: 150,
            width: 300,
            title: {/literal}"{"Edit video album data"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                },
                {/literal}"{"Save changes"|i18n}"{literal}: function() {
                    xajax_setVideoAlbumName($('#videoAlbum_'+videoAlbumId).serialize());
                }
            }
        });
    }

    function closeVideoEdit(videoId)
    {
        //alert(videoId);
        $("#dialog-video-update-"+videoId).dialog('close');
    }

    function closeVideoAlbumEdit(videoAlbumId)
    {
        //alert(videoId);
        $("#dialog-video-album-update-"+videoAlbumId).dialog('close');
    }

    function addVideoIdTag(tag, videoId)
    {
        var id = new Date().getTime();
        $("#tagContainer_"+videoId).after('<div id="tag_'+id+'" style="display:inline;float:left;padding: 0px 10px 0px 0px"><span style="font-color:blue;">'+tag+'</span> <input type="hidden" name="tags[]" value="'+tag+'" /><a href="javascript:void(0);" onclick="$(\'#tag_'+id+'\').remove()">X</a></div>');
    }

    function saveFormVideos()
    {
        if($('#btnSubmit').prop('disabled') == false){
            $('#btnSubmit').prop('disabled', true);

            xajax_saveVideo($('#video').serialize());
        }
        return false;
    }

</script>
{/literal}