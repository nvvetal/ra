{literal}
<script type="text/javascript">
    function showSelectGiftUser(giftId)
    {
        $("#user-send-result").html('');
        $("#preview_gift_id").attr('src', $("#shop_gift_id_"+giftId).attr('src'));
        $("#gift_id").val(giftId);
        $( "#dialog-select-gift-user" ).dialog({
            height: 400,
            width: 500,
            title: {/literal}"{"Gift send"|i18n}"{literal},
            modal: true,
            buttons: {
                {/literal}"{"Send Gift"|i18n}"{literal}: function() {
                    xajax_sendUserGift($('#user-select').serialize());
                },
                {/literal}"{"Cancel"|i18n}"{literal}: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    }
</script>
{/literal}
