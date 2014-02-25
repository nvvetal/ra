{assign var="unknown_photo" value="unknown_photo"|i18n}
{if $showWithoutAlbum == true}
<div class="album">
    <div class="album-title">{"Photo name"|i18n}</div>
    <div class="album-album">
        {$photoObj->name|default:$unknown_photo}{if $isOwner} <a href="javascript:void(0);" onclick="xajax_showEditPhoto('{$photoObj->id}','{$s}')"><img src="{$http_images_static_path}icons/edit_24x24.png" style="vertical-align: middle;" alt="{"Edit photo"|i18n}" /></a>{/if}
    </div>
</div>
{else}
<div class="album">
    <div class="album-title">{"Album"|i18n}</div>
    <div class="album-album">
        <a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumObj->id}&user_id={$albumObj->owner_id}" target="_blank">{$albumObj->name}</a></div><div class="album-photo-divider">::</div><div class="album-photo-name">{$photoObj->name|default:$unknown_photo}{if $isOwner} <a href="javascript:void(0);" onclick="xajax_showEditPhoto('{$photoObj->id}','{$s}')"><img src="{$http_images_static_path}icons/edit_24x24.png" style="vertical-align: middle;" alt="{"Edit photo"|i18n}" /></a>{/if}</div>
</div>
{/if}
<br/>
<div class="album">
    <div class="album-title">{"Photo description"|i18n}</div>
    <div class="album-album">
        {$photoObj->description}
    </div>
</div>
<br/>
<div class="album">
    <div class="album-title">{"Album owner"|i18n}</div>
    <div class="album-owner-link"><a href="{$http_project_path}?s={$s}&go=profile&user_id={$albumObj->owner_id}">{$albumObj->getOwnerLogin()}</a></div>
</div>
<div class="album">
    {include file='i_like.tpl'
        url=$http_project_path|cat:'photo/?go=user_album_photos&amp;album_id='|cat:$albumObj->id|cat:'&amp;photo_id='|cat:$photoObj->id|cat:'&amp;user_id='|cat:$albumObj->owner_id
        title=$photoObj->name|default:$unknown_photo description=$photoObj->description
        image=$photoObj->getUrlCenterSquare(500)
    }
</div>