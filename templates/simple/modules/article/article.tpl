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
    {if $article->is_enabled eq 'Y'}
        {include file='i_like.tpl'
            url=$http_project_path|cat:'article/?go=article&amp;article_id='|cat:$article_id
            title=$article->name description=$article->content
            image=$http_images_static_path|cat:'logo_real_krug_1024.png'
        }
    {/if}
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

{include file='modules/article/i_article_warning.tpl'}
{include file='footer.tpl'}