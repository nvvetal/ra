{include file="header.tpl"}

<form>
Post text: <input type="text" name="post_text" />
<input type="submit" name="btnSubmit" value="Add">
<input type="hidden" name="firm_id" value="111" />
<input type="hidden" name="action" value="add_blog" />
<input type="hidden" name="go" value="show_blogs" />
</form>

{include file="footer.tpl"}