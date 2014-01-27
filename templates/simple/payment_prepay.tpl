{include file='header.tpl'}
<div class="title">{"Payment"|i18n}</div>
{"Payment text"|i18n}<br/>

<form action="index.php" method="get">
{"Price, UAH"|i18n}<br/>
<select name="price">
<option value="">{"Please select"|i18n}</option>
{foreach from=$Payment->getPrices('UAH') item=points key=price}
<option value="{$price}">{$price} UAH - {$points} {$points|raks_name}</option>
{/foreach}
</select>
<br/>
<input type="submit" name="{"Submit"|i18n}" value="{"Submit"|i18n}" />
<input type="hidden" name="s" value="{$s}" />
<input type="hidden" name="go" value="payment" />
<input type="hidden" name="action" value="payment_prepare" />
<input type="hidden" name="type" value="prepay" />
</form>
{include file='footer.tpl'}