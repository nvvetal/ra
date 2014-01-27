{assign var="errors" value=$errors|default:$smarty.request.errors}
{if $errors ne ''}
<table width="100%">
<tr valign="top">
<td style="color:red;font-weight:bold;">
{"Errors"|i18n}
</td>
<td style="color:red;font-weight:bold;">
{foreach from=$errors item=error}
	{$error.message|i18n}<br/>
{/foreach}
</td>
</tr>
</table>
{/if}