<form id="videoAlbum_{$videoAlbum->id}" onsubmit="xajax_setVideoAlbumName($('#videoAlbum_{$videoAlbum->id}').serialize());return false;">
    <table>
        <tr valign="top">
            <td>{"Video name"|i18n}</td>
            <td>
                <input type="text" id="name" name="name" style="width:100%" value="{$videoAlbum->name}" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="s" value="{$s}" />
    <input type="hidden" name="video_album_id" value="{$videoAlbum->id}" />
</form>