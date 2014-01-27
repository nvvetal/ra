{include file='header.tpl'}
<div class="title">{"Login"|i18n}</div>
{"login_text_1"|i18n}
{include file='i_error.tpl'}
<form method="post" action="{$http_project_path}">
<table width="400px" align="center">
<tr>
	<td>{"Login"|i18n}:</td>
	<td><input value="{"type login"|i18n:'default'}" name="login" type="text" onfocus="if(this.value == '{"type login"|i18n:'default'}')this.value='';"/></td>
</tr>	
	
<tr>
	<td>{"Password"|i18n}:</td>
	<td><input value="{"type password"|i18n:'default'}" name="password" type="text" onfocus="if(this.value == '{"type password"|i18n:'default'}')this.value='';"/></td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="btnSubmit" value="{"Login"|i18n}" /></td>
</tr>
</table>
	
<input type="hidden" name="is_autologin" value="1" />
<input type="hidden" name="go" value="index" />
<input type="hidden" name="action" value="login" />
<input type="hidden" name="s" value="{$s}" /> 
</form>
{"login_text_2"|i18n}

{include file='footer.tpl'}