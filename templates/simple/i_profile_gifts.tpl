<div>
    <table>
        <tr align="center">
            <td width="100">{"Date"|i18n}</td>
            <td width="200">{"Gift sent"|i18n}</td>
            <td>{"Gift sent by"|i18n}</td>
        </tr>
        {foreach from=$userGifts.items item=item}
            {assign var="good" value=$item.good}
            {assign var="gift" value=$item.giftItem}
            {assign var="giftSawTime" value=$gift->saw_time}
            <tr valign="top" align="center">
                <td>
                    {$gift->action_time|date_format:'%d.%m.%Y'} {if $giftSawTime|isGiftNew == 'new'}<img src="{$http_images_static_path}new.gif" alt=""/>{/if}
                </td>
                <td>
                    <img src="{$http_images_path}{$good->getImageUrl(150,100,'gif')}" alt="" /><br/>
                    {if $canShowPrivateComment == 1}{$gift->message}{/if}
                </td>
                <td>
                    <a href="{$http_project_path}?go=profile&user_id={$gift->from_user_id}">{$User->get_value($gift->from_user_id,'login')}</a>
                    <br/>
                    <a href="{$http_project_path}shop/?s={$s}&go=shop_category&shop_id={$good->getShopId()}&category_id={$good->category_id}">{"Gift byed here"|i18n}<a/>
                </td>
            </tr>
            {foreachelse}
            <tr>
                <td colspan="3" align="center">
                    {if $canShowPrivateComment == 1}{"You have no gifts from users"|i18n shop}{else}{"User have no gifts yet."|i18n shop}{/if}
                </td>
            </tr>
            {if $userGifts.cnt > 0}
                <tr colspan="3" align="center">
                    <a href="{$http_project_path}shop/?go=gifts&s={$s}">{"More gifts"|i18n shop}</a>
                </tr>
            {/if}
        {/foreach}
    </table>


    <br clear="all"/>