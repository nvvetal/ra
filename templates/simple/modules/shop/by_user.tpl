{literal}
document.write(''+
{/literal}
'<hr/>'+
'<div>'+
    '<span style="color:red">{"user gifts count"|i18n} {$goods.cnt}</span>&nbsp;&nbsp;<a href="{$http_project_path}?go=my_profile">{"gift all list"|i18n}</a>&nbsp;&nbsp;<a href="{$http_project_path}shop/?user_id={$userId}">{"send gift to somebody"|i18n}</a></div>'+
    '<div>'+
        {foreach from=$goods.items item=item}
            '<div style="float:left;display:inline;text-align:center;margin-right:5px;">'+
                {assign var="itemGood" value=$item.good}{assign var="itemGift" value=$item.giftItem}
                '<div><img src="{$http_images_path}{$itemGood->getImageUrl(150, 100, 'jpg')}" alt="" width="150" height="100" /></div>'+
                '<div style="width:150px;">{"Gift by"|i18n} '+
                    '<a href="{$http_project_path}?go=profile&user_id={$itemGift->from_user_id}">{$User->get_value($itemGift->from_user_id,'login')}</a>'+
                '</div>'+
            '</div>'+
        {/foreach}
    '</div>'+
'<br clear="all"/>'+
{literal}'');
{/literal}