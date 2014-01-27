{include file='header.tpl'}
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
{assign var="page" value=$smarty.request.page|default:1}
{assign var="per_page" value=$smarty.request.per_page|default:1000}
{assign var="city_id" value=$smarty.request.city_id|default:'all'}


<table width="100%" align="center">
    <tr>
	<td>{"ID"|i18n}</td>
	<td>{"City"|i18n}</td>
	<td>{"Name"|i18n}</td>
	<td>{"Info"|i18n}</td>
	<td>{"Operations"|i18n}</td>

    </tr>

    {foreach name="simple" from=$school->get_schools($page,$per_page,$city_id,0) item="school"}
	<tr>
	    <td>
		{$school.id}
	    </td>    

	    <td>
		{assign var="city" value=$Geo->get_city($school.city_id)}
		{$city.name|default:'Unknown city'|i18n}
	    </td>    

	    <td>
		{$school.name}
	    </td>    


    	    <td>
		<a href="{$http_module_path}?s={$s}&go=edit_school&school_id={$school.id}&r_go=view_schools">Info && Edit</a>
    	    </td>

	    <td>
		{if $school.is_approved == 1}
		    <a href="{$http_module_path}?s={$s}&action=disable_school&go=view_schools&school_id={$school.id}">{"Disable"|i18n}</a>
		{else}
		    <a href="{$http_module_path}?s={$s}&action=enable_school&go=view_schools&school_id={$school.id}">{"Enable"|i18n}</a>
		{/if}
		<a href="{$http_module_path}?s={$s}&action=delete_school&go=view_schools&school_id={$school.id}">{"Delete"|i18n}</a>
	    </td>
	</tr>
    {foreachelse}
	<tr align="center">
		<td colspan="5">
		    {"No schools found"|i18n}
		</td>
	</tr>
    {/foreach}
</table>
{include file='footer.tpl'}