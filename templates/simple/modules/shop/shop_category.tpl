{include file='header.tpl' script='modules/shop/i_javascript.tpl'}
{literal}
    <script>
        $(function() {
            function log( message ) {
                $( "<div/>" ).text( message ).prependTo( "#log" );
                $( "#log" ).scrollTop( 0 );
            }
            $( "#user" ).autocomplete({
                source: "search.php",
                minLength: 2,
                select: function( event, ui ) {
                    log( ui.item ?
                            "Selected: " + ui.item.value + " aka " + ui.item.id :
                            "Nothing selected, input was " + this.value );
                }
            });
        });
    </script>
{/literal}

<table>
    <tr valign="top">
        <td>
            {include file='modules/shop/i_shop_categories.tpl' shopCategories=$shop->getCategories() shop=$shop shopCategorySelected=$smarty.request.category_id}
        </td>
        <td>
            {include file='modules/shop/i_shop_description.tpl' shop=$shop from=category}
            {include file='modules/shop/i_shop_category_goods.tpl' category=$shopCategory page=$smarty.request.page|default:1 perPage=9}
        </td>
    </tr>
</table>
<div id="dialog-select-gift-user">
    <img src="#" id="preview_gift_id" alt="" width="150" height="100" /><br/>
    <span id="user-send-result"></span>
    <form id="user-select" method="get">
        <table>
            <tr>
                <td width="200">
                    <b>{"Enter user nickname"|i18n}</b>
                </td>
                <td>
                    <input type="text" name="user" id="user" value="" width="100%" />
                </td>
            </tr>
            <tr>
                <td>
                    <b>{"Private message"|i18n}</b>
                </td>
                <td>
                    <textarea name="message" width="100%" height="100%" style="height:100%"></textarea>
                </td>
            </tr>
        </table>
        <b><span id="user-send-result-success"></span></b>
        <input type="hidden" id="gift_id" name="gift_id" value=""/>
        <input type="hidden" name="s" value="{$s}"/>
    </form>
</div>
{include file='footer.tpl'}