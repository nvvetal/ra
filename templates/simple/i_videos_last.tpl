<h2 class="main"><img src="{$http_images_static_path}rec_video.jpg" alt=""/></h2>
<div>
    {foreach from=$lastVideos.items item=video}
        <div class="videoTopContainer">
            {include file="modules/video/i_video.tpl" video=$video videoWidth=330 videoHeight=250 from="Index"
            disableContentEdit=true disableVoting=true disableDescription=true disableAlbum=true
            disableComments=true disableTags=true
            }
        </div>
    {/foreach}
</div>
<br clear="all"/>
<br/>
<br/>