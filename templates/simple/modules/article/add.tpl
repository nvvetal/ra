{include file='header.tpl' script='modules/article/i_javascript.tpl' showCaptcha=1}
{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            getEditor("content");
            $("#section_id").select2();
        });

    </script>
{/literal}
{include file='i_error.tpl'}
<div class="article-container article-public-description">
    {"Article public description"|i18n}
</div>
<form action="index.php" method="post">
    <table style="width:90%;" align="center">
        <tr>
            <td style="width:100px">{"Article name"|i18n}<span class="required">*</span></td>
            <td>
                <input type="text" name="name" value="{$smarty.request.name|escape}" style="width:100%" />
            </td>
        </tr>
        <tr>
            <td>{"Section"|i18n}<span class="required">*</span></td>
            <td>
                <select name="section_id" id="section_id" style="width:100%">
                    {foreach from=$articleSections.items item=section}
                        <option value="{$section->id}" {if $smarty.request.section_id == $section->id}selected{/if}>{$section->name}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>{"Content Short"|i18n}<span class="required">*</span></td>
            <td>
                <textarea name="content_short" id="content_short" style="height:100px;width:100%">{$smarty.request.content_short}</textarea>
            </td>
        </tr>
        <tr>
            <td>{"Content"|i18n}<span class="required">*</span></td>
            <td>
                <textarea name="content" id="content" style="width:100%">{$smarty.request.content}</textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <div id="recaptcha_div" style="padding-left:100px;"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="btnSubmit" value="{"Add"|i18n}" />
                <input type="button" name="btnBack" value="{"Back back"|i18n}" onclick="location.href='?s={$s}'" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="go" value="edit" />
    <input type="hidden" name="action" value="add" />
    <input type="hidden" name="s" value="{$s}" />
</form>

{include file='footer.tpl'}