{include file='header.tpl' script='modules/article/i_javascript.tpl' article_name=$article->name article_description=$article->content|strip_tags|truncate:255:"..."}
{literal}
<script>
    $(document).ready(function(){
        {/literal}xajax_getArticleAdditional('{$article_id}', '{$s}');{literal}
    });
</script>
{/literal}
<div class="article-container article-section">
    <a href="?s={$s}">{"Articles"|i18n}</a> - <a href="?s={$s}&go=list&section_id={$articleSection->id}">{$articleSection->name}</a>
</div>
{if $article->owner_id == $user_id}
    <div class="article-container article-edit">
        <a href="?s={$s}&article_id={$article_id}&go=edit"><img src="{$http_images_static_path}icons/edit_24x24.png" alt="" /></a>
    </div>
{/if}
<div class="article-container article-name">
    <div>{$article->name}</div>
    <table style="width:100%">
        <tr>
            <td align="right">
                <div style="vertical-align: middle" class="fb-like" data-href="{$http_project_path}article/?go=article&article_id={$article_id}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
            </td>
            <td align="left">
                <div id="vk_share_button" style="margin-top: 4px;"></div>
            </td>
        </tr>
    </table>
    {literal}
    <script type="text/javascript">
        window.onload = function () {
            VK.init({apiId: {/literal}{$vkontakte_app_id}{literal}, onlyWidgets: true});
            $('#vk_share_button').html(VK.Share.button({
                url: '{/literal}{$http_project_path|cat:'article/?go=article&amp;article_id='|cat:$article_id|urlencode}{literal}',
                title: '{/literal}{$article->name|escape:'javascript'}{literal}',
                description: '{/literal}{$article->content|strip_tags|truncate:255:"..."|escape:'javascript'}{literal}',
                image: '{/literal}{$http_images_static_path}logo_real_krug_1024.png{literal}',
                noparse: true
            },{
                type: "round",
                text: "Поделиться"
            }));
        }
    </script>
    {/literal}
</div>

<div class="article-container article-content">
    {$article->content}
</div>

<div class="article-container article-edit">
    {$User->get_value($article->owner_id,'p_last_name')} {$User->get_value($article->owner_id,'p_first_name')}<br/>
    {$article->created_time|date_format:'%d.%m.%y'}<br/>
    {if $article->owner_id == $user_id}<a href="?s={$s}&article_id={$article_id}&go=edit"><img src="{$http_images_static_path}icons/edit_24x24.png" alt="" /></a>{/if}
</div>

<div class="article-container" id="votings"></div>
<br/>
<div class="article-container" id="comments"></div>
{literal}
<script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
{/literal}
{include file='footer.tpl'}