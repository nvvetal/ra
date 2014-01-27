{literal}
<script type="text/javascript">
<!--
function disable_school(url){
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