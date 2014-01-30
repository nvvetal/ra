{include file='header.tpl' script='modules/shop/i_javascript.tpl'}
<table>
    <tr valign="top">
        <td>
            {include file='modules/shop/i_shop_categories.tpl' shopCategories=$shop->getCategories() shop=$shop}
        </td>
        <td>
            {include file='modules/shop/i_shop_description.tpl' shop=$shop}
        </td>
    </tr>
</table>
{include file='footer.tpl'}