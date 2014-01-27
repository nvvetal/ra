{include file='header.tpl' script='modules/article/i_javascript.tpl'}

<div class="article-container article-page">
    <img src="{$http_images_static_path}rec_photo.jpg" alt=""/>
</div>

<div class="article-container article-add">
    <a href="?s={$s}&go=add">{"Add article"|i18n}</a>
</div>

{include file='modules/article/i_filter.tpl'}

<div class="article-container">
    <div class="article-container-title">{"Last articles"|i18n}</div>
    {foreach from=$lastArticles.items item=article}
        <div class="article">
            <div class="article-title"><a href="?s={$s}&article_id={$article->id}&go=article">{"article"|i18n} {$article->name}</a></div>
            <div class="article-text">{$article->content_short}</div>
        </div>
    {/foreach}
</div>

{if $lastArticles.pages > 1}
    <div class="article-container article-pager">
        {section name=pager start=1 loop=$lastArticles.pages+1 step=1}
            {if $page != $smarty.section.pager.index}<a href="?go=list&s={$s}&page={$smarty.section.pager.index}">{$smarty.section.pager.index}</a>{else}{$smarty.section.pager.index}{/if}&nbsp;
        {/section}
    </div>div>
{/if}

{include file='footer.tpl'}