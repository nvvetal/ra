{include file='i_error.tpl'}
<form method="post" enctype="multipart/form-data" action="{$http_module_path}index.php">
<table align="center" width="350px">
	<tr>
		<td colspan="2" bgcolor="Blue">{"Edit User Profile"|i18n} - {$User->get_value($smarty.request.user_id,'login')}</td>
	</tr>
	<tr>
		<td>{"Profile Image"|i18n}</td>	
		<td>
			<img src="{$http_images_path}{$Images->get_image_url($User->get_value($smarty.request.user_id,'image_id'),100,100,'jpg')}" alt="{"Your Profile Image"|i18n}" width="100" height="100" />
		</td>	
	</tr>	
	<tr>
		<td>{"Avatar upload"|i18n}</td>	
		<td>
			<input type="file" name="p_avatar_file" />
		</td>	
	</tr>				
	<tr>
		<td>{"Sex"|i18n}</td>
		<td>
			<select name="p_sex">
			<option value="unknown" {if $User->get_value($smarty.request.user_id,'p_sex') == 'unknown'}selected{/if}>{"Sex Unknown"|i18n}</option>
			<option value="male" {if $User->get_value($smarty.request.user_id,'p_sex') == 'male'}selected{/if}>{"Sex Male"|i18n}</option>
			<option value="female" {if $User->get_value($smarty.request.user_id,'p_sex') == 'female'}selected{/if}>{"Sex Female"|i18n}</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>{"Reputation"|i18n}</td>	
		<td>
			
		</td>	
	</tr>
	<tr>
		<td>{"First Name"|i18n}</td>	
		<td>
			<input type="text" name="p_first_name" value="{$smarty.request.p_first_name|default:$User->get_value($smarty.request.user_id,'p_first_name')}" style="width:100%;" />
		</td>	
	</tr>	
	<tr>
		<td>{"Last Name"|i18n}</td>	
		<td>
			<input type="text" name="p_last_name" value="{$smarty.request.p_last_name|default:$User->get_value($smarty.request.user_id,'p_last_name')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"From where?"|i18n}</td>	
		<td>
			<input type="text" name="p_from_location" value="{$smarty.request.p_from_location|default:$User->get_value($smarty.request.user_id,'p_from_location')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"Birthday Date"|i18n}</td>	
		<td>
			{html_select_date prefix='p_birthday_' time=$User->get_value($smarty.request.user_id,'p_birthday') start_year=1900 end_year=-10}
		</td>	
	</tr>
	<tr>
		<td>{"Profession"|i18n}</td>	
		<td>
			<input type="text" name="p_profession" value="{$smarty.request.p_profession|default:$User->get_value($smarty.request.user_id,'p_profession')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"Hobby"|i18n}</td>	
		<td>
			<input type="text" name="p_hobby" value="{$smarty.request.p_hobby|default:$User->get_value($smarty.request.user_id,'p_hobby')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"URL"|i18n}</td>	
		<td>
			http://<input type="text" name="p_url" value="{$smarty.request.p_url|default:$User->get_value($smarty.request.user_id,'p_url')}" style="width:70%;" />
		</td>	
	</tr>	
	<tr>
		<td>{"ICQ"|i18n}</td>	
		<td>
			<input type="text" name="p_icq" value="{$smarty.request.p_icq|default:$User->get_value($smarty.request.user_id,'p_icq')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"Skype"|i18n}</td>	
		<td>
			<input type="text" name="p_skype" value="{$smarty.request.p_skype|default:$User->get_value($smarty.request.user_id,'p_skype')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"Email"|i18n}</td>	
		<td>
			<input type="text" name="email" value="{$smarty.request.email|default:$User->get_value($smarty.request.user_id,'email')}" style="width:100%;" />
		</td>
	</tr>
	<tr>
		<td>{"User Type"|i18n}</td>
		<td>
			<select name="type">
			<option value="guest" {if $User->get_value($smarty.request.user_id,'type') == 'guest'}selected{/if}>{"Guest"|i18n}</option>
			<option value="user" {if $User->get_value($smarty.request.user_id,'type') == 'user'}selected{/if}>{"User"|i18n}</option>
			<option value="vip_user" {if $User->get_value($smarty.request.user_id,'type') == 'vip_user'}selected{/if}>{"Vip User"|i18n}</option>
			<option value="moderator" {if $User->get_value($smarty.request.user_id,'type') == 'moderator'}selected{/if}>{"Moderator"|i18n}</option>
			<option value="admin" {if $User->get_value($smarty.request.user_id,'type') == 'admin'}selected{/if}>{"Admin"|i18n}</option>

			</select>
		</td>
	</tr>
	<tr>
		<td>{"State"|i18n}</td>
		<td>
			<select name="state">
			<option value="not_active" {if $User->get_value($smarty.request.user_id,'state') == 'not_active'}selected{/if}>{"Not active"|i18n}</option>
			<option value="active" {if $User->get_value($smarty.request.user_id,'state') == 'active'}selected{/if}>{"Active"|i18n}</option>
			<option value="banned" {if $User->get_value($smarty.request.user_id,'state') == 'banned'}selected{/if}>{"Banned"|i18n}</option>
			</select>
		</td>
	</tr>

	<tr>
	    <td colspan="2" align="center">
		<input type="submit" name="btnSubmit" value="{"Save profile"|i18n}" />
		<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}'" />
	    </td>
	</tr>
</table>
<input type="hidden" name="s" value="{$s}">
<input type="hidden" name="ago" value="user_edit">
<input type="hidden" name="action" value="user_save">
<input type="hidden" name="user_id" value="{$smarty.request.user_id}">
<input type="hidden" name="a_id" value="{$smarty.request.a_id}">
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}">
</form>