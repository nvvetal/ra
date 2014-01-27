{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            getEditor("partners_page_content");
        });
    </script>
{/literal}
<center>
    <form method="post" action="index.php">
        <input type="submit" name="{"Submit changes"|i18n}" value="{"Submit changes"|i18n}" />
        <input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
        <input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
        <input type="hidden" name="s" value="{$smarty.request.s}" />
        <input type="hidden" name="ago" value="partners_page" />
        <input type="hidden" name="action" value="set_partners_page" />
        <textarea id="partners_page_content" name="partners_page_content" style="width:100%;height:500px;">{"Partners Page Content"|i18n:'default'}</textarea>

        <input type="submit" name="{"Submit changes"|i18n}" value="{"Submit changes"|i18n}" />
    </form>
</center>
<br clear="all"/>

