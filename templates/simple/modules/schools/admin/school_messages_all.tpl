
<table width="100%" align="center">
    <tr>
	<td>{"Message"|i18n}</td>
	<td>{"School"|i18n}</td>
	<td>{"Author"|i18n}</td>
	<td>{"Created Date"|i18n}</td>
	<td>{"Approved status"|i18n}</td>
	<td>{"Moderator"|i18n}</td>
	<td>{"Approved Date"|i18n}</td>
	<td>{"Operation"|i18n}</td>
    </tr>

    {foreach from=$school_blog->get_all_messages($smarty.request.page,$smarty.request.per_page) item=message}
    {assign var="school_data" value=$school->get_school($message.school_id)}
    <tr>
	<td>{$message.text|truncate:50:'...':false}</td>
	<td>{$school_data.name}</td>
	<td>{$User->get_value($message.author_id,'login')}</td>
	<td>{$message.created_date}</td>
	<td align="center">{$message.is_approved}</td>
	<td>{if $message.moderator_id ne '' || $message.moderator_id != 0}{$User->get_value($message.moderator_id,'login')}{else}{"Not moderated yet"}{/if}</td>
	<td>{$message.approve_date}</td>
	<td>
	    <select name="is_approved">
	    <option value="y" {if $message.is_approved eq 'y'}selected{/if}>{"Approved"|i18n}</option>
	    <option value="n" {if $message.is_approved eq 'n'}selected{/if}>{"Not Approved"|i18n}</option>
	    <option value="p" {if $message.is_approved eq 'p'}selected{/if}>{"Waiting for approve"|i18n}</option>
	    </select>
	    <a href="">{"Delete"|i18n}</a>
	</td>
    </tr>
    {foreachelse}
    <tr>
	<td colspan="7">{"No messages found"|i18n}</td>
    </tr>
    {/foreach}
</table>

{include file="i_pager.tpl" max_page=$school_blog->get_all_messages_pages($smarty.request.per_page) request="per_page|a_id|a_sid|s"}