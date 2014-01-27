{foreach from=$child_item item=message}
    <li>
	 {$message.text} {if $message.author_id == $current_school.owner_id}<b>{/if}(<a href="{$http_project_path}?s={$s}&go=profile&user_id={$message.author_id}">{$User->get_value($message.author_id,'login')}</a>) {if $message.author_id == $current_school.owner_id}</b>{/if} {if $user_id != 0}<a href="{$http_module_path}?s={$s}&go=add_blog&school_id={$smarty.request.school_id}&pid={$message.id}">{"Answer"|i18n}</a>{/if}<br/>
	
    {if isset($message.childs)}
	    <ul>{include file="modules/schools/i_school_blogs.tpl" child_item=$message.childs}</ul>
    {/if}
    </li>
{/foreach}