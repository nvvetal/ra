<div>
{if $Session->get_value($s,'is_logged') == 1}
<!--a href="{$http_project_path}schools/?go=add_school&s={$s}">{"Create school"|i18n}</a><br/-->
{/if}
{foreach name="schoolData" from=$userSchools item=schoolData}
{if $smarty.foreach.schoolData.first == true}
{/if}
<a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$schoolData.id}" target="_blank">{$schoolData.name}</a>&nbsp;&nbsp;
{foreachelse}
{"User have no schools"|i18n}
{/foreach}
</div>