{assign var="lang" value=$smarty.request.lang|default:'ru'}
{assign var="page" value=$smarty.request.page|default:'0'}
{assign var="per_page" value=$smarty.request.per_page|default:'30'}

<h1>{$i18n_module}</h1>
<form method="get" action="index.php">
    <input type="hidden" name="s" value="{$s}" />
    <input type="hidden" name="a_id" value="{$smarty.request.a_id}" />
    <input type="hidden" name="a_sid" value="{$smarty.request.a_sid}" />

    {"Lang"|i18n}:&nbsp;
    <select name="lang">
        <option value="ru">RU</option>
    </select>
    {"Type"|i18n}:&nbsp;
    <select name="type">
        <option value="all" {if $smarty.request.type == 'all'}selected{/if}>{"All"|i18n}</option>
        <option value="not_translated" {if $smarty.request.type == 'not_translated'}selected{/if}>{"Not translated"|i18n}</option>
    </select>&nbsp;
    {"Search"|i18n}:&nbsp;
    <input type="text" name="search" value="{$smarty.request.search}" />&nbsp;
    {"Search By"|i18n}:&nbsp;
    <select name="search_type">
        <option value="name" {if $smarty.request.search_type == 'name'}selected{/if}>{"Name"|i18n}</option>
        <option value="value" {if $smarty.request.search_type == 'value'}selected{/if}>{"Value"|i18n}</option>
    </select>&nbsp;

    <input type="submit" name="btnSubmit" value="{"Change Filter"|i18n}">
</form>

{include file="i_pager.tpl" max_page=$i18n_admin->get_translates_by_lang_pages($lang,$smarty.request.search,$smarty.request.search_type,$smarty.request.type,$per_page) request="search|per_page|a_id|a_sid|s|type|lang|search_type"}
<table align="center" width="100%" border="0">
    <tr>
        <td>{"ID"|i18n}</td>
        <td>{"Key"|i18n}</td>
        <td>{"Value"|i18n}</td>
        <td>{"Operation"|i18n}</td>
    </tr>

    {foreach from=$i18n_admin->get_translates_by_lang($lang,$smarty.request.search,$smarty.request.search_type,$smarty.request.type,$page,$per_page) item=translate}
        <tr>
            <td>{$translate.id}</td>
            <td>{$translate.name}</td>
            <td>{$translate.value|strip_tags|truncate:100:'...'}</td>
            <td>
                <a href="?ago=i18n_edit_key&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&id={$translate.id}&search={$smarty.request.search}&search_type={$smarty.request.search_type}&type={$smarty.request.type}&page={$smarty.request.page}&per_page={$smarty.request.per_page}&lang={$lang}">{"Edit"|i18n}</a>&nbsp;
                <a href="?action=i18n_delete&a_id={$smarty.request.a_id}&a_sid={$smarty.request.a_sid}&s={$s}&id={$translate.id}&page={$smarty.request.page}&per_page={$smarty.request.per_page}&search={$smarty.request.search}&search_type={$smarty.request.search_type}&type={$smarty.request.type}&lang={$lang}">{"Delete"|i18n}</a>
            </td>
        </tr>
        {foreachelse}
        <tr>
            <td colspan="4">{"No words"|i18n}</td>
        </tr>
    {/foreach}
</table>
{include file="i_pager.tpl" max_page=$i18n_admin->get_translates_by_lang_pages($lang,$smarty.request.search,$smarty.request.search_type,$smarty.request.type,$per_page) request="search|per_page|a_id|a_sid|s|type|lang|search_type"}