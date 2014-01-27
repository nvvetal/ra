{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
<div class="title">{"School Albums"|i18n} :: {$schoolCurrent.name}</div>
{include file='i_error.tpl'}
{if $isOwner == 1}
<a href="{$http_project_path}photo/?go=school_album_add&s={$s}&school_id={$smarty.request.school_id}">{"Add album"|i18n}</a><br/>
{/if}
<a href="{$http_project_path}schools/?go=school&s={$s}&school_id={$smarty.request.school_id}">{"Back to School"|i18n}</a>
<div>
{foreach from=$schoolAlbums.items item=albumData}
    {assign var="firstPhotoUrl" value=$albumData->getFirstPhotoUrl(100)}
    {if $firstPhotoUrl == false}
    {assign var="firstPhotoUrl" value=$http_images_static_path|cat:'no_album.jpg'}
    {/if}
    <div class="photo_container">
    <a href="{$http_project_path}photo/?go=school_album_photos&s={$s}&album_id={$albumData->id}&school_id={$smarty.request.school_id}"><img src="{$firstPhotoUrl}" alt="" width="100" height="100" /></a><br/>
    <center><a href="{$http_project_path}photo/?go=school_album_photos&s={$s}&album_id={$albumData->id}&school_id={$smarty.request.school_id}">{$albumData->name}</a></center>
    </div>
{foreachelse}
    {"No school albums"|i18n}
{/foreach}
</div>
{include file='footer.tpl'}