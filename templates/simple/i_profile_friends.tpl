<div>
    {foreach from=$userFriends item=userFriend}
        {assign var='friendUserId' value=$userFriend.friendUserId}
        <a href="{$http_project_path}?s={$s}&go=profile&user_id={$userFriend.friendUserId}">{$User->get_value($friendUserId,'login')}</a><br/>
        {foreachelse}
        {if $isUserEqual == 1}
            {"You not have friends"|i18n}
        {else}
            {"User not have friends"|i18n}
        {/if}
    {/foreach}
    <br/>
    <a href="{$http_module_path}forum/ucp.php?i=168">{"Add friends"|i18n}</a>
</div>
<div style="clear:both; float:none"></div>