{include file='header.tpl'}
<div class="title">{"Payment"|i18n}</div>
{"Payment text 2"|i18n}<br/>

{if $payType eq 'liqpay'}
<form action="https://liqpay.com/?do=clickNbuy" method="POST" >
    <input type="hidden" name="operation_xml" value="{$payData.operationXml}" />
    <input type="hidden" name="signature" value="{$payData.signature}" />
    <input type="submit" name="{"Agree"|i18n}" value="{"Agree"|i18n}" />
</form>
{else}
{"payment error"|i18n}
{/if}

{include file='footer.tpl'}