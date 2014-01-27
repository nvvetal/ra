<form id="photoAlbum_{$photoAlbum->id}" onsubmit="xajax_setPhotoAlbumName($('#photoAlbum_{$photoAlbum->id}').serialize());return false;">
    <table>
        <tr valign="top">
            <td>{"Photo name"|i18n}</td>
            <td>
                <input type="text" id="name" name="name" style="width:100%" value="{$photoAlbum->name}" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="s" value="{$s}" />
    <input type="hidden" name="photo_album_id" value="{$photoAlbum->id}" />
</form>