<ul>
{foreach from=$commands item=command}
	<li><a {if $command.is_url == 1} href="index.php?a_id={$a_id}&a_sid={$command.id}{foreach from=$command.url item=url key=key}&{$key}={$url}{/foreach}&s={$s}"{else}href="#"{/if}>{$command.name}</a>
		{if isset($command.childs)}
			{include file="modules/admin/menu_items.tpl" commands=$command.childs a_id=$a_id}
		{/if}
	</li>
{/foreach}
</ul>