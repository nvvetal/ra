{assign var="unknown_photo" value="unknown_photo"|i18n}
<div style="float:left; padding-right:30px;">
<div style="text-align:center"><b>{$title}</b></div>
<div style="text-align:center"><a href="{$http_project_path}photo/?s={$s}&go=user_album_photos&album_id={$photoObj->album_id}&photo_id={$photoObj->id}&user_id={$photoObj->owner_id}" imageId="{$photoObj->id}"><img src="{$photoObj->getUrlCenterSquare(200)}" width="200" height="200" alt="{$photoObj->name}"/></a></div>
<div style="text-align:center"><a href="{$http_project_path}photo/?go=user_album_photos&s={$s}&album_id={$albumObj->id}&user_id={$albumObj->owner_id}">{$albumObj->name}</a> :: {$photoObj->name|default:$unknown_photo}</div>
</div>