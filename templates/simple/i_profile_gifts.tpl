<div>
    <table style="width: 100%;">
        {foreach name="gifts" from=$userGifts.items item=item}
            {if $smarty.foreach.gifts.first == true}
                <tr align="center">
                    <td width="100">{"Date"|i18n:'shop'}</td>
                    <td width="200">{"Gift good"|i18n:'shop'}</td>
                    <td>{"Gift sent by"|i18n:'shop'}</td>
                    {if $canShowGiftPrivateComment == 1}<td>{"Gift text"|i18n:'shop'}</td>{/if}
                </tr>
            {/if}
            {assign var="good" value=$item.good}
            {assign var="gift" value=$item.giftItem}
            {assign var="giftSawTime" value=$gift->saw_time}
            <tr valign="top" align="center">
                <td>
                    {$gift->action_time|date_format:'%d.%m.%Y'} {if $giftSawTime|isGiftNew == 'new'}<img src="{$http_images_static_path}new.gif" alt=""/>{/if}
                </td>
                <td>
                    <img src="{$http_images_path}{$good->getImageUrl(150,100,'gif')}" alt="" />
                </td>
                <td>
                    <a href="{$http_project_path}?go=profile&user_id={$gift->from_user_id}">{$User->get_value($gift->from_user_id,'login')}</a>
                </td>
                {if $canShowGiftPrivateComment == 1}<td>{$gift->message}</td>{/if}
            </tr>
            {foreachelse}
            <tr>
                <td align="center">
                    {if $canShowGiftPrivateComment == 1}{"You have no gifts from users"|i18n shop}{else}{"User have no gifts yet."|i18n shop}{/if}
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