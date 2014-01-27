<form method="get" action="index.php">
<input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
<input type="hidden" name="s" value="{$s}" />
{"Search"|i18n}<input type="text" name="search" value="{$smarty.request.search}" />
<input type="submit" name="BtnSubmit" value="{"Search"|i18n}" />
</form>
<table>
    <tr>
	<td>{"ID"|i18n}</td>
	<td>{"Login"|i18n}</td>
	<td>{"Email"|i18n}</td>
	<td>{"Type"|i18n}</td>
	<td>{"State"|i18n}</td>
	<td>{"Created"|i18n}</td>
	<td>{"Last Login"|i18n}</td>
	<td>{"Actions"|i18n}</td>
    </tr>
{foreach from=$User->get_users($smarty.request.search,$smarty.request.page,$smarty.request.per_page) item=user_data}
    <tr>
	<td>{$user_data.user_id}</td>
	<td><a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=user&user_id={$user_data.user_id}">{$user_data.login}</a></td>
	<td>{$user_data.email}</td>
	<td>{$user_data.type}</td>
	<td>{$user_data.state}</td>
	<td>{$user_data.createdTime|date_format:'%Y-%m-%d'}</td>
	<td>{$user_data.lastEnterTime|date_format:'%Y-%m-%d'}</td>
	<td>
	    <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=user_edit&user_id={$user_data.user_id}">{"Edit"|i18n}</a>&nbsp;
	    <a href="#" onclick="if(confirm('Are you sure?'))window.location='{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&action=user_delete&user_id={$user_data.user_id}'">{"Delete"|i18n}</a>

	</td>
    </tr>
{foreachelse}
    <tr>
	<td colspan="8">{"No users"|i18n}</td>
    </tr>
{/foreach}

</table>
{include file="i_pager.tpl" max_page=$User->get_users_pages($smarty.request.search,$smarty.request.per_page) request="search|per_page|a_id|a_sid|s"}