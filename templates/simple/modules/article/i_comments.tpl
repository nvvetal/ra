<div class="comments">
    <div class="comments-title">{"Comments"|i18n}</div>
    {include file='modules/article/i_comment.tpl' comments=$articleComments level=0}
</div>
{if $user_id > 0}
    <div id="comment_to"></div>
    <form id="comment">
        <textarea name="comment" style="width:95%;height:200px"></textarea>
        <input type="button" name="btnSubmit" value="{"Submit"|i18n}" onclick="addArticleComment(this, $('#comment').serialize(), '{$s}');" />
        <input type="hidden" name="article_id" value="{$articleId}" />
        <input type="hidden" id="p_item_id" name="p_item_id" value="" />
        <input type="hidden" name="s" value="{$s}" />
    </form>
{else}
    <div style="clear:both">{"Please login!"|i18n}</div>
{/if}