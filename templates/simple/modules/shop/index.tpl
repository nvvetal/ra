{include file='header.tpl' script='modules/shop/i_javascript.tpl'}
<table class="shop_list" align="center">
    <tr>
        <th>{"Shop Name"|i18n}</th>
        <th>{"Shop Goods"|i18n}</th>
    </tr>
    {foreach from=$shopsData.items item=shop}
        <tr>
            <td>
                <a href="{$http_project_path}shop/?go=shop&s={$s}&shop_id={$shop->id}">{$shop->name}</a>
            </td>
            <td class="goods">
                {$shop->getGoodsCount()}
            </td>
        </tr>
    {/foreach}
</table>
{include file='footer.tpl'}