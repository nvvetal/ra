{foreach from=$calendar_forum->getForums($pid) item=forumData}
{section name=bar loop=$iteration max=$iteration step=1}-{/section} <input type="radio" name="forum_id" value="{$forumData.forum_id}" {if $forumIdS == $forumData.forum_id}checked{/if} />
{if $pid == 0}<b>{/if}{$forumData.forum_name}{if $pid == 0}</b>{/if}<br/>
{include file='modules/calendar/admin/i_calendar_forums.tpl' pid=$forumData.forum_id iteration=$iteration+1 forumIdS=$forumIdS}
{/foreach}