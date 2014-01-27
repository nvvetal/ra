{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            getEditor("main_page_content");
        });
    </script>
{/literal}
{literal}
<style type="text/css">@import url({/literal}{$http_project_path}{literal}plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css);</style>

    <!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
    <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>

    <!-- Load plupload and all it's runtimes and finally the jQuery UI queue widget -->
    <script type="text/javascript" src="{/literal}{$http_project_path}{literal}plupload/js/plupload.full.js"></script>
    <script type="text/javascript" src="{/literal}{$http_project_path}{literal}plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
    <script type="text/javascript" src="{/literal}{$http_project_path}{literal}plupload/js/i18n/ru.js"></script>
    <script type="text/javascript">
        // Client side form validation
        $('form').submit(function(e) {
            /*
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

            */
            return true;
        });
    });
</script>
{/literal}

<center>
    <form method="post" action="index.php">
        <input type="submit" name="{"Submit changes"|i18n}" value="{"Submit changes"|i18n}" />
        <input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
        <input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
        <input type="hidden" name="s" value="{$smarty.request.s}" />
        <input type="hidden" name="ago" value="main_page" />
        <input type="hidden" name="action" value="set_main_page" />
        <textarea id="main_page_content" name="main_page_content" style="width:100%;height:500px;">{"Main Page Content"|i18n:'default'}</textarea>

        <input type="submit" name="{"Submit changes"|i18n}" value="{"Submit changes"|i18n}" />
    </form>
</center>
<br clear="all"/>

