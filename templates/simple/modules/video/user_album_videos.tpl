{include file='header.tpl' script='modules/video/i_javascript.tpl'}

<div class="title">{"User Album Videos"|i18n} <span style="font-size: 110%"><a href="{$http_project_path}?s={$s}&go=profile&user_id={$userAlbum->owner_id}">{$userAlbum->getOwnerLogin()}</a> {$userAlbum->name}</span></div>
<a href="{$http_project_path}video/?go=user_albums&s={$s}">{"Back to Albums"|i18n}</a><br/>
{foreach name="video" from=$userVideos.items item=userVideo}
	{include file="modules/video/i_video.tpl" video=$userVideo}
{foreachelse}
    {"No videos"|i18n}
{/foreach}
<br clear="all"/>
{include file="i_pager.tpl" request="go|s|album_id" max_page=$userVideos.pages useNormalPages=1}
{include file='footer.tpl'}