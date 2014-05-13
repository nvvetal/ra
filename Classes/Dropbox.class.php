<?php

class Dropbox
{
    protected $curl;
    protected $accessToken;
    protected $error;
    protected $errorCode;
    protected $root = 'dropbox';

    public function __construct(CurlWrapper $curl)
    {
        $this->curl = $curl;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $root
     * @return bool
     */
    public function setRoot($root)
    {
        if(!in_array($root, array('sandbox', 'dropbox'))) return false;
        $this->root = $root;
        return true;
    }

    public function getErrorInfo()
    {
        return array(
            'message'   => $this->error,
            'code'      => $this->errorCode,
        );
    }

    /**
     * Returning Account info
     * @return array|null
     */
    public function getAccountInfo()
    {
        $url = 'https://api.dropbox.com/1/account/info?access_token='.$this->accessToken;
        $data = NULL;
        try {
            $curl = $this->curl;
            $curl->init();
            $curl->setOpt(CURLOPT_URL, $url);
            $curl->setOpt(CURLOPT_HEADER, 0);
            $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 5);
            $curl->setOpt(CURLOPT_TIMEOUT, 5);
            $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
            $res = $curl->execute();
            $error = $curl->curlError();
            if(!empty($error)) throw new Exception($error, $curl->curlErrno());
            $curl->close();
            $data = json_decode($res, true);
        }catch(Exception $e){
            $this->error = $e->getMessage();
            $this->errorCode = $e->getCode();
        }
        return $data;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function createFolder($path)
    {
        $url = 'https://api.dropbox.com/1/fileops/create_folder?access_token='.$this->accessToken;
        $postData = array(
            'root'  => $this->root,
            'path'  => $path,
        );
        $post = http_build_query($postData);
        $ret = false;
        try {
            $curl = $this->curl;
            $curl->init();
            $curl->setOpt(CURLOPT_URL, $url);
            $curl->setOpt(CURLOPT_HEADER, 0);
            $curl->setOpt(CURLOPT_POST, true);
            $curl->setOpt(CURLOPT_POSTFIELDS, $post);
            $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 5);
            $curl->setOpt(CURLOPT_TIMEOUT, 5);
            $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
            $res = $curl->execute();
            $error = $curl->curlError();
            if(!empty($error)) throw new Exception($error, $curl->curlErrno());
            $code = $curl->curlGetInfo('http_code');
            $data = json_decode($res, true);
            if($code != 200) throw new Exception($data['error'], $code);
            $curl->close();
            $ret = true;
        }catch(Exception $e){
            $this->error = $e->getMessage();
            $this->errorCode = $e->getCode();
            if($this->errorCode == 403) $ret = true;
        }
        return $ret;
    }

    /**
     * @param string $destFilename
     * @param string $localFilename
     * @return array|null
     */
    public function storeFile($destFilename, $localFilename)
    {
        $url = 'https://api-content.dropbox.com/1/files_put/'.$this->root.'/'.$destFilename.'?access_token='.$this->accessToken;
        $ret = null;
        try {
            $curl = $this->curl;
            $curl->init();
            $curl->setOpt(CURLOPT_URL, $url);
            $curl->setOpt(CURLOPT_HEADER, 0);
            $curl->setOpt(CURLOPT_PUT, true);
            $curl->setOpt(CURLOPT_INFILE, fopen($localFilename, 'r'));
            $curl->setOpt(CURLOPT_INFILESIZE, filesize($localFilename));
            $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 3600);
            $curl->setOpt(CURLOPT_TIMEOUT, 3600);
            $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
            $res = $curl->execute();
            $error = $curl->curlError();
            if(!empty($error)) throw new Exception($error, $curl->curlErrno());
            $code = $curl->curlGetInfo('http_code');
            $data = json_decode($res, true);
            if($code != 200) throw new Exception($data['error'], $code);
            $curl->close();
            $ret = $data;
        }catch(Exception $e){
            $this->error = $e->getMessage();
            $this->errorCode = $e->getCode();
        }
        return $ret;
    }

    /**
     * @param $destFilename
     * @param array $params
     * @return array|null
     */
    public function getMetadata($destFilename, array $params = array())
    {
        $params = http_build_query($params);
        $url = 'https://api.dropbox.com/1/metadata/'.$this->root.'/'.$destFilename.'?access_token='.$this->accessToken.'&'.$params;
        $ret = null;
        try {
            $curl = $this->curl;
            $curl->init();
            $curl->setOpt(CURLOPT_URL, $url);
            $curl->setOpt(CURLOPT_HEADER, 0);
            $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 3600);
            $curl->setOpt(CURLOPT_TIMEOUT, 3600);
            $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
            $res = $curl->execute();
            $error = $curl->curlError();
            if(!empty($error)) throw new Exception($error, $curl->curlErrno());
            $code = $curl->curlGetInfo('http_code');
            $data = json_decode($res, true);
            if($code != 200) throw new Exception($data['error'], $code);
            $curl->close();
            $ret = $data;
        }catch(Exception $e){
            $this->error = $e->getMessage();
            $this->errorCode = $e->getCode();
        }
        return $ret;
    }

    /**
     * @param $destFilename
     * @param array $params
     * @return array|null
     */
    public function getMedia($destFilename, array $params = array())
    {
        $params = http_build_query($params);
        $url = 'https://api.dropbox.com/1/media/'.$this->root.'/'.$destFilename.'?access_token='.$this->accessToken.'&'.$params;
        $ret = null;
        try {
            $curl = $this->curl;
            $curl->init();
            $curl->setOpt(CURLOPT_URL, $url);
            $curl->setOpt(CURLOPT_HEADER, 0);
            $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 5);
            $curl->setOpt(CURLOPT_TIMEOUT, 5);
            $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
            $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
            $res = $curl->execute();
            $error = $curl->curlError();
            if(!empty($error)) throw new Exception($error, $curl->curlErrno());
            $code = $curl->curlGetInfo('http_code');
            $data = json_decode($res, true);
            if($code != 200) throw new Exception($data['error'], $code);
            $curl->close();
            $ret = $data;
        }catch(Exception $e){
            $this->error = $e->getMessage();
            $this->errorCode = $e->getCode();
        }
        return $ret;
    }


}