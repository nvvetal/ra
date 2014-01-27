{include file='header.tpl' script='modules/video/i_javascript.tpl'}
<div class="title">{"Search Videos"|i18n}</div>
{include file="modules/video/i_search.tpl"}
<br clear="all"/>
{foreach name="video" from=$searchVideos.items item=searchVideo}
	{include file="modules/video/i_video.tpl" video=$searchVideo}
{foreachelse}
    {"No videos"|i18n}
{/foreach}
<br clear="all"/>
{include file="i_pager.tpl" request="go|s|album_id|search" max_page=$searchVideos.pages useNormalPages=1}
{include file='footer.tpl'}