<?php

class PHPBB
{
    private $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public function checkHash($password, $hash)
    {
        if (strlen($hash) == 34)
        {
            return ($this->hashCryptPrivate($password, $hash) === $hash) ? true : false;
        }

        return (md5($password) === $hash) ? true : false;
    }

    private function hashCryptPrivate($password, $setting)
    {
        $output = '*';

        // Check for correct hash
        if (substr($setting, 0, 3) != '$H$')
        {
            return $output;
        }

        $count_log2 = strpos($this->itoa64, $setting[3]);

        if ($count_log2 < 7 || $count_log2 > 30)
        {
            return $output;
        }

        $count = 1 << $count_log2;
        $salt = substr($setting, 4, 8);

        if (strlen($salt) != 8)
        {
            return $output;
        }

        if (PHP_VERSION >= 5)
        {
            $hash = md5($salt . $password, true);
            do
            {
                $hash = md5($hash . $password, true);
            }
            while (--$count);
        }
        else
        {
            $hash = pack('H*', md5($salt . $password));
            do
            {
                $hash = pack('H*', md5($hash . $password));
            }
            while (--$count);
        }

        $output = substr($setting, 0, 12);
        $output .= $this->hashEncode64($hash, 16);
        return $output;
    }

    private function hashEncode64($input, $count)
    {
        $output = '';
        $i = 0;

        do
        {
            $value = ord($input[$i++]);
            $output .= $this->itoa64[$value & 0x3f];

            if ($i < $count)
            {
                $value |= ord($input[$i]) << 8;
            }

            $output .= $this->itoa64[($value >> 6) & 0x3f];

            if ($i++ >= $count)
            {
                break;
            }

            if ($i < $count)
            {
                $value |= ord($input[$i]) << 16;
            }

            $output .= $this->itoa64[($value >> 12) & 0x3f];

            if ($i++ >= $count)
            {
                break;
            }

            $output .= $this->itoa64[($value >> 18) & 0x3f];
        }
        while ($i < $count);

        return $output;
    }
}
