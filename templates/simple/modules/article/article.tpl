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
    <div class="fb-like" data-href="http://raks.com.ua/article/?go=article&article_id={$article_id}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
    <div id="vk_like"></div>
    {literal}
    <script type="text/javascript">
        window.onload = function () {
            VK.init({apiId: {/literal}{$vkontakte_app_id}{literal}, onlyWidgets: true});
            VK.Widgets.Like('vk_like', {type: "button", height: 20, width: 500, pageTitle: '{/literal}{$article->name}{literal}', pageDescription: '{/literal}{$article->content|strip_tags|truncate:255:"..."}{literal}'}, {/literal}{$article->id}{literal});
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

{include file='footer.tpl'}