{literal}
	<script>
	$(function() {
		function log( message ) {
			$( "<div/>" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );
		}
		$( "#search" ).autocomplete({
			source: "search.php",
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item ?
					"Selected: " + ui.item.value + " aka " + ui.item.id :
					"Nothing selected, input was " + this.value );
			}
		});
	});
	</script>
{/literal}
<input type="text" value="{$smarty.request.search}" name="search" id="search" style="width:80%;" /> 
<input type="button" name="btnSearch" value="{"Search"|i18n}" onclick="javascript:window.location.href='{$http_project_path}video/?s={$s}&go=search_videos&search='+$('#search').val()" />
