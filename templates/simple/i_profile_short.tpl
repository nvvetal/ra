<table>
	<tr>
		<td width="110" height="110">
            {if $User->get_value($userData.user_id,'image_id') > 0}
                <img src="{$http_images_path}{$Images->get_image_url($User->get_value($userData.user_id,'image_id'),100,100,'jpg')}" alt="{"User Image"|i18n}" width="100" height="100" />
            {else}
                <img src="{$http_images_static_path}u_{$User->get_value($userData.user_id,'p_sex')}.png" width="100" / >
            {/if}
		</td>
		<td valign="top">
			<a href="{$http_project_path}?s={$s}&go=profile&user_id={$userData.user_id}">{$userData.login}</a><br/>
			<a href="{$http_project_path}forum/ucp.php?i=pm&mode=compose&u={$User->get_value($userData.user_id,'forum')}">{"Send Message"|i18n}</a><br/>			
		</td>
	</tr>
</table>
<br/>