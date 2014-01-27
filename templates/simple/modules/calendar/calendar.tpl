{include file='header.tpl' script='modules/calendar/i_javascript.tpl'}
{literal}
<script>
$(document).ready(function() {
    $( "#cal-tabs" ).tabs();
    $( "#cal-tabs" ).tabs("option", "active", {/literal}{$Utils->get_current_month_index()}{literal});
});    
</script>
{/literal}
{include file='modules/calendar/i_calendar.tpl' isAddCalendar=1}
{include file='footer.tpl'}