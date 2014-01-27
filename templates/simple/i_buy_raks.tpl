{if $type eq 'shop'}
	<a href="{$http_project_path}?s={$s}&go=payment_prepay&from=shop">{"buy raks shop link"|i18n:shop}</a><br/>
{/if}
{if $type eq 'shop_category'}
	<a href="{$http_project_path}?s={$s}&go=payment_prepay&from=shop">{"buy raks shop goods link"|i18n:shop}</a><br/>
{/if}