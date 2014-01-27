{assign var="tags" value=$video->getTags()}
{foreach from=$tags.items item=tag}
<div id="tag_{$tag->id}" style="display:inline;float:left;padding: 0px 10px 0px 0px"><span style="font-color:blue;">{$tag->tag}</span> <input type="hidden" name="tags[]" value="{$tag->name}" /><a href="javascript:void(0);" onclick="$('#tag_{$tag->id}').remove()">X</a></div>
{/foreach}
