<form id="photo_edit_{$photoObj->id}">
        <div style="display: inline; min-width: 100px">
            {"Name"|i18n}
        </div>
        <div style="display: inline;">
            <input type="text" name="name" value="{$photoObj->name}" style="width: 250px;" />
        </div>
    <br/>
        <div style="display: inline; min-width: 100px">
            {"Album"|i18n}
        </div>
        <div style="display: inline;">
            <select name="album_id" style="width: 250px">
                {foreach from=$albums.items item=album}
                    <option value="{$album->id}" {if $album_id == $album->id}selected{/if}>{$album->name}</option>
                {/foreach}
            </select>
        </div>
    <br/>
        <div style="display: inline; min-width: 100px;vertical-align:top;">
            {"Description"|i18n}
        </div>
        <div style="display: inline;">
            <textarea name="description" style="height: 100px; width: 250px;">{$photoObj->description}</textarea>
        </div>
    <input type="hidden" name="s" value="{$s}" />
    <input type="hidden" name=photo_id value="{$photoId}" />
</form>