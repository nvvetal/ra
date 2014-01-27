<a href="{$http_project_path}?s={$s}">{"Main page"|i18n}</a><br/>
{if $User->get_value($user_id,'admin_partner_links') == 1}<a href="{$http_project_path}partner_links/?s={$s}">{"Links page"|i18n}</a><br/>{/if}
{if $User->get_value($user_id,'admin_schools') == 1}<a href="{$http_project_path}schools/?s={$s}&go=view_schools">{"Schools page"|i18n}</a><br/>{/if}
<a href="{$http_project_path}calendar/?s={$s}">{"Calendar page"|i18n}</a><br/>

