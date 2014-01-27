{"Example"|i18n}<br/>
<script type="text/javascript" src="{$http_module_path}dynamic_links.php"></script>
<br/>
<br/>
<form method="post" action="index.php">
{"Visible_name"|i18n}
<input type="text" name="visible_name" value="{$partner_links->get_config_value('visible_name')|escape}" />

<input type="submit" name="btnSubmit" value="{"Set"|i18n}" />
<input type="hidden" name="s" value="{$s}" />
<input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
<input type="hidden" name="action" value="change_visible_name" />

</form>
<br/>

<a href="?s={$s}&ago=add_link&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Add"|i18n}</a><br/>
<table align="center" width="100%">
<tr>
    <td colspan="2">
	{"Operation"|i18n}
    </td>

    <td>
	{"Name"|i18n}
    </td>

    <td>
	{"Type"|i18n}
    </td>

    <td>
	{"Byed Value"|i18n}
    </td>

    <td>
	{"Value"|i18n}
    </td>

    <td>
	{"Is enabled"|i18n}
    </td>

    <td>
	{"Position"|i18n}
    </td>
</tr>
{foreach from=$partner_links->get_links(0) item=link}
<tr>
    <td><a href="?s={$s}&ago=edit_link&id={$link.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Edit"|i18n}</a></td>
    <td><a href="?s={$s}&action=delete_link&id={$link.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Delete"|i18n}</a></td>

    <td>{$link.name}</td>

    <td>{$link.type|i18n}</td>

{if $link.type eq 'free'}
    <td>{"None"|i18n}</td>
    <td>{$link.free_viewed}</td>
{elseif $link.type eq 'pay'}
    <td>{$link.pay_end|date_format:'%Y-%m-%d'}</td>
    <td>{"None"|i18n}</td>
{elseif $link.type eq 'pay_clicks'}
    <td>{$link.pay_clicks}</td>
    <td>{$link.pay_clicked}</td>
{elseif $link.type eq 'pay_view'}
    <td>{$link.pay_views}</td>
    <td>{$link.pay_viewed}</td>
{elseif $link.type eq 'pay_percent'}
    <td>{$link.pay_percent_clicks} ({$link.pay_percent*100} %)</td>
    <td>{$link.pay_percent_clicked}</td>
{/if}

    <td>{$link.is_enabled}</td>

    <td>
	{if $link.position > 1}
	    <a href="?s={$s}&action=up&id={$link.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Up"|i18n}</a>
	{/if}
	{if $link.position < $partner_links->get_next_position() - 1}
	    <a href="?s={$s}&action=down&id={$link.id}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}">{"Down"|i18n}</a>
	{/if}
    </td>

    <td>
	<textarea style="width:100%;">{literal}<script type='text/javascript' src='{/literal}{$http_module_path}dynamic_link.php?id={$link.id}'{literal}></script>{/literal}</textarea>
    </td>
</tr>
{foreachelse}
<tr>
    <td colspan="8">
    {"No links for now"|i18n}
    </td>
</tr>
{/foreach}

</table>