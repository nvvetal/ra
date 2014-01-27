{include file="modules/admin/header.tpl"}
<div id="myjquerymenu" class="jquerycssmenu clearfix">
<ul>
    {foreach from=$admin_menu item=module}
        <li ><a href="javascript:void(0);">{$module.name}</a>
           {if is_array($module.childs)}
               {include file="modules/admin/menu_items.tpl" commands=$module.childs a_id=$module.id}
           {/if}
        </li>
    {/foreach}
</ul>
</div>
<br clear="all"/>
{if $admin_content ne ''}
    {$admin_content}
{else}
    {"welcome admin text"|i18n}
{/if}


{include file="modules/admin/footer.tpl"}