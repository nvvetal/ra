{include file='i_error.tpl'}
{literal}
    <script>
        function checkRegisterDisclaimer(){
            if ($('#disclaimer').is(':checked')) {
                return true;
            } else {
                alert("Пожалуйста прочитайте условия пользования! Please read disclaimer and accept!");
                return false;
            }
        }
    </script>
{/literal}
{if $is_use_form == 1}
<form method="post" action="{$http_project_path}">
    {/if}


    <table width="400px" align="center">
        <tr>
            <td>{"Login"|i18n}<span class="required">*</span></td>
            <td><input type="text" name="register_login" value="{$smarty.request.register_login}"/></td>
        </tr>
        <tr>
            <td>{"Password"|i18n}<span class="required">*</span></td>
            <td><input type="password" name="register_password" value="{$smarty.request.register_password}"/></td>
        </tr>
        <tr>
            <td>{"Password 2"|i18n}<span class="required">*</span></td>
            <td><input type="password" name="register_password2" value="{$smarty.request.register_password}"/></td>
        </tr>
        <tr>
            <td>{"Email"|i18n}<span class="required">*</span></td>
            <td><input type="text" name="register_email" value="{$smarty.request.register_email}"/></td>
        </tr>
        <tr>
            <td>{"Sex"|i18n}<span class="required">*</span></td>
            <td>
                <select name="p_sex">
                    <option value="female"
                            {if $smarty.request.p_sex == 'female'}selected{/if}>{"Sex Female"|i18n}</option>
                    <option value="male" {if $smarty.request.p_sex == 'male'}selected{/if}>{"Sex Male"|i18n}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>{"Birthday Date"|i18n}<span class="required">*</span></td>
            <td>
                {html_select_date prefix='birthday_' start_year=-100 end_year=-12}
            </td>
        </tr>
        <tr>
            <td>{"From where?"|i18n}<span class="required">*</span></td>
            <td>
                <select name="country_id" style="width:30%"
                        onchange="xajax_get_country_subdivisions(this.options[this.selectedIndex].value);">
                    <option value="">{"Please select"|i18n}</option>
                    {foreach from=$Geo->get_countries() item=country_data}
                        <option value="{$country_data.id}"
                                {if $country_data.id == $country.id}selected{/if}>{$country_data.name}</option>
                    {/foreach}
                </select>
                <span id="subdivision_id">
                    {include file='i_country_subdivisions.tpl' subdivision_id=$subdivision.id country_id=$country.id }
                </span>
                <span id="city_id">
                    {include file='i_cities.tpl' subdivision_id=$subdivision.id city_id=$current_city_id }
                </span>
            </td>
        </tr>
        <tr>
            <td>Условия использования (Disclaimer)<span class="required">*</span></td>
            <td>
                <input type="checkbox" name="disclaimer" id="disclaimer" value="1"/> <a
                        href="https://raks.com.ua/forum/disclaimer.html">Читать</a>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div id="recaptcha_div" class="g-recaptcha" data-sitekey="{$captcha.public}"></div>
            </td>
        </tr>
        {if $is_use_form == 1}
        <tr>
            <td colspan="2" align="center"><input type="submit" name="btnSubmit" value="{"Register"|i18n}"
                                                  onsubmit="return checkRegisterDisclaimer();"/></td>
        </tr>
    </table>

    <input type="hidden" name="action" value="register_user"/>
    <input type="hidden" name="go" value="register_result"/>
    <input type="hidden" name="register_is_autologin" value="1"/>
    <input type="hidden" name="s" value="{$s}"/>
</form>
{else}
    </table>
<input type="hidden" name="register_action" value="register_user"/>
{/if}

