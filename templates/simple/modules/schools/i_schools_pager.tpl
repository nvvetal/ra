{if $type ne 'search'}
{assign var="school_pages" value=$school->get_schools_count($per_page,$city_id)}
{else}
{assign var="school_pages" value=$school->get_schools_search_cnt($searchFilter)}
{/if}
{if $school_pages > 1}
<center>
{section name=pager start=1 loop=$school_pages+1 step=1}
{if $page != $smarty.section.pager.index}<a href="{$http_project_path}schools/?s={$s}&go=schools&page={$smarty.section.pager.index}">{$smarty.section.pager.index}</a>{else}{$smarty.section.pager.index}{/if}&nbsp;
{/section}
</center>
{/if}