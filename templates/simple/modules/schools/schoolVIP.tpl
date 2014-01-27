{include file='header.tpl'}
{assign var="SchoolData" value=$school->get_school($smarty.request.school_id)}
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
<div class="title">{"Make School VIP"|i18n} {$SchoolData.name}</div>
{if $smarty.request.is_success != 1}
    {include file='i_error.tpl'}
    {"School VIP description text"|i18n}<br/><br/>
    {if $school->is_school_vip_active($smarty.request.school_id) == true}
        {assign var="VIPData" value=$school->get_vip_school_data($smarty.request.school_id)}
        {"School VIP valid till"|i18n} {$VIPData.end_time|date_format:'%d.%m.%Y %H:%M'}<br/>
    {/if}
	{assign var="raks_cost" value=$school->get_cost('makeSchoolVIP')}
    {"School VIP costs"|i18n} {$raks_cost} {$raks_cost|raks_name}<br/><br/>
    {include file='i_raks_money.tpl'}<br/>
    <button onclick="window.location.href='{$http_project_path}schools/?s={$s}&go=schoolVIP&school_id={$smarty.request.school_id}&action=makeSchoolVIP'">{"Make VIP"|i18n}</button><br/><br/><br/>
{else}
    {assign var="VIPData" value=$school->get_vip_school_data($smarty.request.school_id)}
    {"School VIP success text"|i18n}<br/>
    {"School VIP valid till"|i18n} {$VIPData.end_time|date_format:'%d.%m.%Y %H:%M'}<br/><br/>
{/if}
<a href="{$http_project_path}schools/?s={$s}&go=my_schools">{"back to schools"|i18n}</a>
{include file='footer.tpl'}