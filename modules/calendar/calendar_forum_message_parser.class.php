<?php

class calendar_forum_message_parser
{
    private $bbcode_bitfield = '';
    private $bbcodes = NULL;

    public function __construct($message)
    {

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
            'flash'			=> array('bbcode_id' => 11,	'regexp' => array('#\[flash=([0-9]+),([0-9]+)\](.*?)\[/flash\]#ie' => "\$this->bbcode_flash('\$1', '\$2', '\$3')"))
        );
    }

    function get_bitfield()
    {
        return $this->bbcode_bitfield;
    }

    function add_bbcode_uid($bbcode_uid, $message)
    {
        $codes = array(
            '[quote=',
            '[/quote]',
            '[b]',
            '[/b]',
            '[i]',
            '[/i]',
            '[url=',
            '[/url]',
            '[img]',
            '[/img]',
            '[size=',
            '[/size]',
            '[u]',
            '[/u]',
            '[color=',
            '[/color]',
        );
        $replace = array(
            '[quote:'.$bbcode_uid.'=',
            '[/quote:'.$bbcode_uid.']',
            '[b:'.$bbcode_uid.']',
            '[/b:'.$bbcode_uid.']',
            '[i:'.$bbcode_uid.']',
            '[/i:'.$bbcode_uid.']',
            '[url:'.$bbcode_uid.'=',
            '[/url:'.$bbcode_uid.']',
            '[img:'.$bbcode_uid.']',
            '[/img:'.$bbcode_uid.']',
            '[size:'.$bbcode_uid.'=',
            '[/size:'.$bbcode_uid.']',
            '[u:'.$bbcode_uid.']',
            '[/u:'.$bbcode_uid.']',
            '[color:'.$bbcode_uid.'=',
            '[/color:'.$bbcode_uid.']',
        );
        return str_replace($codes, $replace, $message);
    }
}

?>