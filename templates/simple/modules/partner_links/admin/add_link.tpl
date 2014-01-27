<form method="post" action="index.php">

<input type="hidden" name="s" value="{$s}"  />
<input type="hidden" name="ago" value="p_links"  />
<input type="hidden" name="action" value="add_partner_link" />
<input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
{include file='i_error.tpl'}
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
	    <input type="text" name="url" value="{$smarty.request.url}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link name"|i18n}
	</td>
	<td>
	    <input type="text" name="name" value="{$smarty.request.name}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link external name"|i18n}
	</td>
	<td>
	    <input type="text" name="external_name" value="{$smarty.request.external_name}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link external codepage"|i18n}
	</td>
	<td>
	    <input type="text" name="external_codepage" value="{$smarty.request.external_codepage|default:"UTF-8"}" style="width:100%;" />
	</td>
    </tr>


    <tr>
	<td>
	    {"Link description"|i18n}
	</td>
	<td>
	    <textarea name="description" style="width:100%;">{$smarty.request.description}</textarea>
	</td>
    </tr>

    <tr>
	<td>
	    {"Link type"|i18n}
	</td>
	<td>
	    <select name="type">
		<option value="free" {if $smarty.request.type eq 'free'}selected{/if}>{"Link type free"|i18n}</option>
		<option value="pay" {if $smarty.request.type eq 'pay'}selected{/if}>{"Link type pay"|i18n}</option>
		<option value="pay_clicks" {if $smarty.request.type eq 'pay_clicks'}selected{/if}>{"Link type pay clicks"|i18n}</option>
		<option value="pay_view" {if $smarty.request.type eq 'pay_view'}selected{/if}>{"Link type pay view"|i18n}</option>
		<option value="pay_percent" {if $smarty.request.type eq 'pay_percent'}selected{/if}>{"Link type pay percent"|i18n}</option>
	    </select>
	</td>
    </tr>

    <tr>
	<td>
	    {"Link free viewed"|i18n}
	</td>
	<td>
	    <input type="text" name="free_viewed" value="{$smarty.request.free_viewed}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay end (type - pay)"|i18n}
	</td>
	<td>
	    {html_select_date prefix="pay_end" time=$smarty.request.pay_end start_year="+0" end_year="+1" }
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay clicks"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_clicks" value="{$smarty.request.pay_clicks}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay clicked"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_clicked" value="{$smarty.request.pay_clicked}" style="width:100%;" />
	</td>
    </tr>


    <tr>
	<td>
	    {"Link pay views"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_views" value="{$smarty.request.pay_views}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay viewed"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_viewed" value="{$smarty.request.pay_viewed}" style="width:100%;" />
	</td>
    </tr>


    <tr>
	<td>
	    {"Link pay percent (koeficient, like 0.7)"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_percent" value="{$smarty.request.pay_percent}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay percent clicks"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_percent_clicks" value="{$smarty.request.pay_percent_clicks}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link pay percent clicked"|i18n}
	</td>
	<td>
	    <input type="text" name="pay_percent_clicked" value="{$smarty.request.pay_percent_clicked}" style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td>
	    {"Link is enabled"|i18n}
	</td>
	<td>
	    <input type="checkbox" name="is_enabled" value="1" {if $smarty.request.is_enabled == 1}checked{/if} style="width:100%;" />
	</td>
    </tr>

    <tr>
	<td colspan="2" align="center">
	    <input type="submit" name="btnSubmit" value="{"Add"|i18n}" />&nbsp;
	    <input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?s={$s}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}'" />
	    
	</td>
    </tr>

</table>

</form>