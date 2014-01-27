<div id="line_{$lineId}">
<table style="width:100%;">
	<tr>
		<td width="150">
			{"Video link"|i18n}<span class="required">*</span>
		</td>
		<td>
			<input type="text" id="link_{$lineId}" name="link[{$lineId}]" style="width:100%" value="" />
		</td>
	</tr>
	<tr>
		<td>			
			{"Video name"|i18n}
		</td>
		<td>
			<input type="text" id="name_{$lineId}" name="name[{$lineId}]" style="width:100%" value="" />
		</td>
	</tr>
	<tr>
		<td>
			{"Video description"|i18n}
		</td>
		<td>
			<textarea name="description[{$lineId}]" id="description_{$lineId}" style="width:100%;height:50px;"></textarea>
		</td>
	</tr>
	<tr>
		<td>			
			{"Video Tags"|i18n}
		</td>
		<td>
			<a href="javascript:void(0);" onclick="showNewTag('{$lineId}');">{"Add Tag"|i18n}</a>
			<div id="tagContainer_{$lineId}"></div>
		</td>
	</tr>
	<tr align="center">
		<td colspan="2"><input type="button" onclick="$('#line_{$lineId}').html('');" value="{"Remove video line"|i18n}" /><td>
	</tr>
</table>
<hr/>
</div>