{"LFM"|i18n}<input type="text" name="{$name|default:'lfm'}" value="{$value|default:''}" />
{"Phone"|i18n}<input type="text" name="phone[]" value="{$phone_value}" />{if $delete_url ne ''} <a href="#" onclick="{$delete_url}">{"Delete LFM"|i18n}</a>{/if}