<a href="{$http_project_path}?s={$s}&go=payment_prepay">{"Buy Raks Money"|i18n}</a><br/><br/>
{assign var="raks_cost" value=$User->get_raks_money($user_id)}
{"Raks Money"|i18n} {$raks_cost} {$raks_cost|raks_name}<br/>
