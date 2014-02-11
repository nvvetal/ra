{foreach name="premium" from=$school->get_premium_schools() item="premium_school"}
<div>
<div class="premium_schoolname" onclick="window.location.href='{$http_project_path}schools/?s={$s}&go=school&school_id={$premium_school.school_id}'">{$premium_school.name}</div>
<div class="premium_school-description" onclick="window.location.href='{$http_project_path}schools/?s={$s}&go=school&school_id={$premium_school.school_id}'">{$premium_school.description|strip_tags|bbcode|maxstring:100}</div>
</div>
{/foreach}
<br/>
<br/>