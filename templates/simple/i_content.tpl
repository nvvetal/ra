{literal}
<script type="text/javascript" src="{/literal}{$http_project_path}{literal}galleria/galleria-1.2.5.min.js"></script>
{/literal}
{literal}
<script>
$(document).ready(function() {
  // Handler for .ready() called.
    Galleria.loadTheme('{/literal}{$http_project_path}{literal}galleria/themes/classic/galleria.classic.min.js');
  
    $('#main-photo-gallery').galleria({
        width:680,
        height:500
    });
    Galleria.ready(function(options) {
        this.bind("image", function(e) {

        });
    });
    $( "#cal-tabs" ).tabs();
    $( "#cal-tabs" ).tabs("option", "active", {/literal}{$Utils->get_current_month_index()}{literal});
});    
</script>
{/literal}
<p style="max-width: 691px">
    {"Main Page Content"|i18n}
</p>

{include file='modules/calendar/i_calendar.tpl'}
{include file='i_photos_last.tpl'}
{include file='i_videos_last.tpl'}
{include file="i_forum.tpl"}
{include file="i_article.tpl"}