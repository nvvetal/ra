{include file='i_error.tpl'}
{assign var="current_city_id" value=$smarty.request.city_id|default:$User->get_value($user_id,'p_city_id')}
{if $current_city_id > 0}
{assign var="city" value=$Geo->get_city($current_city_id)}
{assign var="country" value=$Geo->get_country($city.country_id)}
{assign var="subdivision" value=$Geo->get_subdivision($city.subdivision_id)}
{/if}

<form method="post" enctype="multipart/form-data" action="{$http_project_path}">
<table width="350px">
	<tr>
		<td>{"Your Profile Image"|i18n}</td>	
		<td>
            {if $User->get_value($user_id,'image_id') > 0}
                <img class="avaleft" src="{$http_images_path}{$Images->get_image_url($User->get_value($user_id,'image_id'),100,100,'jpg')}" alt="{"User Image"|i18n}" width="100" height="100" />
            {else}
                <img class="avaleft" src="{$http_images_static_path}u_{$User->get_value($user_id,'p_sex')}.png" / >
            {/if}
		</td>	
	</tr>
	<tr>
		<td>{"Avatar upload"|i18n}</td>	
		<td>
			<input type="file" name="p_avatar_file" />
		</td>	
	</tr>				
	
	<tr>
		<td>{"Sex"|i18n}<span class="required">*</span></td>
		<td>
			<select name="p_sex">
			<option value="female" {if $User->get_value($user_id,'p_sex') == 'female'}selected{/if}>{"Sex Female"|i18n}</option>
			<option value="male" {if $User->get_value($user_id,'p_sex') == 'male'}selected{/if}>{"Sex Male"|i18n}</option>
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
			<input type="text" name="p_first_name" value="{$smarty.request.p_first_name|default:$User->get_value($user_id,'p_first_name')}" style="width:100%;" />
		</td>	
	</tr>	
	<tr>
		<td>{"Last Name"|i18n}</td>	
		<td>
			<input type="text" name="p_last_name" value="{$smarty.request.p_last_name|default:$User->get_value($user_id,'p_last_name')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"From where?"|i18n}<span class="required">*</span></td>	
		<td>
            <select name="country_id" style="width:100%" onchange="xajax_get_country_subdivisions(this.options[this.selectedIndex].value);">
			<option value="">{"Please select"|i18n}</option>
			{foreach from=$Geo->get_countries() item=country_data}
			<option value="{$country_data.id}" {if $country_data.id == $country.id}selected{/if}>{$country_data.name}</option>   
			{/foreach}
			</select>
			<div id="subdivision_id">
                {include file='i_country_subdivisions.tpl' subdivision_id=$subdivision.id country_id=$country.id }
			</div>
			<div id="city_id">
                {include file='i_cities.tpl' subdivision_id=$subdivision.id city_id=$current_city_id }
			</div>
		</td>	
	</tr>
	<tr>
		<td>{"Birthday Date"|i18n}<span class="required">*</span></td>	
		<td>
			{html_select_date prefix='p_birthday_' time=$User->get_value($user_id,'p_birthday') start_year=-100 end_year=-12}
		</td>	
	</tr>
	<tr>
		<td>{"Profession"|i18n}</td>	
		<td>
			<input type="text" name="p_profession" value="{$smarty.request.p_profession|default:$User->get_value($user_id,'p_profession')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"Hobby"|i18n}</td>	
		<td>
			<input type="text" name="p_hobby" value="{$smarty.request.p_hobby|default:$User->get_value($user_id,'p_hobby')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"URL"|i18n}</td>	
		<td>
			<input type="text" name="p_url" value="{$smarty.request.p_url|default:$User->get_value($user_id,'p_url')}" style="width:70%;" />
		</td>	
	</tr>	
	<tr>
		<td>
            <img src="{$http_images_static_path}icq.jpg" alt="{"ICQ"|i18n}" height="20" width="20"/>
		</td>	
		<td>
			<input type="text" name="p_icq" value="{$smarty.request.p_icq|default:$User->get_value($user_id,'p_icq')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>
            <img src="{$http_images_static_path}skype.jpg" alt="{"Skype"|i18n}" height="20" width="20"/>
		</td>	
		<td>
			<input type="text" name="p_skype" value="{$smarty.request.p_skype|default:$User->get_value($user_id,'p_skype')}" style="width:100%;" />
		</td>	
	</tr>
	<tr>
		<td>{"Email"|i18n}<span class="required">*</span></td>	
		<td>
			<input type="text" name="email" value="{$smarty.request.email|default:$User->get_value($user_id,'email')}" style="width:100%;" />
		</td>	
	</tr>	

	<tr>
		<td colspan="2" align="right">
		      <a href="{$http_project_path}?s={$s}&go=profile&user_id={$user_id}">{"View My Profile"|i18n}</a>&nbsp;
		      <input type="submit" name="btnSubmit" value="{"Save profile"|i18n}"/>
		</td>
	</tr>	
</table>


<input type="hidden" name="s" value="{$s}"/>
<input type="hidden" name="go" value="my_profile"/>
<input type="hidden" name="action" value="my_profile_save"/>
</form>
