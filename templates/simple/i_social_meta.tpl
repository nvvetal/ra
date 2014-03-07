{assign var="defaultMetaIMG" value=$http_images_static_path|cat:'logo_real_krug_1024.png'}{literal}{
    "title": "{/literal}{$metaTitle|default:'RAKS'}{literal}",
    "image": "{/literal}{$metaIMG|default:$defaultMetaIMG}{literal}",
    "url": "{/literal}{$metaURL|default:$http_project_path}{literal}",
    "description": "{/literal}{$metaDescription|strip_tags|escape:'javascript'|truncate:255}{literal}"
}{/literal}