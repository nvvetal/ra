{include file='header.tpl'}
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
<table width="100%" align="center">
	{foreach name="premium" from=$school->get_premium_schools() item="premium_school"}
		<tr align="center">
			<td>
				{assign var="city" value=$Geo->get_city($premium_school.city_id)}
				<b>{$smarty.foreach.premium.iteration}.
				<a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$premium_school.id}">{$premium_school.name|i18n}</a>. {$city.name|default:'Unknown city'|i18n}.</b>
			</td>
		</tr>
	{/foreach}
</table>
{assign var="page" value=$smarty.request.page|default:1}                                                                                   
{assign var="per_page" value=$smarty.request.per_page|default:10}                                                                          
{assign var="city_id" value=$smarty.request.city_id|default:'all'}
<table width="100%" align="center">
	{if $Session->get_value($s,'is_logged') == 1}
		<tr align="center">
			<td><a href="{$http_project_path}schools/?go=add_school&s={$s}">{"Add school"|i18n}</a></td>
			<td><a href="{$http_project_path}schools/?s={$s}&go=my_schools">{"My Schools"|i18n}</a></td>
		</tr>
	{/if}
	{foreach name="simple" from=$school->get_user_schools($user_id) item="simple_school"}
		<tr align="center">
			<td colspan="2">
				{math equation="(page - 1) * per_page + cur_pos" page=$page per_page=$per_page cur_pos = $smarty.foreach.simple.iteration}.
				{assign var="city" value=$Geo->get_city($simple_school.city_id)}
				<a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$simple_school.id}">{$simple_school.name|i18n}</a>. {$city.name|default:'Unknown city'|i18n}.			
			</td>
		</tr>
	{foreachelse}
		<tr align="center">
			<td colspan="2">
				{"No schools found"|i18n}
			</td>
		</tr>
	{/foreach}
</table>
{include file='footer.tpl'}