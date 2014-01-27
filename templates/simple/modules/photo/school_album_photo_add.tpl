{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
<!-- Load Queue widget CSS and jQuery -->
{literal}
<style type="text/css">@import url({/literal}{$http_project_path}{literal}plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css);</style>

    <!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
    <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>

    <!-- Load plupload and all it's runtimes and finally the jQuery UI queue widget -->
<script type="text/javascript" src="{/literal}{$http_project_path}{literal}plupload/js/plupload.full.js"></script>
<script type="text/javascript" src="{/literal}{$http_project_path}{literal}plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<script type="text/javascript" src="{/literal}{$http_project_path}{literal}plupload/js/i18n/ru.js"></script>
<script type="text/javascript">
    // Convert divs to queue widgets when the DOM is ready
    $(function() {
        $("#uploader").plupload({
            // General settings
            runtimes : 'gears,flash,silverlight,browserplus,html5',
            url : 'index.php',
            max_file_size : '{/literal}{$MAX_UPLOAD_IMAGE_SIZE_READ_MB}{literal}mb',
            unique_names : true,
            multipart_params : {
                's' : '{/literal}{$s}{literal}',
                'action' : 'school_album_photo_add',
                'album_id' : '{/literal}{$smarty.request.album_id}{literal}',
                'school_id' : '{/literal}{$smarty.request.school_id}{literal}'
            },
            // Specify what files to browse for
            filters : [
                {title : "Image files", extensions : "jpg,gif,png"}
            ],
            // Flash settings
            flash_swf_url : '{/literal}{$http_project_path}{literal}plupload/js/plupload.flash.swf'	,
            init : {
                FileUploaded: function(up, file, info) {
                    var obj = jQuery.parseJSON(info.response);
                    $('#photosUploaded').append('<div style="float:left;display:inline;"><img src="'+obj.photoUrl+'" alt="" /><br/><a href="javascript:void(0);" onclick="xajax_showEditPhoto(\''+obj.photoId+'\',\'{/literal}{$s}{literal}\')"><img src="{/literal}{$http_images_static_path}{literal}icons/edit_24x24.png" style="vertical-align: middle;" alt="{/literal}{"Edit photo"|i18n}{literal}" /></a>');
                }
            }
        });

        // Client side form validation
        $('form').submit(function(e) {
            var uploader = $('#uploader').plupload('getUploader');

            // Files in queue upload them first
            if (uploader.files.length > 0) {
                // When all files are uploaded submit form
                uploader.bind('StateChanged', function() {
                    if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                        $('form')[0].submit();
                    }
                });

                uploader.start();
            } else
                alert('You must at least upload one file.');

            return false;
        });
    });
</script>
{/literal}
<div class="title">{"School Album Photos Add"|i18n} :: {$schoolCurrent.name} :: {$schoolAlbum->name}</div>
{include file='i_error.tpl'}
<form>
    <div id="uploader">
        <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
    </div>
</form>
<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?go=school_album_photos&s={$s}&album_id={$smarty.request.album_id}&school_id={$smarty.request.school_id}'" />

<div id="photosUploaded">

</div>

{include file='footer.tpl'}