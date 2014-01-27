{include file='header.tpl' script='modules/video/i_javascript.tpl'}
{literal}
<script>
    $('input:text, input:password')
            .button()
            .css({
                'font' : 'inherit',
                'color' : 'inherit',
                'text-align' : 'left',
                'outline' : 'none',
                'cursor' : 'text'
            });

    $(document).ready(function() {
        var albums = {/literal}[{foreach from=$userAlbums.items item=album name="album"}{literal}{id: "{/literal}{$album->id}{literal}", text: "{/literal}{$album->name}{literal}"}{/literal}{if $smarty.foreach.album.last == false},{/if}{/foreach}{literal}];
        $("#album_name").select2({
            placeholder: "{/literal}{"Select an album or write new"|i18n}{literal}",
            allowClear: true,
            query: function (query) {
                var data = {results: []};
                if(query.term.length > 0){
                    data.results.push({id: query.term, text: query.term });
                }
                $.each(albums, function(){
                    if(query.term.length == 0 || this.text.toUpperCase().indexOf(query.term.toUpperCase()) >= 0 ){
                        data.results.push({id: this.id, text: this.text });
                    }
                });
                query.callback(data);
            }
        });
    });


</script>
{/literal}


<div class="title">{"My Album Videos Add"|i18n}{if $smarty.request.no_album != 1} :: {$userAlbum->name}{/if}</div>
{include file='i_error.tpl'}
<form id="video" onsubmit="return saveFormVideos();">
    {if $smarty.request.no_album == 1}
        <table style="width:100%;">
            <tr>
                <td width="150">
                    {"Album name"|i18n}
                </td>
                <td>
                    <input type="hidden" id="album_name" name="album_name" style="width:99%" />
                </td>
            </tr>
        </table>
        <hr/>
    {/if}
    <div id="videoItemsContainer">
        {include file="modules/video/i_video_line.tpl" lineId=1}
        {include file="modules/video/i_video_line.tpl" lineId=2}
        {include file="modules/video/i_video_line.tpl" lineId=3}
    </div>
    <center>
        <input type="button" onclick="xajax_addMoreVideo();" value="{"Add more videos"|i18n}" />
        <input type="submit" id="btnSubmit" name="btnSubmit" value="{"Add video"|i18n}" />
    </center>
    <input type="hidden" name="s" value="{$s}" />
    {if $smarty.request.no_album != 1}
        <input type="hidden" name="album_id" value="{$smarty.request.album_id}" />
    {/if}
</form>
<input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?go=my_album_videos&s={$s}&album_id={$smarty.request.album_id}'" />
<div id="videoUploaded"></div>
<div id="dialog-tag" style="display: none;">
    <input type="text" name="tag" id="tag"/>
</div>
{include file='footer.tpl'}