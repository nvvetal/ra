<div class="shop_description">
    <span style="font-size: 150%">{"Welcome to shop"|i18n} {$shop->name}</span><br/><br/>
    <span style="font-size: 120%">{"here you can buy gifts for friends"|i18n}</span><br/><br/>
    {if $Session->get_value($s, 'is_logged') != 0}
        {assign var="raks_cost" value=$User->get_raks_money($user_id)}
        {"you have"|i18n} {$raks_cost} {$raks_cost|raks_name}<br/><br/>
    {/if}
    {include file='i_buy_raks.tpl' type="shop" shop=$shop}
    <br/>
</div>