{assign var="a_request" value=$Utils->explode('|',$request)}
{if $max_page > 1}
<div class="pager">
{section name="pager" start=0 loop=$max_page step=1}
{assign var="pageNum" value=$smarty.section.pager.index}
{if $useNormalPages == 1}
{assign var="pageNum" value=$smarty.section.pager.index+1}
{/if}
{if $pageNum == $smarty.request.page}
<span class="pager_selected">{$smarty.section.pager.index+1}</span>
{else}
<a href="?{foreach from=$smarty.request item=data key=key}{if $a_request.$key ne ''}{$key}={$data}&amp;{/if}{/foreach}page={$pageNum}">{$smarty.section.pager.index+1}</a>&nbsp;
{/if}
{/section}
</div>
{/if}