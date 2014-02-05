<h2 class="main"><a href="{$http_project_path}photo/index.php?s={$s}"><img src="{$http_images_static_path}rec_photo.jpg" alt=""/></a></h2>
<div style="text-align: center;">
    {foreach from=$lastPhotos.items item=photo}
        <a href="{$http_project_path}photo/?s={$s}&go=user_album_photos&album_id={$photo->album_id}&photo_id={$photo->id}&user_id={$photo->owner_id}" imageId="{$photo->id}"><img src="{$photo->getUrlCenterSquare(170)}" alt="{$photo->name}"/></a>

    {/foreach}
</div>
<br/>