<?php

class PHPBB
{
    private $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public function checkHash($password, $hash)
    {
        if (strlen($hash) == 34) {
            return ($this->hashCryptPrivate($password, $hash) === $hash) ? true : false;
        }

        return (md5($password) === $hash) ? true : false;
    }

    private function hashCryptPrivate($password, $setting)
    {
        $output = '*';

        // Check for correct hash
        if (substr($setting, 0, 3) != '$H$') {
            return $output;
        }

        $count_log2 = strpos($this->itoa64, $setting[3]);

        if ($count_log2 < 7 || $count_log2 > 30) {
            return $output;
        }

        $count = 1 << $count_log2;
        $salt = substr($setting, 4, 8);

        if (strlen($salt) != 8) {
            return $output;
        }

        if (PHP_VERSION >= 5) {
            $hash = md5($salt . $password, true);
            do {
                $hash = md5($hash . $password, true);
            } while (--$count);
        } else {
            $hash = pack('H*', md5($salt . $password));
            do {
                $hash = pack('H*', md5($hash . $password));
            } while (--$count);
        }

        $output = substr($setting, 0, 12);
        $output .= $this->hashEncode64($hash, 16);
        return $output;
    }

    private function hashEncode64($input, $count)
    {
        $output = '';
        $i = 0;

        do {
            $value = ord($input[$i++]);
            $output .= $this->itoa64[$value & 0x3f];

            if ($i < $count) {
                $value |= ord($input[$i]) << 8;
            }

            $output .= $this->itoa64[($value >> 6) & 0x3f];

            if ($i++ >= $count) {
                break;
            }

            if ($i < $count) {
                $value |= ord($input[$i]) << 16;
            }

            $output .= $this->itoa64[($value >> 12) & 0x3f];

            if ($i++ >= $count) {
                break;
            }

            $output .= $this->itoa64[($value >> 18) & 0x3f];
        } while ($i < $count);

        return $output;
    }

    /**
     * @param $userId
     * @return string
     */
    public function sessionCreate($userId)
    {
        $dbh = Registry::get('DBFactory')->get_db_handle("forum");
        $lastSession = $this->sessionByUser($userId);
        $lastVisit = 0;
        if (!is_null($lastSession)) {
            $lastVisit = $lastSession['session_start'];
        }
        $this->sessionRemove($userId);
        $fields = array(
            'session_id' => md5($this->unique_id()),
            'session_user_id' => $userId,
            'session_last_visit' => $lastVisit,
            'session_start' => time(),
            'session_ip' => $_SERVER['REMOTE_ADDR'],
            'session_browser' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '',
            'session_forwarded_for' => '',
            'session_page' => 'index.php',
            'session_viewonline' => 1,
            'session_autologin' => 1,
            'session_admin' => 0,
            'session_forum_id' => 0,
        );

        SQLInsert('phpbb_sessions', $fields, $dbh);
        $lastSession = $this->sessionByUser($userId);
        return $lastSession['session_id'];
    }

    /**
     * @param $userId
     */
    public function sessionRemove($userId)
    {
        $dbh = Registry::get('DBFactory')->get_db_handle("forum");
        $q = 'DELETE FROM phpbb_sessions WHERE session_user_id=' . SQLQuote($userId);
        SQLQuery($q, $dbh);
    }

    /**
     * @param $userId
     * @return array|null
     */
    public function sessionByUser($userId)
    {
        $dbh = Registry::get('DBFactory')->get_db_handle("forum");
        $q = 'SELECT * FROM phpbb_sessions WHERE session_user_id=' . SQLQuote($userId);
        return SQLGet($q, $dbh);
    }


    /**
     * Return unique id
     * @return bool|string
     */
    public function unique_id()
    {
        $config = $this->getConfigs();
        $val = $config['rand_seed'] . microtime();
        $val = md5($val);
        return substr($val, 4, 16);
    }

    public function getConfigs()
    {
        $dbh = Registry::get('DBFactory')->get_db_handle("forum");
        $q = "SELECT * FROM phpbb_config";
        $rows = SQLGetRows($q, $dbh);
        $configs = array();
        foreach ($rows as $row) {
            $configs[$row['config_name']] = $row['config_value'];
        }
        return $configs;
    }

    public function setCookie($name, $cookiedata, $cookietime)
    {
        $config = $this->getConfigs();
        $name_data = rawurlencode($config['cookie_name'] . '_' . $name) . '=' . rawurlencode($cookiedata);
        $expire = gmdate('D, d-M-Y H:i:s \\G\\M\\T', $cookietime);
        $domain = (!$config['cookie_domain'] || $config['cookie_domain'] == 'localhost' || $config['cookie_domain'] == '127.0.0.1') ? '' : '; domain=' . $config['cookie_domain'];

        header('Set-Cookie: ' . $name_data . (($cookietime) ? '; expires=' . $expire : '') . '; path=' . $config['cookie_path'] . $domain . ((!$config['cookie_secure']) ? '' : '; secure') . '; HttpOnly', false);
    }

}
