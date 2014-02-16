<h2 class="main"><a href="{$http_project_path}article/index.php?s={$s}"><img src="{$http_images_static_path}last_article.jpg" alt=""></a></h2>
<ul class="rec_forum">
    {foreach from=$lastArticles.items item=article}

        <li>
            {if $article->image_id > 0}
                {assign var="articleImage" value=$Images->get_image_url_center_square($article->image_id, 70,'jpg')}
                {assign var="articleImage" value=$http_images_path|cat:$articleImage}
            {else}
                {assign var="articleImage" value=$http_images_static_path|cat:'logo_real_krug_1024.png'}
            {/if}
            <img style="margin: 5px 10px 10px 0px;float:left" src="{$articleImage}" alt="{"Article Image"|i18n}" width="70" height="70" />

            <a href="/article/?s={$s}&article_id={$article->id}&go=article"><strong>{"article"|i18n:'article'} {$article->name}</strong></a>
            <div style="text-align: justify;">{$article->content_short}</div>
            <br clear="both">
        </li>
    {/foreach}
</ul>