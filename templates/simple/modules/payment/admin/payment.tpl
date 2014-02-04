<form method="get" action="index.php">
{html_select_date prefix=date time=$request_time start_year=2010 end_year="+0" display_days=false }
<input type="submit" name="{"Submit"|i18n}" value="{"Submit"|i18n}" />
<input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
<input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />
<input type="hidden" name="s" value="{$smarty.request.s}" />
<input type="hidden" name="ago" value="payment" />
</form>
<table width="100%" border="1" class="stats_table">
<tr class="stats_table_header">
    <td>{"Date"|i18n}</td>
    <td>{"Prepay"|i18n}</td>
    <td>{"School Premium"|i18n}</td>
    <td>{"School Up"|i18n}</td>
    <td>{"Calendar Premium"|i18n}</td>
    <td>{"Articles Enabled"|i18n}</td>
    <td>{"Forum Message"|i18n}</td>
    <td>{"Forum Enter"|i18n}</td>
    <td>{"Forum Enter Daily"|i18n}</td>
    <td>{"Forum Medal"|i18n}</td>
    <td>{"Forum Rank"|i18n}</td>
    <td>{"Forum Concurs"|i18n}</td>
    <td>{"Rakses IN"|i18n}</td>
    <td>{"Rakses OUT"|i18n}</td>
</tr>
{foreach from=$dates item=date}
{assign var="stats" value=$Payment->getDailyAgrStats($date.y,$date.m,$date.d)}
<tr>
    <td>{$date.ymd_representation|date_format:"%d.%m.%Y"}</td>
    <td>{$stats.prepay|default:0}</td>
    <td>{$stats.school_premium|default:0}</td>
    <td>{$stats.school_up|default:0}</td>
    <td>{$stats.calendar_premium|default:0}</td>
    <td>{$stats.article_enabled|default:0}</td>
    <td>{$stats.forumMessage|default:0}</td>
    <td>{$stats.forumEnter|default:0}</td>
    <td>{$stats.forumEnterDaily|default:0}</td>
    <td>{$stats.forumMedal|default:0}</td>
    <td>{$stats.forumRank|default:0}</td>
    <td>{$stats.forumConcurs|default:0}</td>
    <td>{$stats.raks_in|default:0}</td>
    <td>{$stats.raks_out|default:0}</td>
</tr>
{/foreach}
</table>