<div class="shop_items">
    <div>
        {assign var="sortByType" value=$smarty.request.sortByType|default:'price'}
        {assign var="sortByOrder" value=$smarty.request.sortByOrder|default:'ASC'}

        {"sort by"|i18n}
        <select id="sortByType">
            <option value="price" {if $sortByType == 'price'}selected{/if}>{"sort by price"|i18n}</option>
            <option value="image_id" {if $sortByType == 'image_id'}selected{/if}>{"sort by time"|i18n}</option>
        </select>
        <select id="sortByOrder">
            <option value="ASC" {if $sortByOrder == 'ASC'}selected{/if}>{"sort ascending"|i18n}</option>
            <option value="DESC" {if $sortByOrder == 'DESC'}selected{/if}>{"sort descending"|i18n}</option>
        </select>
        <input type="button" name="btnSort" value="{"Sort"|i18n}" onclick="window.location='{$http_project_path}shop/?go=shop_category&s={$s}&shop_id={$shop->id}&category_id={$shopCategory->id}&sortByType='+$('#sortByType option:selected').val()+'&sortByOrder='+$('#sortByOrder option:selected').val()" />
    </div>
    <br/>
    {assign var="cItems" value=$category->getCategoryItems($sortByType, $sortByOrder)}
    {foreach from=$cItems item=item}
        <div class="shop_item">
            <img src="{$http_images_path}{$item->getImageUrlH(100,'gif')}" alt="" id="shop_gift_id_{$item->id}"/><br/>
            {assign var="raks_cost" value=$item->price}
            <a href="javascript:void(0);" onclick="showSelectGiftUser({$item->id});"><b>{$raks_cost} {$raks_cost|raks_name}</b></a>
        </div>
        {foreachelse}
        {"No goods"|i18n}
    {/foreach}
</div>