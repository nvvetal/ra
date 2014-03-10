#!/bin/bash
cd ../html
ln -s ../modules/admin admin
ln -s ../modules/article article
ln -s ../modules/banners banners
ln -s ../modules/calendar calendar
ln -s ../modules/forum forum
ln -s ../modules/payment payment
ln -s ../modules/photo photo
ln -s ../modules/rating rating
ln -s ../modules/schools schools
ln -s ../modules/shop shop
ln -s ../modules/video video

ln -s ../lib/captcha captcha
ln -s ../lib/ckeditor ckeditor
ln -s ../lib/galleria galleria
ln -s ../lib/jQuery jQuery
ln -s ../lib/kcfinder kcfinder
ln -s ../lib/menu menu
ln -s ../lib/plupload plupload
ln -s ../lib/select2 select2
ln -s ../lib/xajax xajax

ln -s ../templates/simple/css css
ln -s ../templates/simple/images images
ln -s ../internal internal
ln -s ../users users

cd ../modules/forum
ln -s ../../cache/forum cache
ln -s ../../files/forum files
ln -s ../../images/forum images

