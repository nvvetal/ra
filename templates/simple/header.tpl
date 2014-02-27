<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{$title|default:'RAKS'}</title>
    <meta name="title" content="{$title|default:'RAKS'}" />
    <meta name="keywords" content="восточные танцы, восточные танцы Украина, восточные танцы Киев, танец живота, беллиданс{if $module_name eq 'schools'}, школы восточного танца, обучение восточному танцу, школы танца живота, обучение танцу живота{/if}" />
    <meta name="description" content="{$metaDescription|strip_tags|escape:'javascript'|truncate:255}" />

    <!-- for Facebook -->
    <meta property="og:title" content="{$metaTitle|default:'RAKS'}" />
    {assign var="defaultMetaIMG" value=$http_images_static_path|cat:'logo_real_krug_1024.png'}
    <meta property="og:image" content="{$metaIMG|default:$defaultMetaIMG}" />
    <meta property="og:url" content="{$metaURL|default:$http_project_path}" />
    <meta property="og:description" content="{$metaDescription|strip_tags|escape:'javascript'|truncate:255}" />
    <meta property="og:type" content="{$module_name|default:'website'}" />
    <meta property="fb:app_id" content="{$facebook_app_id}" />

    <!-- for Vkontakte -->
    <meta property="vk:app_id" content="{$vkontakte_app_id}" />


    <link type="text/css" href="{$http_project_path}jQuery/jquery-ui/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="{$http_project_path}select2/select2.css" type="text/css" media="screen, projection" />

    <link rel="stylesheet" href="{$http_css_path}portal2.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="{$http_css_path}banner.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="{$http_css_path}forum.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="{$http_css_path}calendar.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="{$http_css_path}video.css" type="text/css" media="screen, projection" />
    <!--[if IE]>
    <link href="{$http_css_path}ie.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    {if $use_module_css == 1}
        <link rel="stylesheet" href="{$http_css_path}{$module_name}.css" type="text/css" media="screen, projection" />
    {/if}
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="{$http_project_path}jQuery/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="{$http_project_path}ckeditor/ckeditor.js"></script>
    {if $script ne ''}
        {include file=$script}
    {/if}
    {if $xjs ne ''}
        {$xjs}
    {/if}
    <script src="//vk.com/js/api/openapi.js?105"></script>
    {literal}
        <script src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
    {/literal}

    {literal}
    <script>
        $(document).ready(function(){
            VK.init({apiId: {/literal}{$vkontakte_app_id}{literal}, onlyWidgets: true});
        });
    </script>
    {/literal}
    {include file='i_javascript.tpl'}
    <script type="text/javascript" src="{$http_project_path}swfobject/swfobject.js"></script>
    <script type="text/javascript" src="{$http_project_path}select2/select2.js"></script>

    {if $showCaptcha == 1}
        <script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
    {literal}
        <script type="text/javascript">
            function showRecaptcha(element) {
                Recaptcha.create("{/literal}{$captcha.public}{literal}", element, {
                    theme: "white",
                    lang: "ru"
                });
            }
            $(document).ready(function() {
                showRecaptcha('recaptcha_div');

            });
        </script>
    {/literal}
    {/if}
    <script type="text/javascript">
                {literal}var flashvars = {bannerLink: "{/literal}{$http_project_path}{literal}"};
        swfobject.embedSWF("{/literal}{$http_images_static_path}{literal}raks.swf", "flash", "100%", "480", "10.0.0", "swfobject/expressInstall.swf");
        function setCookie(c_name, value, exdays)
        {
            var exdate=new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
            document.cookie=c_name + "=" + c_value;
        }

        function getCookie(c_name)
        {
            var i,x,y,ARRcookies=document.cookie.split(";");
            for (i=0;i<ARRcookies.length;i++)
            {
                x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
                y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
                x=x.replace(/^\s+|\s+$/g,"");
                if (x==c_name)
                {
                    return unescape(y);
                }
            }
        }

        function randomFromTo(from, to){
            return Math.floor(Math.random() * (to - from + 1) + from);
        }

        function showBannerData(name, banners)
        {
            var currentId = getCookie(name);
            var max = banners.length - 1;
            if(max < 0) return false;
            if(currentId != null){

                if(currentId >= max ){
                    currentId = 0;
                }else{
                    currentId++;
                }
            }else{
                currentId = randomFromTo(0, max);
            }
            if(banners[currentId][1] == 'html'){
                document.getElementById(name).innerHTML = banners[currentId][0];
            }
            if(banners[currentId][1] == 'swf'){
                swfobject.embedSWF(banners[currentId][0], name+"_flash", banners[currentId][2], banners[currentId][3], "10.0.0.0", "http://raks.com.ua/forum/swfobject/expressInstall.swf");
            }
            if(banners[currentId][1] == 'container'){
                document.getElementById(name).innerHTML = banners[currentId][0];

            }
            setCookie(name, currentId, 1);
        }

        function loadBanners()
        {
            var banner_165_1  = new Array();
            banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=16387" target="_blank"><img src="http://raks.com.ua/forum/images/banner_konk.jpg" alt=""/></a>', 'html', 165, 190);
            banner_165_1[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=164&t=16420" target="_blank"><img src="http://raks.com.ua/forum/images/banner_mk.jpg" alt=""/></a>', 'html', 165, 190);
            showBannerData('banner_165_1', banner_165_1);

            var banner_165_2  = new Array();
            banner_165_2[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=16005" target="_blank"><img src="http://raks.com.ua/forum/images/el_faum.gif" alt=""/></a>', 'html', 165, 190);
            showBannerData('banner_165_2', banner_165_2);

            var banner_165_3  = new Array();
            banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=164&t=14530" target="_blank"><img src="http://raks.com.ua/forum/images/konk.gif" alt=""/></a>', 'html', 165, 190);
            banner_165_3[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=16350" target="_blank"><img src="http://raks.com.ua/forum/images/banner_bn2.gif" alt=""/></a>', 'html', 165, 190);
            showBannerData('banner_165_3', banner_165_3);

            var banner_165_4  = new Array();
            banner_165_4[0]   = new Array ('<a href="http://dancebox.com.ua/" target="_blank" ><img src="http://raks.com.ua/forum/images/dbx_.gif" alt=""/></a>', 'html', 165, 190);
            showBannerData('banner_165_4', banner_165_4);
        }

        $(document).ready(function(){
            loadBanners();
            refreshSocialButtons();
        });
        {/literal}

    </script>
</head>
<body>
<div id="fb-root"></div>
{literal}
<script>
    window.fbAsyncInit = function() {
        FB.init({appId: '{/literal}{$facebook_app_id}{literal}', status: true, cookie: true,
            xfbml: true});
    };
    (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/ru_RU/all.js";
        ref.parentNode.insertBefore(js, ref);

    }(document));
</script>
{/literal}
<div id="header">
    <div id="flash"></div>
</div>
<div id="new-social-meta" style="height:0px;"></div>
<table style="width: 100%">
    {include file='i_top_banners.tpl'}
    <tr>
        <td>&nbsp;</td>
        <td style="width: 990px;" align="center">
            <div class="container">
                <div class="corner_left">&nbsp;</div>
                <div class="corner_right">&nbsp;</div>
                <br clear="left"/>
                <table width="100%" border="0">
                    <tr valign="top" align="left">
                        <td class="menu">
                            {include file='i_login.tpl'}
                            {include file='i_menu_links.tpl'}
                        </td>
                        <td class="content">