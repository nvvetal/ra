{assign var="link" value=$partner_links->get_link($smarty.request.id)}
{include file='i_error.tpl'}
<form method="post" action="index.php">
<input type="hidden" name="id" value="{$smarty.request.id}"  />
<input type="hidden" name="s" value="{$s}"  />
<input type="hidden" name="ago" value="p_links"  />
<input type="hidden" name="action" value="set_partner_link" />

<input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
<table align="center" width="300px">
    <tr>
	<td>
	    {"Name"|i18n}
	</td>
	<td>
	    {"Value"|i18n}
	</td>
    </tr>
    <tr>
	<td>
	    {"Link url"|i18n}
	</td>
	<td>
	    <input type="text" name="url" value="{$link.url|default:$smarty.request.url}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link name"|i18n}
	</td>
	<td>
	    <input type="text" name="name" value="{$link.name|default:$smarty.request.name}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link external name"|i18n}
	</td>
	<td>
	    <input type="text" name="external_name" value="{$link.external_name|default:$smarty.request.external_name}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link external codepage"|i18n}
	</td>
	<td>
	    <input type="text" name="external_codepage" value="{$link.external_codepage|default:$smarty.request.external_codepage}" style="width:100%;" />
	</td>
    </tr>


    <tr>
	<td>
	    {"Link description"|i18n}
	</td>
	<td>
	    <textarea name="description" style="width:100%;">{$link.description|default:$smarty.request.description}</textarea>
	</td>
    </tr>

    <tr>
	<td>
	    {"Link type"|i18n}
	</td>
	<td>
	    <select name="type">
		<option value="free" {if $link.type|default:$smarty.request.type eq 'free'}selected{/if}>{"Link type free"|i18n}</option>
		<option value="pay" {if $link.type|default:$smarty.request.type eq 'pay'}selected{/if}>{"Link type pay"|i18n}</option>
		<option value="pay_clicks" {if $link.type|default:$smarty.request.type eq 'pay_clicks'}selected{/if}>{"Link type pay clicks"|i18n}</option>
		<option value="pay_view" {if $link.type|default:$smarty.request.type eq 'pay_view'}selected{/if}>{"Link type pay view"|i18n}</option>
		<option value="pay_percent" {if $link.type|default:$smarty.request.type eq 'pay_percent'}selected{/if}>{"Link type pay percent"|i18n}</option>
	    </select>
	</td>
    </tr>

    <tr>
	<td>
	    {"Link free viewed"|i18n}
	</td>
	<td>
	    <input type="text" name="free_viewed" value="{$link.free_viewed|default:$smarty.request.free_viewed}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay end (type - pay)"|i18n}
	</td>
	<td>
	    {html_select_date prefix="pay_end" time=$link.pay_end|default:$smarty.request.pay_end start_year="+0" end_year="+1" }
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay clicks"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_clicks" value="{$link.pay_clicks|default:$smarty.request.pay_clicks}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay clicked"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_clicked" value="{$link.pay_clicked|default:$smarty.request.pay_clicked}" style="width:100%;" />
	</td>
    </tr>


    <tr>
	<td>
	    {"Link pay views"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_views" value="{$link.pay_views|default:$smarty.request.pay_views}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay viewed"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_viewed" value="{$link.pay_viewed|default:$smarty.request.pay_viewed}" style="width:100%;" />
	</td>
    </tr>


    <tr>
	<td>
	    {"Link pay percent (koeficient, like 0.7)"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_percent" value="{$link.pay_percent|default:$smarty.request.pay_percent}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay percent clicks"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_percent_clicks" value="{$link.pay_percent_clicks|default:$smarty.request.pay_percent_clicks}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay percent clicked"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_percent_clickeded" value="{$link.pay_percent_clicked|default:$smarty.request.pay_percent_clicked}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link is enabled"|i18n}
	</td>
	<td>
	    <input type="checkbox" name="is_enabled" value="1" {if $link.is_enabled|default:$smarty.request.is_enabled == 1}checked{/if} style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td colspan="2" align="center">
	    <input type="submit" name="btnSubmit" value="{"Set"|i18n}" />&nbsp;
	    <input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?s={$s}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}'" />
	    
	</td>
    </tr>

</table>

</form>