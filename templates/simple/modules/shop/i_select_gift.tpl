<div id="dialog-select-gift-user">
    <img src="#" id="preview_gift_id" alt="" width="150" height="100" /><br/>
    <span id="user-send-result"></span>
    <form id="user-select" method="get">
        <table style="width:100%">
            <tr>
                <td width="200">
                    <b>{"Enter user nickname"|i18n}</b>
                </td>
                <td>
                    <input name="user" id="user_select" style="width:100%" value="{$toUsername}" />
                </td>
            </tr>
            <tr>
                <td width="200">
                    <b>{"Private message"|i18n}</b>
                </td>
                <td>
                    <textarea name="message" style="height:130px;width:100%;"></textarea>
                </td>
            </tr>
        </table>
        <b><span id="user-send-result-success"></span></b>
        <input type="hidden" id="gift_id" name="gift_id" value=""/>
        <input type="hidden" name="s" value="{$s}"/>
    </form>
</div>
