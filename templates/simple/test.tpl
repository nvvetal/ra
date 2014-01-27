<html>
<head>
	<script type="text/javascript" src="{$http_project_path}jQuery/jquery.js"></script>	
	<script type="text/javascript" src="{$http_project_path}galleria/galleria-1.2.5.js"></script>
</head>
<body>

<div id="gallery">
<a id="image1" href="http://www.motifake.com/image/demotivational-poster/small/1012/beautiful-eyes-eyes-tits-beer-demotivational-posters-1293762529.jpg" imageId="1"><img src="http://www.motifake.com/image/demotivational-poster/small/1012/beautiful-eyes-eyes-tits-beer-demotivational-posters-1293762529.jpg" alt="zzz"/></a>    
<a id="image2" href="http://www.motifake.com/image/demotivational-poster/small/1004/a-true-woman-real-woman-warrior-kitchen-sammich-tits-demotivational-poster-1270244497.jpg" imageId="2"><img src="http://www.motifake.com/image/demotivational-poster/small/1004/a-true-woman-real-woman-warrior-kitchen-sammich-tits-demotivational-poster-1270244497.jpg" alt="zzz"/></a>    
<a id="image3" href="http://www.motifake.com/image/demotivational-poster/small/1004/a-true-woman-real-woman-warrior-kitchen-sammich-tits-demotivational-poster-1270244497.jpg" imageId="3"><img src="http://www.motifake.com/image/demotivational-poster/small/1004/a-true-woman-real-woman-warrior-kitchen-sammich-tits-demotivational-poster-1270244497.jpg" alt="zzz"/></a>    
</div>
{literal}
<script>
function getImageGalleryIndex(imageId)
{
	var idx = 0;
	var i = 0
	var isFound = false;
    $('a[id^="image"]').each(function(i){

		if($(this).attr('id') == imageId) {
			isFound = true;
			return false;
		}
		idx++;
    });
    if(isFound == true) return idx;
	return 0;
}
</script>
<script>
$(document).ready(function() {
  // Handler for .ready() called.
    Galleria.loadTheme('{/literal}{$http_project_path}{literal}galleria/themes/classic/galleria.classic.min.js');

	var idx = getImageGalleryIndex('image1'); 

    $('#gallery').galleria({
    	show: idx,
        width:680,
        height:500    	
    });
  
    
});    
</script>
{/literal}	
</body>
</html>