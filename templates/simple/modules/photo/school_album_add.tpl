{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
<div class="title">{"Album Add"|i18n} :: {$schoolCurrent.name}</div>
{include file='i_error.tpl'}
<form action="index.php" method="post">
    <table style="width:300;" align="center">
        <tr>
            <td width="70">{"Album Name"|i18n}<span class="required">*</span></td>
            <td><input type="text" style="width:100%" name="name" value="{$smarty.request.name}" /></td>
        </tr>
			<tr>
				<td colspan="2" align="center">        
                    <input type="submit" name="btnSubmit" value="{"Album add button"|i18n}"/>
                    <input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?go=school_albums&s={$s}'" />
                </td>
            </tr>
    </table>
    <input type="hidden" name="go" value="school_albums" />
    <input type="hidden" name="action" value="school_album_add" />
    <input type="hidden" name="school_id" value="{$smarty.request.school_id}" />
    <input type="hidden" name="s" value="{$s}" />
</form>
{include file='footer.tpl'}