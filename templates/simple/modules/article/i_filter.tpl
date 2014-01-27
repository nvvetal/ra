<div class="article-container article-container-filters">
    <form id="filter" method="GET" action="index.php">
        {"Order by"|i18n}
        <select name="sort_by">
            <option value="author" {if $smarty.request.sort_by eq 'author'}selected{/if}>{"sort_author"|i18n}</option>
            <option value="date"" {if $smarty.request.sort_by eq 'date'}selected{/if}>{"sort_date"|i18n}</option>
            <option value="name"" {if $smarty.request.sort_by eq 'name'}selected{/if}>{"sort_name"|i18n}</option>
        </select>
        <select name="sort_order">
            <option value="inc"" {if $smarty.request.sort_order eq 'inc'}selected{/if}>{"sort_inc"|i18n}</option>
            <option value="dec" {if $smarty.request.sort_order eq 'dec'}selected{/if}>{"sort_dec"|i18n}</option>
        </select>
        <input type="submit" name="btn_submit" value="{"Search"|i18n}" />
        <input type="hidden" name="s" value="{$s}" />
        <input type="hidden" name="go" value="list" />
        <input type="hidden" name="section_id" value="{$smarty.request.section_id}" />
    </form>
</div>