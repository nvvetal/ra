<h2 class="main"><a href="{$http_project_path}article/index.php?s={$s}"><img src="{$http_images_static_path}last_article.jpg" alt=""></a></h2>
<ul class="rec_forum">
    {foreach from=$lastArticles.items item=article}
        <li>
            <a href="/article/?s={$s}&article_id={$article->id}&go=article"><strong>{"article"|i18n:'article'} {$article->name}</strong></a>
            <div style="text-align: justify;">{$article->content_short}</div>
        </li>
    {/foreach}
</ul>