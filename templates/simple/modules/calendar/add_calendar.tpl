{include file='header.tpl' script='modules/calendar/i_javascript.tpl'}
{literal}
    <script type="text/javascript">
        //$(document).ready(function(){
        //    getBBEditor("full_info");
        //});


        $(function() {
            $("#full_info").sceditor({
                plugins: "bbcode",
                style: "{/literal}{$http_project_path}{literal}sceditor/minified/jquery.sceditor.default.min.css",
                locale: "ru",
                emoticonsRoot: "{/literal}{$http_project_path}{literal}sceditor/"
            });
            $("#full_info").sceditor('instance').sourceMode(true);
        });
    </script>
{/literal}

<center><h2><img src="{$http_images_static_path}hmeropriayatia.jpg" alt=""/></h2></center>
<div class="title">{"Add action"|i18n}</div>
{if $smarty.request.bdate_Year eq ''}
    {assign var="bdate" value="now"|date_format:'%Y-%m-%d'}
{else}
    {assign var="bdate" value=$smarty.request.bdate_Year|cat:'-'|cat:$smarty.request.bdate_Month|cat:'-'|cat:$smarty.request.bdate_Day}
{/if}
{if $smarty.request.edate_Year eq ''}
    {assign var="edate" value="now"|date_format:'%Y-%m-%d'}
{else}
    {assign var="edate" value=$smarty.request.edate_Year|cat:'-'|cat:$smarty.request.edate_Month|cat:'-'|cat:$smarty.request.edate_Day}
{/if}
{assign var="current_city_id" value=$smarty.request.city_id}
{if $current_city_id > 0}
    {assign var="city" value=$Geo->get_city($current_city_id)}
    {assign var="country" value=$Geo->get_country($city.country_id)}
    {assign var="subdivision" value=$Geo->get_subdivision($city.subdivision_id)}
{/if}
<form method="post" action="index.php" enctype="multipart/form-data">
    <input type="hidden" name="go" value="add_calendar" />
    <input type="hidden" name="action" value="add_calendar" />
    <input type="hidden" name="s" value="{$s}" />
    {include file='i_error.tpl'}
    <table width="100%">
        <tr>
            <td>{"Select begin date"|i18n}</td>
            <td>{html_select_date prefix=bdate_ time=$bdate end_year=+1}</td>
        </tr>
        <tr>
            <td>{"Select end date"|i18n}</td>
            <td>{html_select_date prefix=edate_ time=$edate end_year=+1}</td>
        </tr>
        <tr>
            <td>{"Type address"|i18n}</td>
            <td>
                <div style="display:inline;float:left;">
                    <select name="country_id" onchange="xajax_get_calendar_country_subdivisions(this.options[this.selectedIndex].value);">
                        <option value="">{"Please select"|i18n}</option>
                        {foreach from=$Geo->get_countries() item=country_data}
                            <option value="{$country_data.id}" {if $country_data.id == $country.id}selected{/if}>{$country_data.name}</option>
                        {/foreach}
                    </select>
                </div>
                <div id="subdivision_id" style="width:100px;display:inline;float:left;">
                    {include file='modules/calendar/i_country_subdivisions.tpl' subdivision_id=$subdivision.id country_id=$country.id }
                </div>
                <div id="city_id" style="width:100px;display:inline;float:left;">
                    {include file='modules/calendar/i_cities.tpl' subdivision_id=$subdivision.id city_id=$current_city_id }
                </div>
                <br clear="all"/>
                {assign var="address_default" value="Type address there"|i18n}
                <input type="text" name="address" id="address" value="{$smarty.request.address|default:$address_default}" onclick="if(this.value=='{$address_default}')this.value='';" onblur="if(this.value=='')this.value='{$address_default}';" />
            </td>
        </tr>
        <tr>
            <td>{"Select category"|i18n}</td>
            <td>
                <select name="category_id">
                    {foreach from=$calendar->get_categories() item=category}
                        <option value="{$category.id}" {if $smarty.request.category_id == $category.id}selected{/if}>{$category.name}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top">{"Name"|i18n}</td>
            <td>
                <input type="text" style="width:100%" name="name" value="{$smarty.request.name|escape:html}" max_length="100" />
            </td>
        </tr>

        <tr>
            <td valign="top">{"Full info"|i18n}</td>
            <td>
                <textarea name="full_info" id="full_info" style="width:100%;height:1000px;">{$smarty.request.full_info}</textarea>
            </td>
        </tr>

        <tr>
            <td>{"Organizator full name"|i18n}</td>
            <td>
                <input type="text" style="width:100%" name="organizator_name" value="{$smarty.request.organizator_name}" max_length="255" />
            </td>
        </tr>

        <tr>
            <td colspan="2" width="100%">
                <div style="text-align: center;cursor:pointer;" onclick="xajax_add_container_element('lfm_container','lfm[]','i_lfm',' ');">{"Add LFM"|i18n}</div>
                <div id="lfm_container"></div>
                <div style="text-align: center;cursor:pointer;" onclick="xajax_add_container_element('web_container','web[]','i_web',' ');">{"Add web"|i18n}</div>
                <div id="web_container"></div>
                <div style="text-align: center;cursor:pointer;" onclick="xajax_add_container_element('email_container','email[]','i_email',' ');">{"Add email"|i18n}</div>
                <div id="email_container"></div>
                <div style="text-align: center;cursor:pointer;" onclick="xajax_add_container_element('image_container','image[]','i_image',' ');">{"Add image"|i18n}</div>
                <div id="image_container"></div>

            </td>
        </tr>

        <tr align="center">
            <td colspan="2">
                <input type="submit" name="btnSubmit" value="{"Add"|i18n}" onclick="change_address('address','{$address_default}');">
                <input type="button" name="btnBack" value="{"Back"|i18n}" onclick="window.location='{$http_module_path}index.php?s={$s}'" />
            </td>
        </tr>


    </table>


</form>

{include file='footer.tpl'}