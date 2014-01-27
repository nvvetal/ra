<table width="100%">
    <tr align="center">
	<td>
	    <a href="{$http_project_path}schools/?s={$s}&go=schools">{"Dancing Schools"|i18n}</a>
	</td>
	<td>
	    <a href="{$http_project_path}calendar/?s={$s}">{"Calendar Actions"|i18n}</a>
	</td>	
	<td>
	    <a href="{$http_project_path}forum/">{"Forum"|i18n}</a>
	</td>	
	<td>
	    {if $Session->get_value($s,'is_logged') == 0}
	    <a href="{$http_project_path}?s={$s}&go=register">{"Register"|i18n}</a>
	    {else}
	    <a href="{$http_project_path}?s={$s}&go=my_profile">{"My Profile"|i18n}</a>
	{/if}
	</td>					
    </tr>
</table>