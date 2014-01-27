<h1>Admin Users List</h1>

<p>There are {TOTAL_USERS} members in your board.</p>

<form action="{U_LIST_ACTION}" method="post">
<p>{L_SELECT_SORT_METHOD}
<select name="sort">
<option value="user_id" class="genmed" {ID_SELECTED} >ID</option>
<option value="username" class="genmed" {USERNAME_SELECTED} >Username</option>
<option value="user_posts" class="genmed" {POSTS_SELECTED} >Posts</option>
<option value="user_lastvisit" class="genmed" {LASTVISIT_SELECTED} >Last Visit</option>
</select>
&nbsp;{L_ORDER}
<select name="order">
<option value="" {ASC_SELECTED} >{L_SORT_ASCENDING}</option>
<option value="DESC" {DESC_SELECTED} >{L_SORT_DESCENDING}</option>
</select>
&nbsp;<input type="submit" value="{L_SORT}" class="liteoption">
</form>

<table width="100%" cellpadding="6" cellspacing="1" border="0" class="forumline">
	<tr>
		<th class="thCornerL" height="25" valign="middle" nowrap="nowrap">ID</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">Action</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">Username</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">Email</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">Posts</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">Joined</th>
		<th class="thTop" height="25" valign="middle" nowrap="nowrap">Last visit</th>
		<th class="thCornerR" height="25" valign="middle" nowrap="nowrap">Active</th>
	</tr>
	<!-- BEGIN userrow -->
	<tr>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.NUMBER}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="gensmall"><a href="{userrow.U_ADMIN_USER}">Edit</a><br /><a href="{userrow.U_ADMIN_USER_AUTH}">Permission</a></span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.USERNAME}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.EMAIL}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.POSTS}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.JOINED}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.LAST_VISIT}</span></td>
		<td class="{userrow.COLOR}" align="center" valign="middle" height="28" nowrap="nowrap"><span class="genmed">{userrow.ACTIVE}</span></td>
	</tr>
	<!-- END userrow -->
	<tr>
		<td class="catBottom" height="28" align="center" valign="middle" colspan="8">
		</td>
	</tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr>
		<td align="left" valign="middle" nowrap="nowrap"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right" valign="middle"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>

<br />
