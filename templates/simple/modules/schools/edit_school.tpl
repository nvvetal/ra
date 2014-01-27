{include file='header.tpl'}
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        getEditor("descr");
    });
</script>
{/literal}	
<!--
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
-->
<div class="title">{"Edit school"|i18n}</div>
{assign var="current_school" value=$school->get_school($smarty.request.school_id)}
{assign var="current_city_id" value=$smarty.request.city_id|default:$current_school.city_id}
{assign var="city" value=$Geo->get_city($current_city_id)}
{assign var="country" value=$Geo->get_country($city.country_id)}
{assign var="subdivision" value=$Geo->get_subdivision($city.subdivision_id)}
{include file='i_error.tpl'}
<form method="POST" enctype="multipart/form-data">
		<table style="width:100%;">
			<tr valign="top">
				<td width="170">{"Name"|i18n}<span class="required">*</span></td>
				<td><input type="text" name="name" style="width:100%" value="{$smarty.request.name|default:$current_school.name}" /></td>
			</tr>
			<tr valign="top">
			     <td>{"Country"|i18n}</td>
			     <td>
			         <select name="country_id" style="width:100%" onchange="xajax_get_school_country_subdivisions(this.options[this.selectedIndex].value);">
			         <option value="">{"Please select"|i18n}</option>
			         {foreach from=$Geo->get_countries() item=country_data}
			         <option value="{$country_data.id}" {if $country_data.id == $country.id}selected{/if}>{$country_data.name}</option>   
			         {/foreach}
			         </select>
			     </td>
			</tr>
			<tr valign="top">
			     <td>{"Subdivision"|i18n}</td>
			     <td id="subdivision_id">
                    {include file='modules/schools/i_country_subdivisions.tpl' subdivision_id=$subdivision.id country_id=$country.id }
			     </td>			     
			</tr>
			<tr valign="top">
				<td>{"City"|i18n}<span class="required">*</span></td>
				<td id="city_id">				
                    {include file='modules/schools/i_cities.tpl' subdivision_id=$subdivision.id city_id=$current_city_id }
				</td>
			</tr>					
			<tr valign="top">
				<td>{"URL"|i18n}</td>
				<td><input type="text" name="url"  style="width:100%" value="{$smarty.request.url|default:$current_school.url}" /></td>
			</tr>
			<tr valign="top">
				<td>{"FORUM URL"|i18n}</td>
				<td><input type="text" name="forum_url" style="width:100%" value="{$smarty.request.forum_url|default:$current_school.forum_url}" /></td>
			</tr>			
			<tr valign="top">
				<td>{"Email"|i18n}</td>
				<td><input type="text" name="email" style="width:100%" value="{$smarty.request.email|default:$current_school.email}" /></td>
			</tr>
			<tr valign="top">
				<td>{"ICQ"|i18n}</td>
				<td><input type="text" name="icq" style="width:100%" value="{$smarty.request.icq|default:$current_school.icq}" /></td>
			</tr>	
			<tr valign="top">
				<td>{"Skype"|i18n}</td>
				<td><input type="text" name="skype" style="width:100%" value="{$smarty.request.skype|default:$current_school.skype}" /></td>
			</tr>			
			<tr valign="top">
				<td>{"School phone 1"|i18n}<span class="required">*</span></td>
				<td><input type="text" name="phone_1" style="width:100%" value="{$smarty.request.phone_1|default:$current_school.phone_1}" /></td>
			</tr>	
			<tr valign="top">
				<td>{"School phone 2"|i18n}</td>
				<td><input type="text" name="phone_2" style="width:100%" value="{$smarty.request.phone_2|default:$current_school.phone_2}" /></td>
			</tr>	
			<tr valign="top">
				<td>{"Address"|i18n}<span class="required">*</span></td>
				<td><input type="text" name="address" style="width:100%" value="{$smarty.request.address|default:$current_school.address}" /></td>
			</tr>

			<tr valign="top">
				<td>
					{"School description"|i18n}
					<span class="required">*</span>
				</td>
				<td colspan="2">			
					<textarea id="descr" name="description" style="width:100%;height:1000px;">{$smarty.request.description|default:$current_school.description}</textarea>
				</td>
			</tr>	

			<tr valign="top">
				<td>{"Current School Image"|i18n}</td>	
				<td>
					<img src="{$http_images_path}{$Images->get_image_url($current_school.image_id,200,200,'jpg')}" alt="{"School Image"|i18n}" width="200" height="200" />
				</td>	
			</tr>
			
			
			<tr valign="top">
				<td>{"School Image upload"|i18n}, {"max size"|i18n} {$MAX_UPLOAD_IMAGE_SIZE_READ_KB} {"kilobytes"|i18n}</td>	
				<td>
					<input type="file" name="school_image_file" />
				</td>	
			</tr>			
			<tr valign="top">
				<td colspan="2" align="center">
					<input type="submit" name="btnSubmit" value="{"Edit school"|i18n}" />
					<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?go={$smarty.request.r_go|default:'my_schools'}&s={$s}'" />
				</td>
			</tr>				
					
		</table>
<input type="hidden" name="MAX_FILE_SIZE" value="{$MAX_UPLOAD_IMAGE_SIZE}" />
<input type="hidden" name="s" value="{$s}" />
<input type="hidden" name="go" value="{$smarty.request.r_go|default:'my_schools'}" />
<input type="hidden" name="school_id" value="{$smarty.request.school_id}" />
<input type="hidden" name="action" value="edit_school" />
</form>


{include file='footer.tpl'}