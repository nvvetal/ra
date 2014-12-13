<?php

function smarty_modifier_bbcode($string)
{
	$string = internal_smarty_modifier_bbcode_linkify($string);

   	$string = preg_replace("/\n/i", "<br />", $string);
	$string = preg_replace("/\[b\]/i","<b>", $string);
	$string = preg_replace("/\[\/b\]/i","</b>", $string);
	$string = preg_replace("/\[i\]/i","<i>", $string);
	$string = preg_replace("/\[\/i\]/i","</i>", $string);
	$string = preg_replace("/\[u\]/i","<u>", $string);
	$string = preg_replace("/\[\/u\]/i","</u>", $string);

	$string = preg_replace("/\[center\]/i","<p style=\"text-align: center;\">", $string);
	$string = preg_replace("/\[\/center\]/i","</p>",$string);
	

	$string = preg_replace("/\[left\]/i","<p style=\"text-align: left;\">", $string);
	$string = preg_replace("/\[\/left\]/i","</p>", $string);	
	$string = preg_replace("/\[right\]/i","<p style=\"text-align: right;\">", $string);
	$string = preg_replace("/\[\/right\]/i","</p>", $string);
    $string = preg_replace("/\[s\]/i","<s>", $string);
    $string = preg_replace("/\[\/s\]/i","</s>", $string);

	$string = preg_replace("/\[url=([^\]]+)\](.*?)\[\/url\]/i","$1", $string);
	$string = preg_replace("/\[url\]([^\[]+)\[\/url\]/i","$1", $string);
	$string = preg_replace("/\[size=([^\]]+)\](.*?)\[\/size\]/i","<font size=\"$1\">$2</font>", $string);

	$string = preg_replace("/\[url\](.*?)\[\/url\]/i","<a href=\"$1\">$1</a>", $string);
	$string = preg_replace("/\[img\](.*?)\[\/img\]/i","<img src=\"$1\" />", $string);
	$string = preg_replace("/\[color=(.*?)\](.*?)\[\/color\]/i","<font color=\"$1\">$2</font>", $string);
	$string = preg_replace("/\[quote.*?\](.*?)\[\/quote\]/i","<span class=\"quoteStyle\">$1</span>&nbsp;", $string);
    #http://daringfireball.net/2010/07/improved_regex_for_matching_urls
	/*
    $pattern = '(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
    $string = preg_replace_callback("#$pattern#i", function($matches) {
        $input = $matches[1];
        $url = preg_match('!^https?://!i', $input) ? $input : "http://$input";
        return '<a href="' . $url . '">'.$url.'</a>';
    }, $string);
	*/
	return $string;
}

function internal_smarty_modifier_bbcode_linkify($text) {
	$url_pattern = '/# Rev:20100913_0900 github.com\/jmrware\/LinkifyURL
    # Match http & ftp URL that is not already linkified.
      # Alternative 1: URL delimited by (parentheses).
      (\()                     # $1  "(" start delimiter.
      ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $2: URL.
      (\))                     # $3: ")" end delimiter.
    | # Alternative 2: URL delimited by [square brackets].
      (\[)                     # $4: "[" start delimiter.
      ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $5: URL.
      (\])                     # $6: "]" end delimiter.
    | # Alternative 3: URL delimited by {curly braces}.
      (\{)                     # $7: "{" start delimiter.
      ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $8: URL.
      (\})                     # $9: "}" end delimiter.
    | # Alternative 4: URL delimited by <angle brackets>.
      (<|&(?:lt|\#60|\#x3c);)  # $10: "<" start delimiter (or HTML entity).
      ((?:ht|f)tps?:\/\/[a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]+)  # $11: URL.
      (>|&(?:gt|\#62|\#x3e);)  # $12: ">" end delimiter (or HTML entity).
    | # Alternative 5: URL not delimited by (), [], {} or <>.
      (                        # $13: Prefix proving URL not already linked.
        (?: ^                  # Can be a beginning of line or string, or
        | [^=\s\'"\]]          # a non-"=", non-quote, non-"]", followed by
        ) \s*[\'"]?            # optional whitespace and optional quote;
      | [^=\s]\s+              # or... a non-equals sign followed by whitespace.
      )                        # End $13. Non-prelinkified-proof prefix.
      ( \b                     # $14: Other non-delimited URL.
        (?:ht|f)tps?:\/\/      # Required literal http, https, ftp or ftps prefix.
        [a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]+ # All URI chars except "&" (normal*).
        (?:                    # Either on a "&" or at the end of URI.
          (?!                  # Allow a "&" char only if not start of an...
            &(?:gt|\#0*62|\#x0*3e);                  # HTML ">" entity, or
          | &(?:amp|apos|quot|\#0*3[49]|\#x0*2[27]); # a [&\'"] entity if
            [.!&\',:?;]?        # followed by optional punctuation then
            (?:[^a-z0-9\-._~!$&\'()*+,;=:\/?#[\]@%]|$)  # a non-URI char or EOS.
          ) &                  # If neg-assertion true, match "&" (special).
          [a-z0-9\-._~!$\'()*+,;=:\/?#[\]@%]* # More non-& URI chars (normal*).
        )*                     # Unroll-the-loop (special normal*)*.
        [a-z0-9\-_~$()*+=\/#[\]@%]  # Last char can\'t be [.!&\',;:?]
      )                        # End $14. Other non-delimited URL.
    /imx';
	$url_replace = '$1$4$7$10$13<!-- m --><a class="postlink" href="$2$5$8$11$14">$2$5$8$11$14</a><!-- m -->$3$6$9$12';
	return preg_replace($url_pattern, $url_replace, $text);
}
