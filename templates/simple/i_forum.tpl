<h2 class="main"><a href="{$http_project_path}forum/"><img src="{$http_images_static_path}rec_forumthem.jpg" alt=""></a></h2>
{assign var="forum_parser" value=$ClassLoader->loadModuleClass('forum_parser','forum')}
<ul class="rec_forum">
    {foreach from=$forum_parser->get_last_posts_by_topic() item=post}
        <li><strong><a href="{$http_project_path}forum/viewtopic.php?f={$post.forum_id}&t={$post.topic_id}&p={$post.post_id}#p{$post.post_id}">{$post.topic_title}</a></strong><br/>
            {"Created by"|i18n:'forum'} <a href="{$http_project_path}?s={$s}&go=profile&user_name={$post.username}">{$post.username}</a>, {"topic date"|i18n:'forum'} {$post.post_time|date_format:'%d.%m.%Y %H:%M'},
            {"topic views"|i18n:'forum'} {$post.topic_views}, {"topic replies"|i18n:'forum'} {$post.topic_replies}
        </li>
    {/foreach}
</ul>