{assign var="translate" value=$i18n_admin->get_translate_by_id($smarty.request.id)}
{include file='i_error.tpl'}
<form method="post" enctype="multipart/form-data" action="{$http_module_path}index.php">

<table align="center" width="350px">
	<tr>
		<td colspan="2" bgcolor="Blue">{"Edit Key"|i18n}</td>
	</tr>
	<tr>
	    <td colspan="2">
		{"Lang"|i18n}: {$translate.lang}
	    </td>
	</tr>
	<tr>
	    <td>
		{"Name"|i18n}
	    </td>
	</tr>

	<tr>
	    <td>
		{$translate.name}
	    </td>
	</tr>
	<tr>
	    <td>
		{"Translate"|i18n}
	    </td>
	</tr>

	<tr>
	    <td>
		<textarea name="value" style="width:100%;height:200px;">{$translate.value}</textarea>
	    </td>
	</tr>

	<tr>
	    <td colspan="2" align="center">
		<input type="submit" name="btnSubmit" value="{"Save"|i18n}" />
		<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&page={$smarty.request.page}&per_page={$smarty.request.per_page}&search={$smarty.request.search}&search_type={$smarty.request.search_type}&type={$smarty.request.type}&lang={$smarty.request.lang}'" />
	    </td>
	</tr>
</table>


<input type="hidden" name="s" value="{$s}">
<input type="hidden" name="ago" value="i18n_edit_key">
<input type="hidden" name="action" value="i18n_save_key">
<input type="hidden" name="id" value="{$smarty.request.id}">
<input type="hidden" name="a_id" value="{$smarty.request.a_id}">
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}">
<input type="hidden" name="lang" value="{$smarty.request.lang}">
<input type="hidden" name="page" value="{$smarty.request.page}">
<input type="hidden" name="per_page" value="{$smarty.request.per_page}">
<input type="hidden" name="search" value="{$smarty.request.search}">
<input type="hidden" name="search_type" value="{$smarty.request.search_type}">
<input type="hidden" name="type" value="{$smarty.request.type}">
</form>