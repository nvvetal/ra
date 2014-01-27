{include file='header.tpl'}
{assign var="SchoolData" value=$school->get_school($smarty.request.school_id)}
<center><h2><img src="{$http_images_static_path}shkoli_tancev.jpg" alt=""/></h2></center>
<div class="title">{"Make School Top"|i18n} {$SchoolData.name}</div>

{if $smarty.request.is_success != 1}
    {include file='i_error.tpl'}
    {"School TOP description text"|i18n}<br/><br/>
    {"School TOP position"|i18n} {$SchoolData.position}<br/><br/>
	{assign var="raks_cost" value=$school->get_cost('makeSchoolVIP')}
    {"School TOP costs"|i18n} {$raks_cost} {$raks_cost|raks_name}<br/><br/>
    {include file='i_raks_money.tpl'}<br/>
    <button onclick="window.location.href='{$http_project_path}schools/?s={$s}&go=schoolTop&school_id={$smarty.request.school_id}&action=makeSchoolTop'">{"Make TOP"|i18n}</button><br/><br/><br/>
{else}
    {"School TOP success text"|i18n}<br/><br/>
{/if}
<a href="{$http_project_path}schools/?s={$s}&go=my_schools">{"back to schools"|i18n}</a>
{include file='footer.tpl'}