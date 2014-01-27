{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            getEditor("description");
        });
    </script>
{/literal}
{assign var="current_school" value=$school->get_school($smarty.request.school_id)}
{include file='i_error.tpl'}
<form method="POST" enctype="multipart/form-data">
    <table style="width:100%;">
        <tr>
            <td width="170">{"Name"|i18n}</td>
            <td><input style="width:100%" type="text" name="name" value="{$smarty.request.name|default:$current_school.name}" /></td>
        </tr>
        <tr>
            <td>{"City"|i18n}</td>
            <td>
                <select name="city_id" style="width:100%">
                    <optgroup label="{"Other countries"|i18n}" >
                        <option value="-1">{"Unknown city"|i18n}</option>
                    </optgroup>
                    {foreach from=$Geo->get_countries() item=country}
                        <optgroup label="{$country.name}" >
                            {foreach from=$Geo->get_subdivisions($country.id) item=subdivision}
                                <optgroup label="{$subdivision.name}" >
                                    {foreach from=$Geo->get_cities_by_subdivision($subdivision.id) item=city}
                                        <option value="{$city.id}" {if $smarty.request.city_id|default:$current_school.city_id == $city.id}selected{/if}>{$city.name}</option>
                                    {/foreach}
                                </optgroup>
                            {/foreach}
                        </optgroup>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td>{"URL"|i18n}</td>
            <td><input type="text" style="width:100%" name="url" value="{$smarty.request.url|default:$current_school.url}" /></td>
        </tr>
        <tr>
            <td>{"Email"|i18n}</td>
            <td><input type="text" style="width:100%" name="email" value="{$smarty.request.email|default:$current_school.email}" /></td>
        </tr>
        <tr>
            <td>{"ICQ"|i18n}</td>
            <td><input type="text" style="width:100%" name="icq" value="{$smarty.request.icq|default:$current_school.icq}" /></td>
        </tr>
        <tr>
            <td>{"Skype"|i18n}</td>
            <td><input type="text" style="width:100%" name="skype" value="{$smarty.request.skype|default:$current_school.skype}" /></td>
        </tr>
        <tr>
            <td>{"School phone 1"|i18n}</td>
            <td><input type="text" style="width:100%" name="phone_1" value="{$smarty.request.phone_1|default:$current_school.phone_1}" /></td>
        </tr>
        <tr>
            <td>{"School phone 2"|i18n}</td>
            <td><input type="text" style="width:100%" name="phone_2" value="{$smarty.request.phone_2|default:$current_school.phone_2}" /></td>
        </tr>
        <tr>
            <td>{"Address"|i18n}</td>
            <td><input type="text" style="width:100%" name="address" value="{$smarty.request.address|default:$current_school.address}" /></td>
        </tr>

        <tr>
            <td>
                <b>{"School description"|i18n}:</b>
            </td>
            <td colspan="2">

                <textarea id="description" name="description" style="width:100%;height:500px;">{$smarty.request.description|default:$current_school.description}</textarea>
            </td>
        </tr>

        <tr>
            <td>{"Current School Image"|i18n}</td>
            <td>
                <img src="{$http_images_path}{$Images->get_image_url($current_school.image_id,200,200,'jpg')}" alt="{"School Image"|i18n}" width="200" height="200" />
            </td>
        </tr>


        <tr>
            <td>{"School Image upload"|i18n}</td>
            <td>
                <input type="file" style="width:100%" name="school_image_file" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="btnSubmit" value="{"Edit school"|i18n}" />
                <input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='?ago={$smarty.request.r_go|default:'schools'}&s={$s}&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}'" />
            </td>
        </tr>

    </table>


    <input type="hidden" name="s" value="{$s}" />
    <input type="hidden" name="ago" value="{$smarty.request.r_go|default:'schools'}" />
    <input type="hidden" name="school_id" value="{$smarty.request.school_id}" />
    <input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
    <input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />

    <input type="hidden" name="action" value="edit_school" />
</form>

