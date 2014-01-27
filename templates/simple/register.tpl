{include file='header.tpl' showCaptcha=1}
<div class="title">{"Registration"|i18n}</div>
{"register_text_1"|i18n}<br/>
{if $Session->get_value($s,'is_logged') == 0}
	{include file='i_register_form.tpl' is_use_form=1}
{else}
	{"Sorry, but you are already registered!"|i18n}<br/>
{/if}
{include file='footer.tpl'}