{literal}
    <script type="text/javascript">
        function addArticleComment(sender, data, s)
        {
            $(sender).attr('disabled', 'disabled');
            xajax_addArticleComment(data, s);
        }

        function showSelectArticleRating()
        {

            $( "#dialog-select-article-rating" ).dialog({
                height: 270,
                width: 200,
                title: {/literal}"{"Rating set up"|i18n}"{literal},
                modal: true,
                buttons: {
                    {/literal}"{"Cancel"|i18n}"{literal}: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        }

        function updateReplyForComment(commentId)
        {
            var commentText = $('#comment-id-'+commentId+' .comment').html();
            $('#comment_to').html('TO: '+commentText+'<br/><a href="javascript:void(0);" onclick="removeReplyForComment();">[X]</a>');
            $('#p_item_id').val(commentId);
        }

        function removeReplyForComment()
        {
            $('#comment_to').html('');
            $('#p_item_id').val(0);
        }

        function disable_article(url){
            var disableText = prompt("{/literal}{"Please type reason"|i18n}{literal}","");
            if(disableText != '' && disableText != null){
                window.location.href = url + '&reason='+disableText;
                return true;
            }
            alert("{/literal}{"Error: You are not typed reason!"|i18n}{literal}");
            return false;
        }

        function delete_article(url){
            if(confirm("{/literal}{"Are you sure?"|i18n}{literal}")){
                window.location.href = url;
                return true;
            }
            return false;
        }

    </script>
{/literal}