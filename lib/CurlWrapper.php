<?php

class CurlWrapper
{
    private $_ch;
    private $_dataOpt;
    private $_error;
    private $_errno;
    private $_res;
    private $_info;
    private $_errorLog = true;

    public function __construct() {
        $this->_clear();
    }

    private function _clear()
    {
        $this->_dataOpt = array();
        $this->_res = '';
        $this->_error = '';
        $this->_errno = 0;
        $this->_info = array();
    }

    public function init() {
        $this->_clear();
        $this->_ch = curl_init();
    }

    public function setOpt( $var, $val ) {
        $this->_dataOpt[$var] = $val;
    }

    public function execute() {
        foreach( $this->_dataOpt as $var => $val ) {
            curl_setopt( $this->_ch, $var, $val );
        };
        $this->_res = curl_exec( $this->_ch );
        $this->_error = curl_error( $this->_ch );
        $this->_errno = curl_errno( $this->_ch );
        if ($this->_errno && $this->_errorLog) {
            //TODO: LOG
            //error_log_format( 'CURL', $this->_errno, 'error: '.$this->_error.' host:'.@$_SERVER['HTTP_HOST'] );
        }
        $this->_info = curl_getinfo( $this->_ch );
        return $this->_res;
    }

    public function curlError() {
        return $this->_error;
    }

    public function curlGetInfo($par) {
        return $this->_info[$par];
    }

    public function curlGetInfoAll() {
        return $this->_info;
    }

    public function curlErrno() {
        return $this->_errno;
    }

    public function close() {
        curl_close( $this->_ch );
    }

    public function execProxy( $proxy_url ) {
        $data = $this->serialize();
        $cw_proxy = new CurlWrapper();
        $cw_proxy->init();
        $cw_proxy->setOpt( CURLOPT_URL, $proxy_url );
        $cw_proxy->setOpt( CURLOPT_HEADER, 0 );
        $cw_proxy->setOpt( CURLOPT_POST, 1 );
        $cw_proxy->setOpt( CURLOPT_FAILONERROR, 1 );
        $cw_proxy->setOpt( CURLOPT_HTTPHEADER, array('Content-Type: application/proxy-send') );
        $cw_proxy->setOpt( CURLOPT_RETURNTRANSFER, 1 );
        $cw_proxy->setOpt( CURLOPT_POSTFIELDS, $data );
        $res = $cw_proxy->execute();
        $cw_proxy->close();
        if( $cw_proxy->curlErrno() ) {
            $this->_error = 'proxy['.$proxy_url.']: '.$cw_proxy->curlError();
            $this->_errno = $cw_proxy->curlErrno();
            return $res;
        }
        $this->unserialize( $res );
        return $this->_res;
    }

    public function serialize(){
        return serialize( array(
                'data_opt'      => $this->_dataOpt,
                'res'           => $this->_res,
                'error'         => $this->_error,
                'errno'         => $this->_errno,
                'info'          => $this->_info,
            )
        );
    }

    public function unserialize( $data_cw ){
        $arr_cw = unserialize( $data_cw );
        $this->_dataOpt = $arr_cw['data_opt'];
        $this->_res = $arr_cw['res'];
        $this->_error = $arr_cw['error'];
        $this->_errno = $arr_cw['errno'];
        $this->_info = $arr_cw['info'];
        return true;
    }

    public function disableErrorLog(){
        $this->_errorLog = false;
    }
}
?>