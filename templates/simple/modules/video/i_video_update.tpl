<form id="video_{$video->id}" onsubmit="xajax_setVideo($('#video_{$video->id}').serialize());return false;">
<table>
	<tr valign="top">
		<td>{"Video link"|i18n}<span class="required">*</span></td>
		<td width="500">
			<textarea id="link" name="link" style="width:100%">https://youtube.com/watch?v={$video->youtube_id}</textarea>
		</td>
	</tr>
	<tr valign="top">		
		<td>{"Video name"|i18n}</td>
		<td>
			<input type="text" id="name" name="name" style="width:100%" value="{$video->name}" />		
		</td>
	</tr>
	<tr valign="top">
		<td>{"Video description"|i18n}</td>
		<td>
			<textarea name="description" id="description" style="width:100%;height: 200px;">{$video->description}</textarea>			
		</td>				
	</tr>
	<tr valign="top">
		<td>{"Video Tags"|i18n}</td>
		<td>
			<a href="javascript:void(0);" onclick="showNewTagVideoId({$video->id});">{"Add Tag"|i18n}</a>
			<div id="tagContainer_{$video->id}">
				{include file="modules/video/i_tags.tpl"}				
			</div>
		</td>
	</tr>
</table>
<input type="hidden" name="s" value="{$s}" />
<input type="hidden" name="video_id" value="{$video->id}" />
</form>
<div id="dialog-tag-{$video->id}" style="display: none;">
<input type="text" name="tag_{$video->id}" id="tag_{$video->id}"/>
</div>