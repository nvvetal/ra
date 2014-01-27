{include file="modules/admin/i_header.tpl"}
{include file='i_error.tpl'}
<form method="post" action="index.php">
<table width="400" align="center">
<tr>
        <td>
    	    {"Login"|i18n}:
        </td>
        <td>
                <input type="text" name="login" value="" />
        </td>
</tr>
<tr>
        <td>
    	    {"Password"|i18n}:
        </td>
        <td>
                <input type="text" name="password" value="" />
        </td>
</tr>
<tr>
        <td>{"Is autologin?"|i18n}:</td>
        <td><input type="checkbox" name="is_autologin" value="1" /></td>
</tr>
<tr>
        <td colspan="2" align="center">
                <input type="submit" name="btnSubmit" value="{"Log In"|i18n}" />
        </td>
</tr>
</table>
<input type="hidden" name="go" value="index" />
<input type="hidden" name="action" value="login" />
<input type="hidden" name="s" value="{$s}" />
</form>
{include file="modules/admin/i_footer.tpl"}
