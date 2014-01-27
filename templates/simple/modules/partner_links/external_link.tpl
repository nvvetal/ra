{assign var="link" value=$partner_links->get_link($smarty.request.id)}
{literal}document.write('{/literal}<a href="{$http_module_path}?action=link_click_external&id={$link.id}">{$link.external_name|default:"raks.com.ua"}</a>{literal}');{/literal}

