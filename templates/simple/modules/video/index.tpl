{include file='header.tpl' script='modules/video/i_javascript.tpl'}
<center><h2><img src="{$http_images_static_path}video.jpg" alt=""/></h2></center>
<div>
    {if $videoOfDay !== false}
        {include file="modules/video/i_top_video.tpl" title="Video of day"|i18n videoObj=$videoOfDay albumObj=$videoOfDay->getAlbum()}
    {/if}
    {if $videoMaxRated !== false}
        {include file="modules/video/i_top_video.tpl" title="Video Max Rated"|i18n videoObj=$videoMaxRated albumObj=$videoMaxRated->getAlbum()}
    {/if}
    <!--
{if $videoRandom !== false}
{include file="modules/video/i_top_video.tpl" title="Video Random"|i18n videoObj=$videoRandom albumObj=$videoRandom->getAlbum()}
{/if}
-->
</div>
<br clear="all"/>
<br/>
<br/>
<center><h2><img src="{$http_images_static_path}rec_video.jpg" alt=""/></h2></center>
{include file="modules/video/i_search.tpl"}
{if $Session->get_value($s,'is_logged') == 1}
    <table width="100%" align="center">
        <tr align="center">
            <td>
                <a href="{$http_project_path}video/?go=my_album_video_add&s={$s}&no_album=1" style="margin-right: 20px">{"Add new video"|i18n}</a>
                <a href="{$http_project_path}video/?go=my_albums&s={$s}">{"My videos"|i18n}</a>
            </td>
        </tr>
    </table>
{/if}
<br/>
<br clear="all"/>

{foreach name="videoItems" from=$videosData.items item=videoItems}
    {foreach name="video" from=$videoItems item=video}
        {if $smarty.foreach.video.first == true}
            <hr/>
            <div style="display: inline; float:left;width:70px;">
                {if $video->owner_type == 'user'}
                    {assign var="ownerUserImageId" value=$User->get_value($video->owner_id, 'image_id')}
                    {assign var="ownerUserNoImageId" value=$User->get_value($video->owner_id, 'p_sex')}
                    {if $User->get_value($video->owner_id,'image_id') > 0}
                        <img src="{$http_images_path}{$Images->get_image_url_center_square($ownerUserImageId, 70, 'jpg')}" alt="" width="70" height="70" />
                    {else}
                        <img src="{$http_images_static_path}u_{$ownerUserNoImageId}.png" width="70" height="70" alt="" / >
                    {/if}
                    <br/>
                    {assign var="pAlbum" value=$video->getAlbum()}
                    <a href="{$http_project_path}?s={$s}&go=profile&user_id={$video->owner_id}">{$pAlbum->getOwnerLogin()}</a>
                {elseif  $video->owner_type == 'school'}
                    {assign var="school" value=$schoolObj->get_school($video->owner_id)}
                    <img src="{$http_images_path}{$Images->get_image_url_center_square($school.image_id, 70,'jpg')}" alt="" width="70" height="70" />
                    <br/>
                    <a href="{$http_project_path}schools/?s={$s}&go=school&school_id={$school.id}">{$school.name}</a>
                {else}
                {/if}

            </div>
            <div style="display: inline;margin-left:50px;float:left;max-width:550px;">
        {/if}
        {if $smarty.foreach.video.index < $maxPerLine}
        <div style="display: inline; float: left;padding-right:5px;margin-bottom:15px;height:265px;overflow:hidden;">
            {include file="modules/video/i_video.tpl" video=$video videoWidth=270 videoHeight=200
            disableVoting=true disableDescription=true disableAlbum=true
            disableComments=true disableTags=true disableContentEdit=true
            from=Main
            }
        </div>
        {else}
            <div><a href="{$http_project_path}video/?s={$s}&go=user_album_videos&album_id={$video->album_id}&user_id={$video->owner_id}">{"See more..."|i18n:'video'}</a></div>
        {/if}
        {if $smarty.foreach.video.last == true}</div><br clear="all"/>{/if}

    {/foreach}
    <br/>
    {foreachelse}
    {"no videos available"|i18n}
{/foreach}

<br clear="all"/>
<div id="log"></div>
{if $videosData.pages > 1}
    <div style="text-align: center">
        {section name=pager start=1 loop=$videosData.pages+1 step=1}
            {if $page != $smarty.section.pager.index}
                <a href="?s={$s}&page={$smarty.section.pager.index}">{$smarty.section.pager.index}</a>
            {else}
                {$smarty.section.pager.index}
            {/if}&nbsp;
        {/section}
    </div>
{/if}
{include file='footer.tpl'}