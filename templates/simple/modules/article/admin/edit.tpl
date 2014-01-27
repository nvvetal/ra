{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            getEditor("content, reason");
            $("#section_id").select2();
        });
    </script>
{/literal}

{include file='i_error.tpl'}
<form action="index.php" method="post">
    <table style="width:90%;" align="center">
        <tr>
            <td style="width:100px">{"Article name"|i18n}<span class="required">*</span></td>
            <td>
                <input type="text" name="name" value="{$article->name}" style="width:100%" />
            </td>
        </tr>
        <tr>
            <td>{"Section"|i18n}<span class="required">*</span></td>
            <td>
                <select name="section_id" id="section_id" style="width:100%">
                    {foreach from=$articleSections.items item=section}
                        <option value="{$section->id}" {if $article->section_id == $section->id}selected{/if}>{$section->name}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>{"Content Short"|i18n}<span class="required">*</span></td>
            <td>
                <textarea name="content_short" id="content_short" style="height:100px;width:100%">{$article->content_short}</textarea>
            </td>
        </tr>
        <tr>
            <td>{"Content"|i18n}<span class="required">*</span></td>
            <td>
                <textarea name="content" id="content" style="width:100%">{$article->content}</textarea>
            </td>
        </tr>
        <tr>
            <td>{"Moderation reason"|i18n}</td>
            <td>
                <textarea name="reason" id="reason" style="width:100%">{$article->reason}</textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="btnSubmit" value="{"Edit"|i18n}"/>
                <input type="button" name="btnBack" value="{"Back"|i18n}" onclick="location.href='?a_sid=articles&a_id={$smarty.request.a_id}&ago=articles&s={$s}'" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="s" value="{$s}" />
    <input type="hidden" name="article_id" value="{$article->id}" />
    <input type="hidden" name="ago" value="edit" />
    <input type="hidden" name="action" value="edit_article" />
    <input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
    <input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
</form>
