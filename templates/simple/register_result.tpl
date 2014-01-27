{include file='header.tpl' showCaptcha=1}
<div class="title">{"Registration result"|i18n}</div>
{if isset($errors)}
	{include file='i_register_form.tpl' is_use_form=1}
{else}
    {"User registered sucessfully!"|i18n}
    <div class="title">{"Fill Your Profile"|i18n}</div>
    {include file='i_my_profile.tpl'}
{/if}
{include file='footer.tpl'}