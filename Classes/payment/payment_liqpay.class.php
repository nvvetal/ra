<?php

//click and buy 1.2

class paymentLiqpay {
    private $domDocumentRequest;
    private $domDocumentResponse;
    private $domDocumentResponseData;
    private $domDocumentRequestRoot;
    private $dbh;
    
    private $requestRequiredParams = array(
            'version',
            'result_url',
            'server_url',
            'merchant_id',
            'order_id',
            'amount',
            'currency',
            'description',
            'default_phone',
            'pay_way',    
    );    
    
    public function __construct(){
        $this->domDocumentRequest = new DOMDocument('1.0','utf-8');
        $this->domDocumentResponse = new DOMDocument('1.0','utf-8');
        $this->domDocumentRequest->formatOutput = true;
        $this->domDocumentResponse->formatOutput = true;
        $this->_createRootNodeRequest();
    }
    
    public function setDbh($dbh){
        $this->dbh = $dbh;
    }
    
    private function _createRootNodeRequest(){
        $this->domDocumentRequestRoot = $this->domDocumentRequest->createElement('request');
        $this->domDocumentRequestRoot = &$this->domDocumentRequest->appendChild($this->domDocumentRequestRoot);
    }
    
    private function _getRootNodeRequest(){
        return $this->domDocumentRequestRoot;
    }
    
    private function _checkPaymentRequestParams($params){
        foreach ($this->requestRequiredParams as $key=>$name){
            if(!isset($params[$name])) return array(
                'ok'    =>  false,
                'error' =>  "request payment value $name not available!",
            );
        }
        return array('ok'=>true);
    }
    
    private function _checkPaymentRequestParam($name){
        if(in_array($name,$this->requestRequiredParams)) return true;
        return false;
    }
    
    public function getPaymentData($params){
        $validate = $this->_checkPaymentRequestParams($params);
        if($validate['ok'] == false) return $validate;
        
        $rootRequest = &$this->_getRootNodeRequest();
        foreach ($params as $name=>$value){     
            if($this->_checkPaymentRequestParam($name) == false) continue; 
            $item = $this->domDocumentRequest->createElement($name,$value);
            $rootRequest->appendChild($item); 
        }
        
        $xml = $this->domDocumentRequest->saveXML($rootRequest);
        
        $signatureParams = array(
            'merchantSignature' => $params['merchant_signature'],
            'xml'               => $xml,
        );
        
        $outParams = array(
            'ok'            => true,
            'xml'           => $xml,
            'operationXml'  => $this->_encodeOperationXml($xml),
            'signature'     => $this->_encodeSignature($signatureParams),
        );
        
        $paymentData = array(
            'order_id'=>$params['order_id'],
            'type'=>'out',
            'status'=>'INTERNAL:put',
            'status_code'=>'',
            'signature'=>$this->_encodeSignature($signatureParams),
            'sent'=>$xml,
            'action_time'=>time(),
        );

        $this->_saveTransaction($paymentData);

        return $outParams;
    }
    
    public function savePaymentData($params){
        //apply response in dom
        $this->_loadResponseData($params['operation_xml']);
        $order_id = $this->_isOrderSuccess($this->_getResponseParam('order_id'));
        //check is already success
        $isAlreadyPayed = $this->_isOrderSuccess($order_id);
        if($isAlreadyPayed) return array('ok'=>false,'error'=>'already payed','order_id'=>$order_id);
                
        //check signature
        $res = $this->_checkCrc($params);
               
        if($res['ok'] == false){        
            //save current data with error
            $paymentData = array(
                'order_id'=>$order_id,
                'type'=>'in',
                'status'=>'INTERNAL: crc',
                'status_code'=>'',
                'signature'=>$params['signature'],
                'got'=>$this->domDocumentResponse->saveXml(),
                'action_time'=>time(),
            );

            $this->_saveTransaction($paymentData);
            return $res;                    
        }

        
        //save data
        $paymentData = array(
            'order_id'=>$order_id,  
            'type'=>'in',  
            'status'=>$this->_getResponseParam('status'),   
            'status_code'=>$this->_getResponseParam('code'),   
            'signature'=>$params['signature'],   
            'got'=>$this->domDocumentResponse->saveXml(),   
            'action_time'=>time(),   
            'is_payed' => ($this->_getResponseParam('status') == 'success') ? 1 : 0,
        );
        
        $this->_saveTransaction($paymentData);
        
        //check status - if success - show ok
        if($this->_getResponseParam('status') != 'success'){
            return array('ok'=>false,'error'=>"status is ".$this->_getResponseParam('status'),'order_id'=>$order_id);
        }
        
        return array('ok'=>true,'order_id'=>$order_id);        
    }
    
    private function _isOrderSuccess($orderId){
        $query = "
            SELECT COUNT(*) as cnt
            FROM payment_liqpay
            WHERE order_id = ".SQLQuote($orderId)." AND is_payed = 1
            LIMIT 1
        ";
        
        $data = SQLGet($this->dbh);
        return ($data['cnt'] > 0) ? true : false;
    }
    
    private function _saveTransaction($params){
        SQLInsert('payment_liqpay',$params,$this->dbh);
        //file_put_contents('_saveTransaction.log',print_r($params,true),FILE_APPEND);
    }
    
    private function _getResponseParam($name){
        if(!is_array($this->domDocumentResponseData)){
            if($this->domDocumentResponse->getElementsByTagName("response")->item(0)->childNodes->length == 0) return false;
            foreach ($this->domDocumentResponse->getElementsByTagName("response")->item(0)->childNodes as $node){
               $this->domDocumentResponseData[$node->nodeName] = $node->nodeValue;
            }
        }
        
        return (isset($this->domDocumentResponseData[$name])) ? $this->domDocumentResponseData[$name] : false; 
    }
    
    private function _loadResponseData($xml){
        $xml = $this->_decodeOperationXml($xml);
        $this->domDocumentResponse->loadXml($xml);
    }
    
    private function _checkCrc($params){
        $xml = $this->_decodeOperationXml($params['operation_xml']);
        $crc_income = $params['signature'];
        $signatureParams = array(
            'merchantSignature' => $params['merchant_signature'],
            'xml'               => $xml,
        );
        $crc_real = $this->_encodeSignature($signatureParams);
        if($crc_real != $crc_income) return array('ok'=>false,'error'=>'Crc failed!');
        return array('ok'=>true);
    }
    
    private function _encodeOperationXml($xml){
        return base64_encode($xml);
    }
    
    private function _decodeOperationXml($xml){
        return base64_decode($xml);
    }    
    
    private function _encodeSignature($params){
        $sign=base64_encode(sha1($params['merchantSignature'].$params['xml'].$params['merchantSignature'],1));
        return $sign;
    }    
    
}

?>