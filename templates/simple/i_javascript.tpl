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
                { name: 'editing', groups: [ 'find', 'selection'], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
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
    }

    function getArticleEditor(containers, params)
    {
        params = params || {};
        params.youtube = true;
        getEditor(containers, params);
        CKEDITOR.replace( containers, {height: '1000px'});
    }
</script>
{/literal}