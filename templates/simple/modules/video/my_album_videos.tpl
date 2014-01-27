{include file='header.tpl' script='modules/video/i_javascript.tpl'}

<div class="title">{"My Album Videos"|i18n} :: {$userAlbum->name}</div>
<a href="{$http_project_path}video/?go=my_album_video_add&s={$s}&album_id={$smarty.request.album_id}">{"Add video"|i18n}</a><br/>
<a href="{$http_project_path}video/?go=my_albums&s={$s}&action=my_album_remove&album_id={$userAlbum->id}">{"Remove Album"|i18n}</a><br/>
<a href="{$http_project_path}video/?go=my_albums&s={$s}">{"Back to Albums"|i18n}</a><br/>
{foreach name="video" from=$userVideos.items item=userVideo}
	{include file="modules/video/i_video.tpl" video=$userVideo disableVoting=true}
{foreachelse}
    {"No videos"|i18n}
{/foreach}
<br clear="all"/>
{include file="i_pager.tpl" request="go|s|album_id" max_page=$userVideos.pages useNormalPages=1}
{include file='footer.tpl'}