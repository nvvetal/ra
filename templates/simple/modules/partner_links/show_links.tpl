{foreach from=$partner_links->get_links_show($user_id) item=link}
    <a href="{$http_module_path}?action=link_click&id={$link.id}">{$link.name}</a>&nbsp;
{/foreach}