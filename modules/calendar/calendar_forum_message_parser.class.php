<?php

class calendar_forum_message_parser
{
    private $bbcode_bitfield = '';
    private $bbcodes = NULL;

    public function __construct($message)
    {
//        var_dump($message);
        $this->bbcode_init();
        require_once('calendar_forum_bitfield.class.php');
        $bitfield = new calendar_forum_bitfield();
        foreach ($this->bbcodes as $bbcode_name => $bbcode_data)
        {
            foreach ($bbcode_data['regexp'] as $regexp => $replacement)
            {
                // The pattern gets compiled and cached by the PCRE extension,
                // it should not demand recompilation
                if (preg_match($regexp, $message))
                {
                    $bitfield->set($bbcode_data['bbcode_id']);
                }
            }
        }

        $this->bbcode_bitfield = $bitfield->get_base64();
    }

    /**
     * Init bbcode data for later parsing
     */
    function bbcode_init()
    {
        $this->bbcodes = array(
            'code'			=> array('bbcode_id' => 8,	'regexp' => array('#\[code(?:=([a-z]+))?\](.+\[/code\])#ise' => "\$this->bbcode_code('\$1', '\$2')")),
            'quote'			=> array('bbcode_id' => 0,	'regexp' => array('#\[quote(?:=&quot;(.*?)&quot;)?\](.+)\[/quote\]#ise' => "\$this->bbcode_quote('\$0')")),
            'attachment'	=> array('bbcode_id' => 12,	'regexp' => array('#\[attachment=([0-9]+)\](.*?)\[/attachment\]#ise' => "\$this->bbcode_attachment('\$1', '\$2')")),
            'b'				=> array('bbcode_id' => 1,	'regexp' => array('#\[b\](.*?)\[/b\]#ise' => "\$this->bbcode_strong('\$1')")),
            'i'				=> array('bbcode_id' => 2,	'regexp' => array('#\[i\](.*?)\[/i\]#ise' => "\$this->bbcode_italic('\$1')")),
            'url'			=> array('bbcode_id' => 3,	'regexp' => array('#\[url(=(.*))?\](.*)\[/url\]#iUe' => "\$this->validate_url('\$2', '\$3')")),
            'img'			=> array('bbcode_id' => 4,	'regexp' => array('#\[img\](.*)\[/img\]#iUe' => "\$this->bbcode_img('\$1')")),
            'size'			=> array('bbcode_id' => 5,	'regexp' => array('#\[size=([\-\+]?\d+)\](.*?)\[/size\]#ise' => "\$this->bbcode_size('\$1', '\$2')")),
            'color'			=> array('bbcode_id' => 6,	'regexp' => array('!\[color=(#[0-9a-f]{6}|[a-z\-]+)\](.*?)\[/color\]!ise' => "\$this->bbcode_color('\$1', '\$2')")),
            'u'				=> array('bbcode_id' => 7,	'regexp' => array('#\[u\](.*?)\[/u\]#ise' => "\$this->bbcode_underline('\$1')")),
            'list'			=> array('bbcode_id' => 9,	'regexp' => array('#\[list(?:=(?:[a-z0-9]|disc|circle|square))?].*\[/list]#ise' => "\$this->bbcode_parse_list('\$0')")),
            'email'			=> array('bbcode_id' => 10,	'regexp' => array('#\[email=?(.*?)?\](.*?)\[/email\]#ise' => "\$this->validate_email('\$1', '\$2')")),
            'flash'			=> array('bbcode_id' => 11,	'regexp' => array('#\[flash=([0-9]+),([0-9]+)\](.*?)\[/flash\]#ie' => "\$this->bbcode_flash('\$1', '\$2', '\$3')")),
            'youtube'	    => array('bbcode_id' => 13,	'regexp' => array('!\[youtube\]([a-zA-Z0-9-+.,_ ]+)\[/youtube\]!i' => "")),
            'hide'	        => array('bbcode_id' => 14,	'regexp' => array('!\[hide\](.*?)\[/hide\]!ies' => "")),
            'center'	    => array('bbcode_id' => 16,	'regexp' => array('!\[center\](.*?)\[/center\]!ies' => "")),
            'right'	        => array('bbcode_id' => 18,	'regexp' => array('!\[right\](.*?)\[/right\]!ies' => "")),
            's'	            => array('bbcode_id' => 19,	'regexp' => array('!\[s\](.*?)\[/s\]!ies' => "")),
        );
    }

    function get_bitfield()
    {
        return $this->bbcode_bitfield;
    }

    function add_bbcode_uid($bbcode_uid, $data)
    {
        $codes = array(
            '[quote=',
            '[/quote]',
            '[b]',
            '[/b]',
            '[i]',
            '[/i]',
//            '[url]',
//            '[/url]',
            '[img]',
            '[/img]',
//            '[size=',
            '[/size]',
            '[u]',
            '[/u]',
//            '[color=',
            '[/color]',
            '[center]',
            '[/center]',
            '[left]',
            '[/left]',
            '[right]',
            '[/right]',
            '[s]',
            '[/s]',
        );


        $data = $this->linkify($data);
        $replace = array(
            '[quote:'.$bbcode_uid.'=',
            '[/quote:'.$bbcode_uid.']',
            '[b:'.$bbcode_uid.']',
            '[/b:'.$bbcode_uid.']',
            '[i:'.$bbcode_uid.']',
            '[/i:'.$bbcode_uid.']',
//            '[url:'.$bbcode_uid.']',
//            '</a><!-- m -->',
            '[img:'.$bbcode_uid.']',
            '[/img:'.$bbcode_uid.']',
//            '[size:'.$bbcode_uid.'=',
            '[/size:'.$bbcode_uid.']',
            '[u:'.$bbcode_uid.']',
            '[/u:'.$bbcode_uid.']',
//            '[color:'.$bbcode_uid.'=',
            '[/color:'.$bbcode_uid.']',
            '[center:'.$bbcode_uid.']',
            '[/center:'.$bbcode_uid.']',
            '',
            '',
            '[right:'.$bbcode_uid.']',
            '[/right:'.$bbcode_uid.']',
            '[s:'.$bbcode_uid.']',
            '[/s:'.$bbcode_uid.']',
        );
        #http://daringfireball.net/2010/07/improved_regex_for_matching_urls
        /*
        $pattern = '(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
        $data = preg_replace_callback("#$pattern#i", function($matches) {
            $input = $matches[1];
            $url = preg_match('!^https?://!i', $input) ? $input : "http://$input";
            return '<!-- m --><a class="postlink" href="' . $url . '">'.$url.'</a><!-- m -->';
        }, $data);
        */
        $data = preg_replace('/\[url\]([^\[]+)\[\/url\]/ims', '<!-- m --><a class="postlink" href="$1">$1</a><!-- m -->', $data);
        $data = preg_replace('/\[url\=([^\[]+)\]([^\[]+)\[\/url\]/ims', '<!-- m --><a class="postlink" href="$1">$1</a><!-- m -->', $data);
        $data = str_replace($codes, $replace, $data);
        $data = preg_replace('/\[color\=(#[0-9a-f]{6}|[a-z\-]+)\]/ims', '[color=$1:'.$bbcode_uid.']', $data);
        $data = preg_replace('/\[size\=([0-9a-z]+)\]/ims', '[size=$1:'.$bbcode_uid.']', $data);
        return $data;
    }

    function linkify($text) {
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
}
