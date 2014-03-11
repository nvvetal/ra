{literal}
    document.write(''+
{/literal}
'<div class="balloon" title="{$status|strip_tags|escape:'htmlall'}">' +
    '<span class="arrow">&nbsp;</span>' +
    '<div class="text">{$status|strip_tags|escape:'htmlall'}</div>' +
'</div>' +
{literal}'');
{/literal}