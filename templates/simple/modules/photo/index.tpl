{include file='header.tpl' script='modules/photo/i_javascript.tpl'}
<center><h2><img src="{$http_images_static_path}photo.jpg" alt=""/></h2></center>
<div>
{if $photoOfDay !== false}
{include file="modules/photo/i_top_image.tpl" title="Photo of day"|i18n photoObj=$photoOfDay albumObj=$photoOfDay->getAlbum()}
{/if}

{if $photoMaxRated !== false}
{include file="modules/photo/i_top_image.tpl" title="Photo Max Rated"|i18n photoObj=$photoMaxRated albumObj=$photoMaxRated->getAlbum()}
{/if}
{if $photoRandom !== false}
{include file="modules/photo/i_top_image.tpl" title="Photo Random"|i18n photoObj=$photoRandom albumObj=$photoRandom->getAlbum()}
{/if}
</div>
<br clear="all"/>
<br/>
<br/>
<center><h2><img src="{$http_images_static_path}rec_photo.jpg" alt=""/></h2></center>
{if $Session->get_value($s,'is_logged') == 1}
    <table width="100%" align="center">
        <tr align="center">
            <td><a href="{$http_project_path}photo/?go=my_albums&s={$s}">{"My photos"|i18n}</a></td>
            <td><a href="{$http_project_path}photo/?go=my_album_add&s={$s}">{"Add photo"|i18n}</a></td>
        </tr>
    </table>
{/if}

<br clear="all"/>
{foreach name="photoItems" from=$photosData.items item=photoItems}
    {foreach name="photo" from=$photoItems item=photo}
        {if $smarty.foreach.photo.first == true}
            <hr/>
            <div style="display: inline; float:left;width:70px;">
                {if $photo->owner_type == 'user'}
                    {assign var="ownerUserImageId" value=$User->get_value($photo->owner_id, 'image_id')}
                    {assign var="ownerUserNoImageId" value=$User->get_value($photo->owner_id, 'p_sex')}
                    {if $User->get_value($photo->owner_id,'image_id') > 0}
                        <img src="{$http_images_path}{$Images->get_image_url_center_square($ownerUserImageId, 70, 'jpg')}" alt="" width="70" height="70" />
                    {else}
                        <img src="{$http_images_static_path}u_{$ownerUserNoImageId}.png" width="70" height="70" alt="" / >
                    {/if}
                    <br/>
                    {assign var="pAlbum" value=$photo->getAlbum()}
                    <a href="{$http_project_path}?s={$s}&go=profile&user_id={$photo->owner_id}">{$pAlbum->getOwnerLogin()}</a>
                {elseif  $photo->owner_type == 'school'}
                    {assign var="school" value=$schoolObj->get_school($photo->owner_id)}
                    <img src="{$http_images_path}{$Images->get_image_url_center_square($school.image_id, 70,'jpg')}" alt="" width="70" height="70" />
                    <br/>
                    <a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$school.id}">{$school.name}</a>
                {else}
                {/if}

            </div>
            <div style="display: inline;margin-left:50px;float:left;max-width:530px;padding-right:5px;">
        {/if}
        <div style="display: inline; float: left;">
        <a href="{$http_project_path}photo/?s={$s}&go=user_album_photos&album_id={$photo->album_id}&photo_id={$photo->id}&user_id={$photo->owner_id}"><img src="{$photo->getUrlCenterSquare(170)}" alt="{$photo->name}" width="170" height="170" /></a>
        </div>
        {if $smarty.foreach.photo.last == true}</div><br clear="all"/>{/if}
    {/foreach}
    <br/>
{foreachelse}
    {"no photos available"|i18n}
{/foreach}
{if $photosData.pages > 1}
    <center>
        {section name=pager start=1 loop=$photosData.pages+1 step=1}
            {if $page != $smarty.section.pager.index}<a href="?s={$s}&page={$smarty.section.pager.index}">{$smarty.section.pager.index}</a>{else}{$smarty.section.pager.index}{/if}&nbsp;
        {/section}
    </center>
{/if}

{include file='footer.tpl'}