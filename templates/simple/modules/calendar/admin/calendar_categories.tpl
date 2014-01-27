<a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendar_category_add">{"Add calendar category"|i18n}</a>

<table width="100%" border="1">
{foreach from=$calendar->get_categories() item=category}
    <tr>
        <td width="80%">
            {$category.name}
        </td>
        <td>
            <a href="{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendar_category_edit&category_id={$category.id}">{"edit calendar category"|i18n}</a>
            <a href="javascript:void(0);" onclick="if(confirm('{"Are you sure?"|i18n}'))window.location.href='{$http_module_path}index.php?a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&ago=calendar_categories&action=calendar_category_delete&category_id={$category.id}';">{"delete calendar category"|i18n}</a>
        </td>
    </tr>
{foreachelse}
    <tr>
        <td>
            {"No categories found"|i18n}
        </td>
    </tr>
{/foreach}
</table>