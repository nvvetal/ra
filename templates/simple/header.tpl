<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{$title|default:'RAKS'}</title>
    <meta name="title" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
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
                {literal}var flashvars = {bannerLink: "{/literal}{$http_project_path}{literal}"};{/literal}
        swfobject.embedSWF("{$http_images_static_path}raks.swf", "flash", "100%", "480", "10.0.0", "swfobject/expressInstall.swf");
    </script>
</head>
<body>
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