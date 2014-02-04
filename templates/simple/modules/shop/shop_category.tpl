{include file='header.tpl' script='modules/shop/i_javascript.tpl'}
{literal}
    <script>
        $(document).ready(function() {
            $( "#user_select" ).autocomplete({
                source: "search.php",
                minLength: 2
            });
        });
    </script>
{/literal}

<table>
    <tr valign="top">
        <td>
            {include file='modules/shop/i_shop_categories.tpl' shopCategories=$shop->getCategories() shop=$shop shopCategorySelected=$smarty.request.category_id}
        </td>
        <td>
            {include file='modules/shop/i_shop_description.tpl' shop=$shop from=category}
            {include file='modules/shop/i_shop_category_goods.tpl' category=$shopCategory page=$smarty.request.page|default:1 perPage=9}
        </td>
    </tr>
</table>
{include file='modules/shop/i_select_gift.tpl'}
{include file='footer.tpl'}