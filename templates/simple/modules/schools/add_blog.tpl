{include file='header.tpl'}
{include file='i_horizontal_menu.tpl'}
{assign var="current_school" value=$school->get_school($smarty.request.school_id)} 

<div style="text-align: center;">
{"New blog theme for school"|i18n} {$current_school.name}
</div>
{include file='i_error.tpl'}
<form method="POST" enctype="multipart/form-data">
<table align="center" width="400px;">
{if $smarty.request.pid ne ''}
{assign var="message_parent" value=$school_blog->get_blog_message($smarty.request.pid)}
<tr>
    <td>{"Parent message"|i18n}</td>
    <td>{$message_parent.text}</td>
</tr>
{/if}
<tr>
    <td height="200px;">{"Message"|i18n}</td>
    <td><textarea name="text" style="width:100%;height:100%;"/>{$smarty.request.text}</textarea></td>
</tr>		

<tr>
    <td colspan="2" align="center">
	<input type="submit" name="btnSubmit" value="{"Submit"|i18n}" />
	<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='{$http_module_path}?s={$s}&go=school&school_id={$smarty.request.school_id}'" />
    </td>
</tr>
</table>

<input type="hidden" name="s" value="{$s}" />
<input type="hidden" name="go" value="school" />
<input type="hidden" name="school_id" value="{$smarty.request.school_id}" />
<input type="hidden" name="pid" value="{$smarty.request.pid}" />
<input type="hidden" name="action" value="add_blog" />
</form>


{include file='footer.tpl'}