{include file='header.tpl' script='modules/article/i_javascript.tpl'}

<div class="article-container article-page">
    <img src="{$http_images_static_path}article.jpg" alt=""/>
</div>

<div class="article-container article-add">
    <a href="?s={$s}&go=add">{"Add article"|i18n}</a>
</div>

{include file='modules/article/i_filter.tpl'}

<div class="article-container">
    <div class="article-container-title">{"Last articles"|i18n}</div>
    {foreach from=$lastArticles.items item=article}
        <div class="article">
            {if $article->image_id > 0}
                {assign var="articleImage" value=$Images->get_image_url_center_square($article->image_id, 70,'jpg')}
                {assign var="articleImage" value=$http_images_path|cat:$articleImage}
            {else}
                {assign var="articleImage" value=$http_images_static_path|cat:'logo_real_krug_1024.png'}
            {/if}
            <img style="margin: 5px 10px 10px 0px;float:left" src="{$articleImage}" alt="{"Article Image"|i18n}" width="70" height="70" />

            <div class="article-title"><a href="?s={$s}&article_id={$article->id}&go=article">{"article"|i18n} {$article->name}</a></div>
            <div class="article-text">{$article->content_short}</div>
        </div>
        <br clear="both">
    {/foreach}
</div>

{if $lastArticles.pages > 1}
    <div class="article-container article-pager">
        {section name=pager start=1 loop=$lastArticles.pages+1 step=1}
            {if $page != $smarty.section.pager.index}<a href="?go=list&s={$s}&page={$smarty.section.pager.index}&section_id={$sectionId}">{$smarty.section.pager.index}</a>{else}{$smarty.section.pager.index}{/if}&nbsp;
        {/section}
    </div>
{/if}
{include file='modules/article/i_article_warning.tpl'}
{include file='footer.tpl'}