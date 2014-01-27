{"Reputation"|i18n} <a href="{$http_project_path}forum/viewreputation.php?id={$User->get_value($profile_user_id,'forum')}" target="_blank">{$User->get_value($profile_user_id,'user_reputation')}</a><br/>
{"Medals"|i18n}<br/> 
{foreach name="medals" from=$userMedals.items item=userMedal}
{assign var="medal" value=$userMedal->getObj('medal')}
<img src="{$medal->getMedalUrl()}" alt="{$medal->name}" style="vertical-align: middle; width: 35px; height: 35px;"/>
{if $smarty.foreach.medals.last == true}<br/><a href="{$http_project_path}forum/memberlist.php?mode=viewprofile&u={$User->get_value($profile_user_id,'forum')}" target="_blank">{"Full information about medals"|i18n}</a>{/if}
{foreachelse}
{"User dont have medals"|i18n}
{/foreach} 