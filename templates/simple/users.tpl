{include file='header.tpl'}

{"please enter search string and type for search of users"|i18n}
<br/>
<form action="index.php" method="get">
<table width="300" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td style="text-align: right;">
		{"Search text"|i18n}
	</td>
	<td style="text-align: left;" >
		<input type="text" name="search" value="{$smarty.request.search}" />
	</td>
</tr>
<tr>
	<td style="text-align: right;">
		{"Search by"|i18n}
	</td>
	<td style="text-align: left;">
		<select name="type">
			<option value="login" {if $smarty.request.type eq 'login'}selected{/if}>{"by nickname"|i18n}</option>
			<option value="first_name" {if $smarty.request.type eq 'first_name'}selected{/if}>{"by first name"|i18n}</option>
			<option value="city" {if $smarty.request.type eq 'city'}selected{/if}>{"by city"|i18n}</option>

		</select>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<input type="submit" name="{"btnSeacrh"|i18n}" value="{"btnSeacrh"|i18n}" />
	</td>
</tr>
</table>
<input type="hidden" name="go" value="users"/>
<input type="hidden" name="s" value="{$s}"/>
</form>


{"nickname from"|i18n}
{foreach from=$userLetters item=userLetter}
{if $smarty.request.search_letter != $userLetter.l}<a href="?go=users&s={$s}&search_letter={$userLetter.l}">{else}<b>{/if}{$userLetter.l}{if $smarty.request.search_letter != $userLetter.l}</a>{else}</b>{/if}&nbsp;
{/foreach}

{if $users.cnt > 0}
{foreach from=$users.items item=user}
{include file="i_profile_short.tpl" userData=$user}
{include file="i_pager.tpl" request="go|s|search" max_page=$users.pages}
{foreachelse}
{if $smarty.request.search ne ''}
{"no users found"|i18n}<br/>
{/if}
{/foreach}
{/if}

{if $userLettersSelected.cnt > 0}
{foreach from=$userLettersSelected.items item=userByLetter}
{include file="i_profile_short.tpl" userData=$userByLetter}
{/foreach}
{include file="i_pager.tpl" request="go|s|search_letter" max_page=$userLettersSelected.pages}
{/if}

{if $usersAll.cnt > 0}
{foreach from=$usersAll.items item=userAll}
{include file="i_profile_short.tpl" userData=$userAll}
{/foreach}
{include file="i_pager.tpl" request="go|s|all" max_page=$usersAll.pages}
{/if}

{include file='footer.tpl'}