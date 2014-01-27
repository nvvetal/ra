<center>
<form method="get" action="index.php">
<input type="submit" name="{"Submit"|i18n}" value="{"Submit"|i18n}" />
<input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
<input type="hidden" name="s" value="{$smarty.request.s}" />
<input type="hidden" name="ago" value="main_config" />
<input type="hidden" name="action" value="set_config" />

<table width="100%" border="1">
<tr>
    <td>{"Param"|i18n}</td>
    <td>{"Value"|i18n}</td>
</tr>
{foreach from=$Config->get_params() item=cparam}
<tr>
    <td>
        {$cparam.name}
    </td>
    <td>
        {if $cparam.type eq 'bool'}
            <select name="config[{$cparam.name}]"  style="width:100%;">
            <option value="1" {if $cparam.value == 1}selected{/if}>{"Yes"|i18n}</option>
            <option value="0" {if $cparam.value == 0}selected{/if}>{"No"|i18n}</option>
            </select>
        {else}
            <input type="text" name="config[{$cparam.name}]" value="{$cparam.value}" style="width:100%;" />
        {/if}
    </td>
</tr>
{foreachelse}
<tr>
    <td align="center" colspan="2">{"No actions"|i18n}</td>
</tr>
{/foreach}
</table>
<input type="submit" name="{"Submit"|i18n}" value="{"Submit"|i18n}" />
</form>
</center>