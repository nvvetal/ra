{literal}
<script>

    function appInit() {
        var url = window.location.href;
        var parts = url.split('#');
        if (parts.length > 1 && parts[1].indexOf('state') === 0) {
            var newUrl = parts[0];
            var items = parts[1].split('&');
            items[0] = decodeURIComponent(items[0].substr(6)).split(',');
            for (var i = 0; i < items[0].length; i++) {
                newUrl += items[0][i] + '&';

            }
            for (var i = 1; i < items.length; i++) {
                newUrl += items[i] + '&';
            }
            window.location = newUrl;
        }
    }


    function loginFB() {
        var url = 'https://www.facebook.com/{/literal}{$facebook_version}{literal}/dialog/oauth?client_id={/literal}{$facebook_app_id}{literal}&redirect_uri=' + encodeURI('https://raks.com.ua') + '&state=' + encodeURI('go=index,action=facebook') + '&scope={/literal}{$facebook_login_scope}{literal}&response_type=token';
        console.log('[URL]', url);
        window.location.href = url;
    }

    appInit();

</script>
{/literal}
{if $Session->get_value($s,'is_logged') == 0}
    <div class="auth">
        <form method="post" action="{$http_project_path}" style="margin-top:-10px;">
            <div>
                <input value="{"type login"|i18n:'default'}" name="login" type="text"
                       onfocus="if(this.value == '{"type login"|i18n:'default'}')this.value='';"/>
            </div>
            <div>
                <input value="{"type password"|i18n:'default'}" name="password" type="text"
                       onfocus="if(this.value == '{"type password"|i18n:'default'}')this.value='';"/>
            </div>
            <div>
                <label for="is_autologin">{"remember me"|i18n:'default'}</label>
                <input type="checkbox" id="is_autologin" name="is_autologin" value="1"/>
            </div>
            <input src="{$http_images_static_path}authbutton.jpg" class="button" value="{"Enter"|i18n:'default'}"
                   type="image"/>
            <div style="margin-top: -17px">
                <div>
                    <a href="{$http_project_path}/?go=password_back&s={$s}">{"Password back"|i18n:'default'}</a>
                </div>
                <div>
                    <div style="display: inline-block">
                        <a href="{$http_project_path}/?go=register&s={$s}">{"Register"|i18n:'default'}</a> &nbsp; &nbsp;
                    </div>
                    <div  style="display: inline-block;">
                        <div>
                            <img src="https://raks.com.ua/forum/images/buttons/fb.png" onclick="loginFB()" alt=""  style="cursor: pointer;margin-bottom: -7px;" />
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" name="is_autologin" value="1"/>
            <input type="hidden" name="go" value="index"/>
            <input type="hidden" name="action" value="login"/>
            <input type="hidden" name="s" value="{$s}"/>
        </form>
    </div>
{else}
    <div class="auth">
        <div class="text">{"Hello"|i18n:'default'}
            , {$User->get_value($user_id,'p_first_name')|default:$User->get_value($user_id,'login')}!
        </div>
        <a href="{$http_project_path}?s={$s}&go=profile&user_id={$user_id}">{"My Profile"|i18n:'default'}</a> <span
                class="new-indicator">({"all"|eventsCount})</span><br/>
        <!--a href="{$http_project_path}schools/?s={$s}&go=my_schools">{"My Schools"|i18n:'default'}</a><br/-->
        {if $User->get_value($user_id,'type') == 'admin' || $User->get_value($user_id,'type') == 'moderator'}<a
            href="{$http_project_path}admin/?s={$s}">{"Admin enter"|i18n:'default'}</a>
            <br/>
        {/if}
        <a href="{$http_project_path}?s={$s}&go=logout">{"Logout"|i18n:'default'}</a><br/>
    </div>
{/if}
