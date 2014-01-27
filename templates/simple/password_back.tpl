{include file='header.tpl'}
<div class="title">{"Password back"|i18n}</div>
{"password_back_text_1"|i18n}<br/>
{if $is_send ne ''}{"password succesfully send"|i18n}<br/>{/if}
{include file='i_error.tpl'}
<form method="post" action="{$http_project_path}">
<table width="400px" align="center">
<tr>
	<td>{"Email"|i18n}:</td>
	<td><input value="" name="email" type="text"/></td>
</tr>	
<tr>
	<td colspan="2" align="center"><input type="submit" name="btnSubmit" value="{"Send on email"|i18n}" /></td>
</tr>
</table>
	
<input type="hidden" name="go" value="password_back" />
<input type="hidden" name="action" value="password_back" />
<input type="hidden" name="s" value="{$s}" /> 
</form>
{"password_back_text_2"|i18n}
{include file='footer.tpl'}