{include file='modules/article/i_javascript.tpl'}

<table width="100%" align="center">
    <tr>
        <td>{"ID"|i18n}</td>
        <td>{"Name"|i18n}</td>
        <td>{"Image"|i18n}</td>
        <td>{"Short Content"|i18n}</td>
        <td>{"Owner"|i18n}</td>
        <td>{"Created"|i18n}</td>
        <td>{"Last Approved"|i18n}</td>
        <td>{"Operations"|i18n}</td>
    </tr>
    {foreach name="simple" from=$articles.items item=article}
        <tr>
            <td>
                {$article->id}
            </td>
            <td>
                {$article->name}
            </td>
            <td>
                <img src="{$Images->get_image_url($article->image_id,70,70,'jpg')}" alt=""/>
            </td>
            <td style="width: 60%">
                {$article->content_short}
            </td>
            <td>
                {$User->get_value($article->owner_id,'p_last_name')} {$User->get_value($article->owner_id,'p_first_name')}
            </td>
            <td>
                {$article->created_time|date_format:"%d-%m-%Y %T"}
            </td>
            <td>
                {assign var="app_time" value=$article->approved_time}
                {$article->approved_time|date_format:"%d-%m-%Y %T"} ({$article->approve_cnt})
            </td>
            <td>
                <a href="?s={$s}&ago=edit&article_id={$article->id}&r_go=articles&a_id={$smarty.request.a_id}&a_sid=edit">{"Edit"|i18n}</a>
                <br/>
                {if $article->is_enabled eq 'Y'}
                    <a href="javascript:void(0);" onclick="return disable_article('?s={$s}&action=disable_article&article_id={$article->id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}');">{"Disable"|i18n}</a>
                {else}
                    <a href="?s={$s}&action=enable_article&article_id={$article->id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Enable"|i18n}</a>
                {/if}
                <a href="javascript:void(0);" onclick="return delete_article('?s={$s}&action=delete_article&article_id={$article->id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}');">{"Delete"|i18n}</a>
            </td>
        </tr>
        {foreachelse}
        <tr align="center">
            <td colspan="7">
                {"No articles found"|i18n}
            </td>
        </tr>
    {/foreach}
</table>