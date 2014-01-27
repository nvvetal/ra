<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>{$title|default:'RAKS'}</title>
    <meta name="title" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="{$http_css_path}{$module_name}.css" type="text/css" media="screen, projection" />
    <link type="text/css" href="{$http_project_path}jQuery/jquery-ui/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script type="text/javascript" src="{$http_project_path}jQuery/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="{$http_project_path}ckeditor/ckeditor.js"></script>


    <script type="text/javascript" src="{$http_project_path}menu/jquerycssmenu.js"></script>
    <script type="text/javascript">
        arrowimages.down[1] = "{$http_project_path}menu/arrow-down.gif";
        arrowimages.right[1] = "{$http_project_path}menu/arrow-right.gif";
    </script>
    {include file="i_javascript.tpl"}
    {if $script ne ''}
        {include file=$script}
    {/if}
    {if $xjs ne ''}
        {$xjs}
    {/if}
    <script type="text/javascript" src="{$http_project_path}swfobject/swfobject.js"></script>
</head>
<body>
<div id="header">
    <a href="{$http_project_path}?s={$s}">{"Back to frontend"|i18n}</a>
</div>
<br clear="all"/>
<div class="container">
    <td class="content">