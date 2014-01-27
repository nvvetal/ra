<form method="get" action="index.php">
{html_select_date prefix=date time=$request_time start_year=2010 end_year="+0" }
<input type="submit" name="{"Submit"|i18n}" value="{"Submit"|i18n}" />
<input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
<input type="hidden" name="s" value="{$smarty.request.s}" />
<input type="hidden" name="ago" value="log" />
</form>
<table width="100%" border="1">
<tr>
    <td>{"Action Time"|i18n}</td>
    <td>{"Module"|i18n}</td>
    <td>{"Action"|i18n}</td>
    <td>{"User"|i18n}</td>
    <td>{"Sent"|i18n}</td>
    <td>{"Got"|i18n}</td>
</tr>
{foreach from=$logs item=log}
<tr>
    <td>{$log.time_created|date_format:"%d.%m.%Y %H:%M"}</td>
    <td>{$log.module}</td>
    <td>{$log.action|i18n:'admin'}</td>
    <td>{$User->get_value($log.user_id,'login')}</td>
    <td><div style="overflow:auto;max-width:200px;"><pre >{$log.send_data|unserialize_to_array}</pre></div></td>
    <td><div style="overflow:auto;max-width:200px;"><pre>{$log.return_data|unserialize_to_array}</pre></div></td>    
</tr>
{foreachelse}
<tr>
    <td align="center" colspan="6">{"No actions"|i18n}</td>
</tr>
{/foreach}
</table>