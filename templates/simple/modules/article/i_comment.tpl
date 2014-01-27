{assign var="curLevel" value=$level+1}
{foreach name="comment" from=$comments item=comment}
    <div class="comment-container" id="comment-id-{$comment->id}">
        <div class="comment-user">
            <a href="{$http_project_path}?s={$s}&go=profile&user_name={$User->get_value($comment->createdBy,'login')}" target="_blank">{$User->get_value($comment->createdBy,'login')}</a>
        </div>
        <div class="comment">
            {$comment->comment|strip_tags}
        </div>
        {if $user_id > 0}
            <br/>
            <div>
                <a href="#comment_to" onclick="updateReplyForComment('{$comment->id}');">{"Answer"|i18n}</a>
            </div>
        {/if}
        {if $comment->hasChildren()}
            <div style="margin-left: {$curLevel*15}px">
                {include file='modules/article/i_comment.tpl' comments=$comment->getChildren() level=$curLevel}
            </div>
        {/if}
    </div>
    {foreachelse}
    {"No comments"|i18n}
{/foreach}