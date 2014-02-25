<table style="width:100%">
    <tr>
        <td align="right">
            <div style="vertical-align: middle" class="fb-like" data-href="{$url}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
        </td>
        <td align="left">
            <div id="vk_share_button" style="margin-top: 4px;"></div>
        </td>
    </tr>
</table>
{literal}
<script type="text/javascript">
    window.onload = function () {
        VK.init({apiId: {/literal}{$vkontakte_app_id}{literal}, onlyWidgets: true});
        $('#vk_share_button').html(VK.Share.button({
            url: '{/literal}{$url|urlencode}{literal}',
            title: '{/literal}{$title|escape:'javascript'}{literal}',
            description: '{/literal}{$description|strip_tags|truncate:255:"..."|escape:'javascript'}{literal}',
            image: '{/literal}{$image}{literal}',
            noparse: true
        },{
            type: "round",
            text: "Поделиться"
        }));
    }
</script>
{/literal}