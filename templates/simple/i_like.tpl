{assign var="init" value=$init|default:true}
<table style="width:100%">
    <tr>
        <td align="right">
            <div class="fb-like" data-href="{$url}" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
        </td>
        <td align="left">
            <div id="vk_share_button" class="vk_share"
                 data-url="{$url|urlencode}" data-title="{$title|escape:'javascript'}"
                 data-description="{$description|strip_tags|truncate:255:"..."|escape:'javascript'}"
                 data-image="{$image}" data-noparse="true" data-text="Поделиться" data-type="round"
                 >
            </div>
        </td>
    </tr>
</table>