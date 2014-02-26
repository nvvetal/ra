<?php

function add_to_log($log_value,$log_prefix_name){

    $log_value .= '[s '.@$_REQUEST['s'].']';
    $log_value .= '[ip '.@$_SERVER['REMOTE_ADDR'].']';
    $log_value .= '[host '.@$_SERVER['HTTP_HOST'].']';
    $log_value .= '[ruri '.@$_SERVER['REQUEST_URI'].']';
    $log_value .= '[ua '.@$_SERVER['HTTP_USER_AGENT'].']';
    $log_value .= '[p '.@$_SERVER['REMOTE_PORT'].']';
    $log_value .= '[called '.called_from().']';

    $h=fopen($GLOBALS['LOG_DIR'].$log_prefix_name.".".date("Y-m-d").".log","a+");
    if($h){
        fwrite($h,"[".date("Y-m-d H:i:s")."] ".$log_value."\n");
    }
    fclose($h);
}

function called_from()
{
    $btrace = debug_backtrace();
    if( count($btrace) < 2 ) return '';
    return $btrace[1]['file'].' (line '.$btrace[1]['line'].')';
}


function prepare_array_to_log($values){
    if(!is_array($values)) return '';

    $str = '';

    foreach ($values as $key=>$value){
        $str .= "[$key $value]";
    }

    return $str;
}

function create_temp_file($fname,$fcontent){
    $h=fopen($GLOBALS['TMP_DIR'].$fname.".tmp","w");
    if($h){
        fwrite($h,$fcontent);
    }
    fclose($h);
}

function read_temp_file($fname){
    if(file_exists($GLOBALS['TMP_DIR'].$fname.".tmp")){
        @$fcontents = file_get_contents($GLOBALS['TMP_DIR'].$fname.".tmp");

        return $fcontents;

    }else{
        return false;
    }
}

function alert($str){
    if(is_array($str)) $str=var_export($str,true);
    $str=addslashes($str);
    $str=str_replace("\n","\\n",$str);
    echo "<script>alert('$str');</script>";
}

function transaction_process($name,$value,$dbh){
    $fields=array(
        "transaction_name"=>$name,
        "transaction_value"=>$value,
        "state"=>"in_process",
    );

    @SQLInsert("transaction_handler",$fields,$dbh);
}


function transaction_complete($name,$value,$dbh){
    $fields=array(
        "state"=>"complete",
    );

    SQLUpdate("transaction_handler",$fields,"WHERE transaction_name='$name' AND transaction_value='$value'",$dbh);
}

function is_transaction_complete($name,$value,$dbh){
    $query = "
		SELECT state
		FROM transaction_handler
		WHERE transaction_name='$name' AND transaction_value='$value'
		LIMIT 0,1
	";

    $result = SQLQuery($query,$dbh);

    $is_complete = false;

    if(SQLNumRows($result)){
        $is_complete = true;
    }

    return $is_complete;
}

function error_handler($errno, $errstr, $errfile , $errline)
{
    if ( error_reporting() & $errno ) {
        $errortype = array (
            E_ERROR              => 'PHP Error:',
            E_WARNING            => 'PHP Warning:',
            E_PARSE              => 'PHP Parsing Error:',
            E_NOTICE            => 'PHP Notice:',
            E_CORE_ERROR        => 'PHP Core Error:',
            E_CORE_WARNING      => 'PHP Core Warning:',
            E_COMPILE_ERROR      => 'PHP Compile Error:',
            E_COMPILE_WARNING    => 'PHP Compile Warning:',
            E_USER_ERROR        => 'User Error:',
            E_USER_WARNING      => 'User Warning:',
            E_USER_NOTICE        => 'User Notice:',
        );
        $log_string = (isset($errortype[$errno])?$errortype[$errno]:'UNKNOWN ERROR:')." $errstr in $errfile at line $errline";
        if ( ! empty($GLOBALS['CONFIG']['debug_to_stdout']) ) {
            print "$log_string<br/>\n";
        }
        $time = date("r");
        error_log_format('PHP',$errno,"$errstr in $errfile at line $errline");
        backtrace_to_log($log_string,'error_php');
    }
    return true;
}


function error_log_format($err, $type, $descr)
{
    $time = date("r");
    error_log("[$time][ERROR=$err][ETYPE=$type][$descr]");
}

function backtrace_to_log($message, $log_file='error_backtrace')
{
    $request_uri = $_SERVER['REQUEST_URI'];
    $req = array();
    foreach ($_REQUEST as $key => $value) {
        $req[] = "$key=$value";
    }
    $log = "$message\nREQUEST_URI: $request_uri\n_REQUEST: ".implode('&',$req)."\n";
    $backtrace = debug_backtrace();
    array_shift($backtrace);
    $cnt = count($backtrace);
    $stack = array();
    $loop = 0;
    foreach ($backtrace as $lvl) {
        if ($lvl['function'] == 'error_handler') {
            $cnt--;
            continue;
        }
        $args = $lvl['function']."()";
        if ( !empty($lvl['args']) ) {
            $args = $lvl['function']."(";
            $first = true;
            foreach ($lvl['args'] as $arg) {
                if (!$first) $args .= ',';
                $first = false;
                $args .= "'".strtr(serialize($arg),"\n",' ')."'";
            }
            if ( strlen($args) > 255 ) {
                $args = substr($args,0,255).'...';
            }
            $args .= ")";
        }
        $loop++;
        $stack []= "#".($cnt - $loop)." $args (".(isset($lvl['file'])?$lvl['file']:'UNKNOWN FILE').":".(isset($lvl['line'])?$lvl['line']:'UNKNOWN LINE').")";
    }
    $log .= implode("\n",$stack);
    $log = explode("\n",$log);
    add_to_log('====================NEW ENTRY====================', $log_file);
    foreach ($log as $value) {
        add_to_log($value, $log_file);
    }
    return true;
}

function exception_handler(Exception $e){
    $error = $e->getMessage();
    $trace = $e->getTrace();
    add_to_log("[error $error][file {$trace[0]['file']}][line {$trace[0]['line']}][function {$trace[0]['function']}][class {$trace[0]['class']}][from ".$_SERVER['REQUEST_URI']."]", "error_exception");
}

function get_raks_money_name($amount)
{
    $name = 'ракcов';

    if($amount % 10 == 0){
        $name = 'раксов';
        return $name;
    }

    if($amount % 2 == 0 || $amount % 3 == 0){
        $name = 'ракса';
        return $name;
    }

    if(substr($amount, -1)){
        $name = 'ракс';
        return $name;
    }

    return $name;
}

function getMetaURL($s)
{
    $metaURL = substr($GLOBALS['HTTP_PROJECT_ROOT'],0,-1).$_SERVER['REQUEST_URI'];
    $metaURL = str_replace('s='.$s, '', $metaURL);
    return $metaURL;
}