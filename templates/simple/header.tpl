<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>{$title|default:'RAKS'}</title>
    <meta name="title" content="{$title|default:'RAKS'}"/>
    <meta name="keywords" content="{$metaKeywords}"/>
    <meta name="description" content="{$metaDescription|strip_tags|escape:'javascript'|truncate:255}"/>

    <!-- for Facebook -->
    <meta property="og:title" content="{$metaTitle|default:'RAKS'}"/>
    {assign var="defaultMetaIMG" value=$http_images_static_path|cat:'logo_real_krug_1024.png'}
    <meta property="og:image" content="{$metaIMG|default:$defaultMetaIMG}"/>
    <meta property="og:url" content="{$metaURL|default:$http_project_path}"/>
    <meta property="og:description" content="{$metaDescription|strip_tags|escape:'javascript'|truncate:255}"/>
    <meta property="og:type" content="website"/>
    <meta property="fb:app_id" content="{$facebook_app_id}"/>



    <link type="text/css" href="{$http_project_path}jQuery/jquery-ui/css/redmond/jquery-ui-1.10.3.custom.css"
          rel="stylesheet"/>
    <link rel="stylesheet" href="{$http_project_path}select2/select2.css" type="text/css" media="screen, projection"/>
    <link rel="stylesheet" href="{$http_project_path}sceditor/minified/themes/default.min.css" type="text/css"
          media="all"/>
    <link rel="stylesheet" href="{$http_css_path}portal2.css" type="text/css" media="screen, projection"/>
    <link rel="stylesheet" href="{$http_css_path}banner.css" type="text/css" media="screen, projection"/>
    <link rel="stylesheet" href="{$http_css_path}forum.css" type="text/css" media="screen, projection"/>
    <link rel="stylesheet" href="{$http_css_path}calendar.css" type="text/css" media="screen, projection"/>
    <link rel="stylesheet" href="{$http_css_path}video.css" type="text/css" media="screen, projection"/>
    <!--[if IE]>
    <link href="{$http_css_path}ie.css" rel="stylesheet" type="text/css"/>
    <![endif]-->
    {if $use_module_css == 1}
        <link rel="stylesheet" href="{$http_css_path}{$module_name}.css" type="text/css" media="screen, projection"/>
    {/if}
    <script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script type="text/javascript"
            src="{$http_project_path}jQuery/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="{$http_project_path}ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="{$http_project_path}sceditor/minified/jquery.sceditor.bbcode.min.js"></script>
    <script src="{$http_project_path}sceditor/languages/ru.js"></script>
    {if $script ne ''}
        {include file=$script}
    {/if}
    {if $xjs ne ''}
        {$xjs}
    {/if}

    {include file='i_javascript.tpl'}
    <script type="text/javascript" src="{$http_project_path}swfobject/swfobject.js"></script>
    <script type="text/javascript" src="{$http_project_path}select2/select2.js"></script>

    {if $showCaptcha == 1}
        <script src='https://www.google.com/recaptcha/api.js'></script>
    {literal}
        <script type="text/javascript">
            function showRecaptcha(element) {
                /*
                Recaptcha.create("{/literal}{$captcha.public}{literal}", element, {
                    theme: "white",
                    lang: "ru"
                });
                */
            }
            $(document).ready(function () {
                showRecaptcha('recaptcha_div');

            });
        </script>
    {/literal}
    {/if}
    <script type="text/javascript">
                {literal}var flashvars = {bannerLink: "{/literal}{$http_project_path}{literal}"};
        swfobject.embedSWF("{/literal}{$http_images_static_path}{literal}raks.swf", "flash", "100%", "480", "10.0.0", "swfobject/expressInstall.swf");
        function setCookie(c_name, value, exdays) {
            var exdate = new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
            document.cookie = c_name + "=" + c_value;
        }

        function getCookie(c_name) {
            var i, x, y, ARRcookies = document.cookie.split(";");
            for (i = 0; i < ARRcookies.length; i++) {
                x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                x = x.replace(/^\s+|\s+$/g, "");
                if (x == c_name) {
                    return unescape(y);
                }
            }
        }

        function randomFromTo(from, to) {
            return Math.floor(Math.random() * (to - from + 1) + from);
        }

        function showBannerData(name, banners) {
            var currentId = getCookie(name);
            var max = banners.length - 1;
            if (max < 0) return false;
            if (currentId != null) {

                if (currentId >= max) {
                    currentId = 0;
                } else {
                    currentId++;
                }
            } else {
                currentId = randomFromTo(0, max);
            }
            if (banners[currentId][1] == 'html') {
                document.getElementById(name).innerHTML = banners[currentId][0];
            }
            if (banners[currentId][1] == 'swf') {
                swfobject.embedSWF(banners[currentId][0], name + "_flash", banners[currentId][2], banners[currentId][3], "10.0.0.0", "https://raks.com.ua/forum/swfobject/expressInstall.swf");
            }
            if (banners[currentId][1] == 'container') {
                document.getElementById(name).innerHTML = banners[currentId][0];

            }
            setCookie(name, currentId, 1);
        }

        function loadBanners() {
            var banner_165_1 = new Array();
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=16387" target="_blank"><img src="http://raks.com.ua/forum/images/banner_konk.jpg" alt=""/></a>', 'html', 165, 190);
//            banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=16397" target="_blank"><img src="http://raks.com.ua/forum/images/amirra.jpg" alt=""/></a>', 'html', 165, 190);
//            banner_165_1[0]   = new Array ('<a href="http://www.raks.com.ua/forum/viewtopic.php?f=148&t=16587" target="_blank"><img src="http://raks.com.ua/forum/images/masr.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&p=188770" target="_blank"><img src="http://raks.com.ua/forum/images/banner_poraksuem2.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=16658" target="_blank"><img src="http://raks.com.ua/forum/images/ban2.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&p=189868" target="_blank"><img src="http://raks.com.ua/forum/images/banner_miss_2015_05_16.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=73&t=14253" target="_blank"><img src="http://raks.com.ua/forum/images/165_190.png" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18039" target="_blank"><img src="http://raks.com.ua/forum/images/banner_chulaevskaya.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('http://raks.com.ua/forum/images/jm_raks.swf', 'swf', 165, 190);
            //banner_165_1[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&p=198003" target="_blank"><img src="http://raks.com.ua/forum/images/solnce.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18091" target="_blank"><img src="http://raks.com.ua/forum/images/banner_odessa4.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=17899" target="_blank"><img src="http://raks.com.ua/forum/images/banner_odessa2.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=73&t=14253" target="_blank"><img src="http://raks.com.ua/forum/images/165_190.png" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18051" target="_blank"><img src="http://raks.com.ua/forum/images/banner_afalina1.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://www.alhayatfestival.com.ua" target="_blank"><img src="http://raks.com.ua/forum/images/alhayat.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_1[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18272" target="_blank"><img src="http://raks.com.ua/forum/images/giphy.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="https://www.sportandtour.com.ua/kalendar" target="_blank"><img src="http://raks.com.ua/forum/images/banner_nava.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18203" target="_blank"><img src="http://raks.com.ua/forum/images/amirrra.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&p=206471" target="_blank"><img src="http://raks.com.ua/forum/images/bagira3.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18674" target="_blank"><img src="http://raks.com.ua/forum/images/orient_empire.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18674" target="_blank"><img src="http://raks.com.ua/forum/images/orient_empire.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[0] = new Array('<a href="https://raks.com.ua/forum/viewtopic.php?f=148&t=18902" target="_blank"><img src="http://raks.com.ua/forum/images/palmyra_2019.gif" alt=""/></a>', 'html', 165, 190);
            banner_165_1[0] = new Array('<a href="https://raks.com.ua/forum/viewtopic.php?f=148&t=19000" target="_blank"><img src="http://raks.com.ua/forum/images/hayat.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_1[1] = new Array('<a href="http://alishaonline.ru/alisha" target="_blank"><img src="http://raks.com.ua/forum/images/banner_denisova.gif" alt=""/></a>', 'html', 165, 190);


//


            showBannerData('banner_165_1', banner_165_1);

            var banner_165_2 = new Array();
//            banner_165_2[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=73&t=14253" target="_blank"><img src="http://raks.com.ua/forum/images/165_190.png" alt=""/></a>', 'html', 165, 190);
            //banner_165_2[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18640&p=206631#p206631" target="_blank"><img src="http://raks.com.ua/forum/images/banner_riker5.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_2[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18607" target="_blank"><img src="http://raks.com.ua/forum/images/palmyra_.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_2[0] = new Array('<a href="https://raks.com.ua/forum/viewtopic.php?f=148&t=18739" target="_blank"><img src="https://raks.com.ua/forum/images/banner_syzko.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_2[0] = new Array('<a href="http://alishaonline.ru/alisha_webinar" target="_blank"><img src="https://raks.com.ua/forum/images/banner_denisova5.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_2[0]   = new Array ('<a href="https://raks.com.ua/forum/viewtopic.php?f=73&t=14253" target="_blank"><img src="https://raks.com.ua/forum/images/165_190.png" alt=""/></a>', 'html', 165, 190);
            banner_165_2[0]   = new Array ('<a href="https://raks.com.ua/forum/viewtopic.php?f=148&t=19147" target="_blank"><img src="https://raks.com.ua/forum/images/faiza.jpg" alt=""/></a>', 'html', 165, 190);


            //            banner_165_2[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18081" target="_blank"><img src="http://raks.com.ua/forum/images/seasons.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_2[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18227" target="_blank"><img src="http://raks.com.ua/forum/images/banner_riker3.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_2[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18249" target="_blank"><img src="http://raks.com.ua/forum/images/isfahan.gif" alt=""/></a>', 'html', 165, 190);

            showBannerData('banner_165_2', banner_165_2);

            var banner_165_3  = new Array();
           banner_165_3[0]   = new Array ('<a href="https://raks.com.ua/forum/viewtopic.php?f=164&t=19220" target="_blank"><img src="http://raks.com.ua/forum/images/banner_denisova2.gif" alt=""/></a>', 'html', 165, 190);
          //banner_165_3[0]   = new Array ('<a href="https://raks.com.ua/forum/viewtopic.php?f=148&t=19018" target="_blank"><img src="http://raks.com.ua/forum/images/banner_moldova.gif" alt=""/></a>', 'html', 165, 190);

          //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18109" target="_blank"><img src="http://raks.com.ua/forum/images/girl2.jpg" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=73&t=14253" target="_blank"><img src="http://raks.com.ua/forum/images/165_190.png" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18103" target="_blank"><img src="http://raks.com.ua/forum/images/izadora.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18091" target="_blank"><img src="http://raks.com.ua/forum/images/palma.gif" alt=""/></a>', 'html', 165, 190);
           //banner_165_3[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=164&t=18170&start=0" target="_blank"><img src="http://raks.com.ua/forum/images/banner_kazimir.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=17333" target="_blank"><img src="http://raks.com.ua/forum/images/banner_star_again.gif" alt=""/></a>', 'html', 165, 190);
            // banner_165_3[0]   = new Array ('<a href="http://shineart.com.ua/" target="_blank"><img src="http://raks.com.ua/forum/images/shineart.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18092" target="_blank"><img src="http://raks.com.ua/forum/images/train.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18043" target="_blank"><img src="http://raks.com.ua/forum/images/banner_esfir2.gif" alt=""/></a>', 'html', 165, 190);

            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18234" target="_blank"><img src="http://raks.com.ua/forum/images/cairo.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18327" target="_blank"><img src="http://raks.com.ua/forum/images/afalina.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=164&t=18706" target="_blank"><img src="http://raks.com.ua/forum/images/29_october.gif" alt=""/></a>', 'html', 165, 190);

            //banner_165_3[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18149" target="_blank"><img src="http://raks.com.ua/forum/images/gold5.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_3[0]   = new Array ('<a href="https://www.facebook.com/groups/happylife/" target="_blank"><img src="http://raks.com.ua/forum/images/banner_arkany1.gif" alt=""/></a>', 'html', 165, 190);

            showBannerData('banner_165_3', banner_165_3);

            var banner_165_4 = new Array();
            //banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=73&t=14253" target="_blank"><img src="http://raks.com.ua/forum/images/165_190.png" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=17736" target="_blank"><img src="http://raks.com.ua/forum/images/gif_nn_cc_2.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=17967" target="_blank"><img src="http://raks.com.ua/forum/images/pervenstvo_gif_cc.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[0]   = new Array ('http://raks.com.ua/forum/images/165_190_Zaporozhie_belly.swf', 'swf', 165, 190);
            //banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=17743" target="_blank"><img src="http://raks.com.ua/forum/images/alla.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[1]   = new Array ('<a href="http://class.soladance.com/" target="_blank"><img src="http://raks.com.ua/forum/images/vs_raks_banner.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[0]   = new Array ('http://raks.com.ua/forum/images/aj2-raks.swf', 'swf', 165, 190);
            //banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18298" target="_blank"><img src="http://raks.com.ua/forum/images/CHAMP2_2.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=164&t=18519" target="_blank"><img src="http://raks.com.ua/forum/images/belarus_4.gif" alt=""/></a>', 'html', 165, 190);
//            banner_165_4[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18251" target="_blank"><img src="http://raks.com.ua/forum/images/ju.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[1]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=17971" target="_blank"><img src="http://raks.com.ua/forum/images/banner_enigma2.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=148&t=18327" target="_blank"><img src="http://raks.com.ua/forum/images/afalina.gif" alt=""/></a>', 'html', 165, 190);
            banner_165_4[0]   = new Array ('<a href="http://raks.com.ua/forum/viewtopic.php?f=73&t=14253" target="_blank"><img src="http://raks.com.ua/forum/images/165_190.png" alt=""/></a>', 'html', 165, 190);
          //banner_165_4[0]   = new Array ('<a href="https://raks.com.ua/forum/viewtopic.php?f=148&t=19097" target="_blank"><img src="http://raks.com.ua/forum/images/zaharit2.gif" alt=""/></a>', 'html', 165, 190);
            //banner_165_4[0]   = new Array ('<a href="https://raks.com.ua/forum/viewtopic.php?f=148&t=18801" target="_blank"><img src="http://raks.com.ua/forum/images/unnamed2.gif" alt=""/></a>', 'html', 165, 190);

            showBannerData('banner_165_4', banner_165_4);
        }

        $(document).ready(function () {
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
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&version={/literal}{$facebook_version}{literal}&appId={/literal}{$facebook_app_id}{literal}";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!--script type="text/javascript" src="http://raks.com.ua/forum/snow.js"></script-->
{/literal}
<div id="header">
    <div id="flash"></div>
</div>
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
