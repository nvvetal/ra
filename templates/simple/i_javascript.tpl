{literal}
<script>
    function showMainPhotoFull(selectedIndex)
    {
        $( "#main-photo-full" ).dialog({
            title: {/literal}"{"Last photos"|i18n:default}"{literal},
            modal: true,
            width: 750,
            height: 600,
            buttons: {
                {/literal}"{"Close"|i18n:default}"{literal}: function() {
                    $( this ).dialog( "close" );
                }
            }
        });

    }

    function getEditor(containers, params)
    {
        params = params || {};
        params.bbcode = params.bbcode || false;
        params.youtube = params.youtube || false;
        var insertItems = ['Image', 'Youtube', 'Table', 'Smiley'];
        if(params.youtube) insertItems.push('Youtube');
        var data = {
            language: 'ru',
            uiColor: '#AADC6E',
            toolbar: [
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', groups: [ 'find', 'selection'], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt', 'Source' ] },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: insertItems },
                { name: 'styles', items: [ 'Format', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'others', items: [ '-' ] }
            ]
        };
        if(params.bbcode) data.extraPlugins = 'bbcode';
        if(params.youtube) {
            data.extraPlugins = 'youtube';
        }
        CKEDITOR.replace( containers, data);
    }


    function getBBEditor(containers, params)
    {
        params = params || {};
        params.bbcode = true;
        getEditor(containers, params);
        CKEDITOR.on('instanceReady', function() {
            $(".cke_button__source_label").text("BBCODE");
        });
        //CKEDITOR.config.startupMode = 'source';

    }

    function refreshSocialButtons(){
        refreshFacebookButtons();

    }

    function refreshFacebookButtons(){
        //console.log(FB,'hmm');
        if (typeof(FB) == 'undefined'
                || FB == null ) {
            //console.log(FB);
            setTimeout(function(){refreshFacebookButtons()}, 10);
            return false;
        }
        var facebook = $('.fb-like');
        var data = '<fb:like href="'+facebook.data('href')+'" layout="'+facebook.data('layout')+'" ' +
            'colorscheme="'+facebook.data('colorscheme')+'" action="'+facebook.data('action')+'" ' +
            'show_faces="'+facebook.data('show_faces')+'" ' +
            'show_faces="'+facebook.data('show_faces')+'" ' +
            'width="90px" ' +
            'share="'+facebook.data('share')+' "></fb:like>'
        ;
        facebook.html(data);
        FB.XFBML.parse();
    }


    function reloadSocialMetaTags(data)
    {
        var data = JSON.parse(data);
        $('meta[property=og\\:title]').attr('content', data.title);
        $('meta[property=og\\:image]').attr('content', data.image);
        $('meta[property=og\\:url]').attr('content', data.url);
        $('meta[property=og\\:description]').attr('content', data.description);
    }

</script>
{/literal}