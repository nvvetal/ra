{literal}
<script type="text/javascript">
<!--
function change_address(id,default_value){
    var item = document.getElementById(id);

    if(item.value == default_value) item.value = '';
}

function change_calendar_date(){
    window.location = '?go=calendar&current_year='+document.getElementById('chosed_dateYear').value+'&current_month='+document.getElementById('chosed_dateMonth').value+'&s='+{/literal}'{$s}'{literal};
}

function disable_calendar(url){
    var disableText = prompt("{/literal}{"Please type reason"|i18n}{literal}","");
    if(disableText != '' && disableText != null){
        window.location.href = url + '&reason='+disableText;
        return true;
    }
    alert("{/literal}{"Error: You are not typed reason!"|i18n}{literal}");
    return false;
}

-->
</script>
{/literal}