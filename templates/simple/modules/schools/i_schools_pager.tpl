{if $school_pages > 1}
<div style="text-align: center">
{section name=pager start=1 loop=$school_pages+1 step=1}
{if $page != $smarty.section.pager.index}<a href="{$http_project_path}schools/?s={$s}&go=schools&page={$smarty.section.pager.index}">{$smarty.section.pager.index}</a>{else}{$smarty.section.pager.index}{/if}&nbsp;
{/section}
</div>
{/if}