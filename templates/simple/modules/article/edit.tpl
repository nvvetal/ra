{include file='header.tpl' script='modules/article/i_javascript.tpl'}
{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            getArticleEditor("content");
            $("#section_id").select2();
        });
    </script>
{/literal}

{if $article->approved_time == 0}
    <div class="article-container article-moderation-wait">{"article is still not approved, please wait for moder actions"|i18n}</div>
{elseif $article->is_enabled eq 'N'}
<div class="article-container article-moderation-error">{$article->reason}</div>
{/if}

{include file='i_error.tpl'}
<form action="index.php" method="post" enctype="multipart/form-data">
    <table style="width:90%;" align="center">
        <tr>
            <td style="width:100px">{"Article name"|i18n}<span class="required">*</span></td>
            <td>
                <input type="text" name="name" value="{$article->name|escape}" style="width:100%" />
            </td>
        </tr>
        <tr valign="top">
            <td>{"Current Article Image"|i18n}</td>
            <td>
                <img src="{$http_images_path}{$Images->get_image_url($article->image_id,70,70,'jpg')}" alt="{"Article Image"|i18n}" width="70" height="70" />
            </td>
        </tr>
        <tr valign="top">
            <td>{"Article image"|i18n}, {"max size"|i18n:'default'} {$MAX_UPLOAD_IMAGE_SIZE_READ_KB} {"kilobytes"|i18n:'default'}<span class="required">*</span></td>
            <td>
                <input type="file" name="article_image_file"  />
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
                <textarea name="content" id="content" style="width:100%;height:1000px;">{$article->content}</textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input type="submit" name="btnSubmit" value="{"Edit"|i18n}"/>
                <input type="button" name="btnBack" value="{"Back to article"|i18n}" onclick="location.href='?s={$s}&go=article&article_id={$article->id}'" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="go" value="edit" />
    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="s" value="{$s}" />
    <input type="hidden" name="article_id" value="{$article->id}" />
</form>

{include file='footer.tpl'}