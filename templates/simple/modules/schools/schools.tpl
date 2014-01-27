{include file='header.tpl'}
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
{assign var="searchFilter" value=$User->get_session_data('schoolsSearchData')}
{assign var="page" value=$searchFilter.page}
{assign var="per_page" value=$searchFilter.per_page}
{assign var="order_by" value=$searchFilter.order_by}

{include file="modules/schools/i_search_school.tpl"}
{include file="modules/schools/i_schools_pager.tpl" type="search"}

{assign var="schools" value=$school->get_schools_search($searchFilter) }

{if $Session->get_value($s,'is_logged') == 1}
<table width="100%" align="center">
    <tr align="center">
	   <td><a href="{$http_project_path}schools/?go=add_school&s={$s}">{"Add school"|i18n}</a></td>
	   <td><a href="{$http_project_path}schools/?s={$s}&go=my_schools">{"My Schools"|i18n}</a></td>
    </tr>
</table>
{/if}
<br/>
{include file="modules/schools/i_premium_schools.tpl"}
<br/>
<table width="100%" cellpadding="5">
    {foreach name="simple" from=$schools item="simple_school"}
    	{assign var="schoolCity" value=$Geo->get_city($simple_school.city_id)}
    	{assign var="schoolCountry" value=$Geo->get_country_by_city($simple_school.city_id)}

        <tr valign="top">
                <div class="schoolname"><a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$simple_school.id}">{math equation="(page - 1) * per_page + cur_pos" page=$page per_page=$per_page cur_pos = $smarty.foreach.simple.iteration}. {$simple_school.name}</a></div>
                <div class="school-address"><a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$simple_school.id}">{$schoolCountry.name}, {$schoolCity.name}, {$simple_school.address}</a></div>
                <div class="school-description" onclick="window.location.href='{$http_project_path}schools/?s={$s}&go=school&school_id={$simple_school.id}'">{$simple_school.description|strip_tags|bbcode|maxstring:100}</div>
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
{include file="modules/schools/i_schools_pager.tpl" type="search"}
{include file='footer.tpl'}