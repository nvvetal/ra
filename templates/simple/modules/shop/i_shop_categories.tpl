<div class="shop_categories_container">
<div class="shop_categories_title">
	{"Shop categories"|i18n}
</div>
{foreach name="shopCategory" from=$shopCategories.items item=shopCategory}
{if $smarty.foreach.shopCategory.first == true}
<div class="shop_categories">
{/if}
<div><a href="{$http_project_path}shop/?go=shop_category&s={$s}&shop_id={$shop->id}&category_id={$shopCategory->id}&sortByType={$smarty.request.sortByType}&sortByOrder={$smarty.request.sortByOrder}">{if $shopCategory->id == $shopCategorySelected}<b>{/if}{$shopCategory->name}{if $shopCategory->id == $shopCategorySelected}</b>{/if}</a></div>
{if $smarty.foreach.shopCategory.last == true}
</div>
{/if}
{foreachelse}
{"No shop categories"|i18n}
{/foreach}
</div>