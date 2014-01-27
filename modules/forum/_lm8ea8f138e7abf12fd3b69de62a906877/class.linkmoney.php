<?php

class linkmoney {
    
    var $_debug         = false; // система отладки, выводит ошибки(сообщения) на страницу
    var $_writeLog      = true; // отправляет ошибки(сообщения) на сервер, рекомендуется true
    var $_forceShowCode = true; // показывать код всем ip, рекомендуется false
    var $_updateTime    = 3600; // как часто выполнять апдейт данных (сек.), рекомендуется 3600
    var $_isCron        = false; // если забор данных происходит в планировщике задач
    var $_login         = 'kupilink';
    var $_httpHost      = 'raks.com.ua';
    var $_siteCharset   = 'UTF-8'; // ['UTF-8', 'WINDOWS-1251', ...]
    
    // параметры для пользователей линкобирж SAPE и LinkFeed
    var $_sapeHash      = '01a18051a25b5e2c01e71606e5c4f829';
    var $_linkfeedHash  = '3bb921218c844381aae93660e3a29d8d58e82928';
    
    // системные параметры
    var $_ver               = '1.1'; // версия
    var $_lmid              = ''; // ID пользователя системе linkmoney
    var $_server            = 'linkmoney.ru';
    var $_fetchRemoteType   = '';
    var $_socketTimeout     = 6;
    var $_dbPath            = ''; // путь к локальным данным пользователя
    var $_host              = '';
    var $_hostName          = '';
    var $_redirectUrl       = '';
    var $_requestUri        = '';
    var $_customRequestUri  = ''; // если данные отличаются от $_SERVER['REQUEST_URI']
    var $_linksArray        = array();
    var $_lastLinknumber    = 0; // при пакетном выводе ссылок
    var $_numLinks          = 0; // количество выводимых ссылок
    var $_pages             = array(); // страницы, конфиг файл
    var $_site              = array(); // параметры сайта, конфиг файл
    var $_sendMess          = true;
    var $_writeForce        = false;
    var $_pageEncoding      = '';
    

    function linkmoney($lmid, $options = null){
        $this->_lmid = $lmid;
        $this->_host = strtolower($this->_httpHost);
        if (ini_get('safe_mode') == '1' && $this->isTimeToGetPackage('timestamp_safemode')){
            $this->writeLog('get_package_fail', 'SAFE_MODE ON');
        }
        if (isset($options['request_uri']) && strlen($options['request_uri'])){
            $this->_customRequestUri = $options['request_uri'];
        }
        
        $this->_hostName=$this->getHostName($this->_host);
        if (is_array($_GET) && $_GET){
            $keys = array_keys($_GET);
            $this->_numLinks = $keys[0];
        }
        
        $this->_dbPath = dirname(__FILE__).'/data';
        
        $this->resetConfigData();
        $this->setRequestUri();
        $this->setLinksArray();
        $this->_pageEncoding = $this->_siteCharset;
    }
    
    
    
    /**
     * Забираем данные из конфига index.cfg
     *
     */
    function resetConfigData(){
        if (!is_file($this->_dbPath."/index.cfg")){
            $this->createCfgFromDB();
        }
        $data = $this->fetchLocalFile('index.cfg');
        $arr = @unserialize($data);
        if (is_array($arr)){
            $this->_pages = array_change_key_case( $arr['pages'], CASE_LOWER);
            $this->_site = $arr['site'];
            $this->_siteCharset = strtoupper(trim($this->_site['site_encoding']));
        }
    }
    
    function isTimeToGetPackage($filename = 'timestamp', $setnewtime = true){
        $timestampFile     = $this->_dbPath."/".$filename;
        $this->_writeForce = true;
        if (!is_file($timestampFile)){
            if ($fp=$this->fopenSafe($timestampFile, 'w')){
                fwrite($fp, time());
                fclose($fp);
            }
            $timestamp = 0;
        }else{
            $timestamp = trim($this->fetchLocalFile($filename));
        }
        if ((time()-$timestamp) > $this->_updateTime){
            if ($setnewtime && $fp=$this->fopenSafe($timestampFile, 'w')){
                fwrite($fp, time());
                fclose($fp);
            }
            return true;
        }
        return false;
    }
    
    function getPackage(){
        $this->updateOne();
    }
    
    function updateOne(){
        $isCreateCfg        = false;
        $this->_writeForce  = false;
        // Проверяем, нужно ли забирать пакет
        if ($md5 = $this->checkMd5()){ 
            // Забираем пакет
            //$data=$this->fetchRemoteFile($this->_login.'.'.$this->_server, $this->getPackagePath(false));
            $data=$this->fetchRemoteFile($this->_server, $this->getPackagePath(false));
            if (get_magic_quotes_runtime()) $data = stripslashes($data);
            $this->writeLog('get_package', 'Забрали пакет');
            
            // Проверяем целостность пакета
            if (md5($data)==$md5){
                // Пишем пакет в файл
                if (get_magic_quotes_runtime()) $data = addslashes($data);
                if ($fp=$this->fopenSafe($this->getPackagePath(true), 'w')){
                    fwrite($fp, $data);
                    fclose($fp);
                }
                if ($fp=$this->fopenSafe($this->_dbPath.'/md5', 'w')){
                    fwrite($fp, $md5);
                    fclose($fp);
                }
                
                // Открываем пакет
                $this->extractPackage();
                $isCreateCfg = true;
            }else{
                $this->writeLog('get_package_fail', 'md5 пакета отличается от нужной суммы');
            }
        }
        
        // 
        $domain = str_replace('http://', '', $this->_host);
        $domain = str_replace('www.', '', $domain);
        $charset = ($this->_siteCharset)?$this->_siteCharset:'utf-8';
        if ($this->_sapeHash && $this->isTimeToGetPackage('timestamp_sape', false)){
            // забираем данные из SAPE
            $data=$this->fetchRemoteFile('dispenser-01.sape.ru/', 'code.php?user='.$this->_sapeHash.'&host='.$domain.'&charset='.$charset);
            if (!$data){
                $data=$this->fetchRemoteFile('dispenser-02.sape.ru/', 'code.php?user='.$this->_sapeHash.'&host='.$domain.'&charset='.$charset);
            }
            if ($data && $fp=$this->fopenSafe($this->_dbPath.'/sape.data', 'w')){
                fwrite($fp, $data);
                fclose($fp);
                $isCreateCfg = true;
                $this->writeLog('get_sape', 'Забрали пакет из SAPE');
                $this->isTimeToGetPackage('timestamp_sape');
            }else{
                $this->writeLog('get_sape', 'Не можем забрать пакет из SAPE');
            }
        }
        if ($this->_linkfeedHash && $this->isTimeToGetPackage('timestamp_linkfeed')){
            // забираем данные из Linkfeed
            $data=$this->fetchRemoteFile('db.linkfeed.ru/', $this->_linkfeedHash.'/'.$domain.'/'.$charset);
            if ($fp=$this->fopenSafe($this->_dbPath.'/linkfeed.data', 'w')){
                fwrite($fp, $data);
                fclose($fp);
            }
            $isCreateCfg = true;
            $this->writeLog('get_linkfeed', 'Забрали пакет из LinkFeed');
        }
        
        if ($isCreateCfg){
            // Создаем .cfg файл из xml и БД
            $this->createCfgFromDB();
        }
    }
    
    // ---------------------------------------------
    //  проверяем md5 код 
    // ---------------------------------------------
    
    function checkMd5(){
        //$serverMd5 = trim($this->fetchRemoteFile($this->_login.'.'.$this->_server, $this->getPackageHashPath()));
        $serverMd5 = trim($this->fetchRemoteFile($this->_server, $this->getPackageHashPath()));
        $localMd5 = trim($this->fetchLocalFile('md5'));
        if (!$localMd5){
            $this->fopenSafe($this->_dbPath.'/md5', "w");
        }
        return ($serverMd5 == $localMd5)?false:$serverMd5;
    }
    
    function deleteMd5(){
        if (is_file($this->_dbPath.'/md5')){
            unlink($this->_dbPath.'/md5');
        }
    }
    
    
    // ---------------------------------------------
    //  Методы приема, распаковки и проверки архива
    // ---------------------------------------------
    
    function extractPackage(){
        $this->_writeForce = false;
        if (extension_loaded('zlib')){
            $filename   = $this->getPackagePath(true);
            //$hash       = $this->_delimiter;
            //$target_dir = $this->_dbPath;
            
            $FileOpen = $this->fopenSafe($filename, "rb"); if(!$FileOpen) return;
                fseek($FileOpen, -4, SEEK_END);
                $buf = fread($FileOpen, 4);
                if (get_magic_quotes_runtime()) $buf = stripslashes($buf);
                $GZFileSize = unpack("V", $buf);
                $GZFileSize = end($GZFileSize);
            fclose($FileOpen);
            
            $HandleRead = gzopen($filename, "rb");
            $content    = gzread($HandleRead, $GZFileSize);
            gzclose($HandleRead );
            
            if ($fp=$this->fopenSafe($this->_dbPath.'/links.xml', 'w')){
                fwrite($fp, $content);
                fclose($fp);
            }
        }else{
            $this->writeLog('get_package_fail', 'Не установлен ZLIB');
        }
    }
    
    
    /**
     * Функция для чтения XML, и БД Sape, LinkFeed на пользовательской стороне
     *
     */
    function createCfgFromDB(){
        $this->_writeForce  = false;
        if (!$fpw=$this->fopenSafe($this->_dbPath.'/index.cfg', 'w')){
            $this->writeLog('get_package_fail', 'Не удается записать в папу data');
            return;
        }
        
        if (!is_file($this->_dbPath.'/links.xml')){
            $this->deleteMd5();
            $this->getPackage();
        }
        
        $page_number = 1;
        $page_number = $this->setCfgLinkmoney($page_number);
        $page_number = $this->setCfgSape($page_number);
        $page_number = $this->setCfgLinkfeed($page_number);
        
        fwrite($fpw, serialize(array('site'=>$this->_site, 'pages'=>$this->_pages)));
        fclose($fpw);
        $this->resetConfigData();
    }
    
    
    
    function setCfgLinkmoney($page_number){
        $fContent = $this->fetchLocalFile('links.xml');
        list($xml, $sPages) = preg_split("/\[start_pages\]/", $fContent);
        
        $this->_pages = array();
        $aPages = explode("-----\n", $sPages);
        
        foreach ($aPages as $page){
            if (!trim($page)) continue;
            $links = explode("\n", $page);
            if (!is_array($links) || !$links) continue;
            $page_url = trim(array_shift($links));
            if (strpos($page_url, "url=")!==0) continue;
            
            $page_url = strtolower(substr($page_url, 4));
            $this->_pages[$page_url] = $page_number;
            
            $this->saveLinksToFile($links, $page_number, 'w');
            $page_number++;
        }
        
        $this->_site = array();
        
        preg_match("/<links_delimiter>(.*?)<\/links_delimiter>/i", $xml, $res);
        $this->_site['links_delimiter'] = (isset($res[1]))?$res[1]:" ";
        
        preg_match("/<site_encoding>(.*?)<\/site_encoding>/i", $xml, $res);
        $this->_site['site_encoding'] = (isset($res[1]))?$res[1]:" ";
        
        preg_match("/<sape_hash>(.*?)<\/sape_hash>/i", $xml, $res);
        $this->_site['sape_hash'] = (isset($res[1]))?$res[1]:"";
        
        preg_match("/<linkfeed_hash>(.*?)<\/linkfeed_hash>/i", $xml, $res);
        $this->_site['linkfeed_hash'] = (isset($res[1]))?$res[1]:"";
        
        $this->_site['code_props'] = array();
        preg_match("/<before_block>(.*?)<\/before_block>/i", $xml, $res);
        $this->_site['code_props']['before_block'] = (isset($res[1]))?$res[1]:" ";
        
        preg_match("/<after_block>(.*?)<\/after_block>/i", $xml, $res);
        $this->_site['code_props']['after_block'] = (isset($res[1]))?$res[1]:" ";
        
        preg_match("/<before_item>(.*?)<\/before_item>/i", $xml, $res);
        $this->_site['code_props']['before_item'] = (isset($res[1]))?$res[1]:" ";
        
        preg_match("/<after_item>(.*?)<\/after_item>/i", $xml, $res);
        $this->_site['code_props']['after_item'] = (isset($res[1]))?$res[1]:" ";
        
        preg_match("/<force_show_code>(.*?)<\/force_show_code>/i", $xml, $res);
        $this->_site['code_props']['force_show_code'] = (isset($res[1]))?$res[1]:1;
        
        $this->_site['sites_linkbrokers'] = array();
        preg_match_all("/<site_linkbroker>(.*?)<\/site_linkbroker>/i", $xml, $res);
        $sites_linkbrokers = (isset($res[1]))?$res[1]:array();
        foreach( $sites_linkbrokers as $site_linkbroker){
            $arr = array();
            
            preg_match("/<linkbroker_id>(.*?)<\/linkbroker_id>/i", $site_linkbroker, $res);
            if (!isset($res[1])) continue;
            $linkbroker_id = $res[1];
            
            preg_match_all("/<bot_data_ip>(.*?)<\/bot_data_ip>/i", $site_linkbroker, $res);
            $arr['bot_data_ips'] = (isset($res[1]))?$this->htmlspecialchars_decode_all($res[1]):array();
            
            preg_match("/<bot_data_code>(.*?)<\/bot_data_code>/i", $site_linkbroker, $res);
            $arr['bot_data_code'] = (isset($res[1]))?$this->htmlspecialchars_decode_all($res[1]):'';
            
            $this->_site['sites_linkbrokers'][$linkbroker_id] = $arr;
        }
        
        return $page_number;
    }
    
    function setCfgSape($page_number){
        if ($this->_sapeHash){
            $data = $this->fetchLocalFile('sape.data');
            $linkbrokerData = @unserialize($data);
            if (is_array($linkbrokerData)){
                foreach ($linkbrokerData as $page=>$links){
                    if (in_array($page, array('__sape_delimiter__', '__sape_new_url__', '__sape_ips__'))){ 
                        if ($page == '__sape_new_url__'){
                            $this->_site['sites_linkbrokers'][2]['bot_data_code'] = $links;
                        }
                        if ($page == '__sape_ips__'){
                            foreach ($links as $bot_data_ip){
                                $this->_site['sites_linkbrokers'][2]['bot_data_ips'][] = $bot_data_ip;
                            }
                        }
                        continue; 
                    }
                    $page = strtolower($this->_host.$page);
                    if (isset($this->_pages[$page])){
                        $curr_page_number = $this->_pages[$page];
                        $attr = 'a';
                    }else{
                        $curr_page_number = $page_number;
                        $this->_pages[$page] = $curr_page_number;
                        $attr = 'w';
                    }
                    $this->saveLinksToFile($links, $curr_page_number, $attr);
                    $page_number++;
                }
            }
        }
        return $page_number;
    }
    
    function setCfgLinkfeed($page_number){
        if ($this->_linkfeedHash){
            $data = $this->fetchLocalFile('linkfeed.data');
            $linkbrokerData = @unserialize($data);
            if (is_array($linkbrokerData)){
                foreach ($linkbrokerData as $page=>$links){
                    if (in_array($page, array('__linkfeed_robots__', '__linkfeed_delimiter__', '__linkfeed_after_text__', '__linkfeed_before_text__', '__linkfeed_start__', '__linkfeed_end__'))){ 
                        if ($page == '__linkfeed_start__'){
                            $this->_site['sites_linkbrokers'][3]['bot_data_code'] = $links;
                        }
                        if ($page == '__linkfeed_robots__'){
                            foreach ($links as $bot_data_ip){
                                $this->_site['sites_linkbrokers'][3]['bot_data_ips'][] = $bot_data_ip;
                            }
                        }
                        continue; 
                    }
                    $page = strtolower($this->_host.$page);
                    if (isset($this->_pages[$page])){
                        $curr_page_number = $this->_pages[$page];
                        $attr = 'a';
                    }else{
                        $curr_page_number = $page_number;
                        $this->_pages[$page] = $curr_page_number;
                        $attr = 'w';
                    }
                    $this->saveLinksToFile($links, $curr_page_number, $attr);
                    $page_number++;
                }
            }
        }
        return $page_number;
    }
    
    
    function saveLinksToFile($links, $page_number, $attr = 'w'){
        $this->_writeForce  = false;
        $sLinks = '';
        if (is_array($links)&&!empty($links)) {
	        foreach ($links as $link){
	            if (!$link=trim($link)) continue;
	            $sLinks .= $link."\n";
	        }
        }
        $sLinks = trim($sLinks);
        if ($fp=$this->fopenSafe($this->_dbPath.'/'.$page_number.'.html', $attr)){
            if ($attr == 'a') $sLinks = "\n".$sLinks;
            fwrite($fp, $sLinks);
            fclose($fp);
        }
    }
    
    
    function fetchRemoteFile($host, $path) {
        $old_error_handler = set_error_handler(array($this, 'myErrorHandler'));
        $this->_sendMess   = false;
        
        @ini_set('allow_url_fopen', 1);
        @ini_set('default_socket_timeout', $this->_socketTimeout);
        $data=false;
        
        if (
            $this->_fetchRemoteType == 'file_get_contents'
            ||
            (
                $this->_fetchRemoteType == ''
                &&
                function_exists('file_get_contents')
                &&
                ini_get('allow_url_fopen') == 1
            )
        ) {
            $this->_fetchRemoteType = 'file_get_contents';
            $data = file_get_contents('http://' . $host . $path );
        } elseif (
            $this->_fetchRemoteType == 'curl'
            ||
            (
                $this->_fetchRemoteType == ''
                &&
                function_exists('curl_init')
            )
        ) {
            $this->_fetchRemoteType = 'curl';
            if ($ch = curl_init()) {

                curl_setopt($ch, CURLOPT_URL,              'http://' . $host . $path);
                curl_setopt($ch, CURLOPT_HEADER,           false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,   true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,   $this->_socketTimeout);

                $data = curl_exec($ch);

                curl_close($ch);
            }

        } else {
            $this->_fetchRemoteType = 'socket';
            $buff = '';
            $fp = fsockopen($host, 80, $errno, $errstr, $this->_socketTimeout);
            if ($fp) {
                fputs($fp, "GET {$path} HTTP/1.0\r\nHost: {$host}\r\n\r\n");
                //fputs($fp, "User-Agent: {$user_agent}\r\n\r\n");
                while (!@feof($fp)) {
                    $buff .= fgets($fp, 128);
                }
                fclose($fp);

                $page = explode("\r\n\r\n", $buff);

                $data=$page[1];
            }

        }
        restore_error_handler();
        return $data;
    }
    
    function writeLog($act, $mess, $sendMess = true){
        if ($this->_debug){
            echo $this->iconvSafe("UTF-8", $this->_siteCharset, $mess."; <br/>\r\n");
        }
        $mess = str_replace("/", '\\', $mess);
        $mess = urlencode(trim(strip_tags(str_replace(array("\n", "\t"), " ", $mess))));
        if ($this->_writeLog && $sendMess){
            $path = '/default/index/client-code-log/login/'.$this->_login.'/lmid/'.$this->_lmid.'/act/'.$act.'/url/'.urlencode($this->_httpHost).'/mess/'.$mess;
            $this->fetchRemoteFile($this->_server, $path);
        }
    }
    
    function fetchLocalFile($file){
        $this->_writeForce  = false;
        $filename = $this->_dbPath.'/'.$file;
        $contents = '';
        
        if (is_file($filename) && filesize($filename)){
            $handle = $this->fopenSafe($filename, "rb");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
        }
        return $contents;
    }
    
    // ---------------------------------------------
    //  Методы формирующие пути
    // ---------------------------------------------
    
    function getPackagePath($local=false){
        if ($local){
            return $this->_dbPath.'/'.$this->_hostName.'.gz';
        }else{ 
            return $this->getServerUserPath().'/'.$this->_hostName.'.gz';
        }
    }
    
    function getPackageHashPath(){
        return $this->getServerUserPath().'/'.$this->_hostName.'md5';
    }
    
    // путь к данным пользователя на сервере linkmoney
    function getServerUserPath(){
        return '/data/users/'.$this->_login.'/'.$this->_lmid;
    }
    
    
    function getHostName($host){
        $host=strtolower($host);
        $host=str_replace('http://', '', $host);
        $host=str_replace('www.', '', $host);
        $host=str_replace('_', '__', $host);
        $host=str_replace('.', '_', $host);
    
        return $host;
    }
    
    
    
    // ---------------------------------------------
    //  Методы вывода ссылок на экран пользователя
    // ---------------------------------------------
    function getLinksSsi($num_links=0, $lastLinknumber=0, $requestUri='', $encoding = null){
        if ($requestUri){
            $pages_keys = array_keys($this->_pages);
            $this->_requestUri = $this->getRequestUri($requestUri, $pages_keys);
            $this->setLinksArray();
        }
        $this->_lastLinknumber = ($lastLinknumber)?$lastLinknumber:$this->_lastLinknumber;
        
        return $this->getLinks($num_links, $encoding);
    }
    
    
    function getLinks($num_links=0, $encoding = null){
        if (isset($_GET[$this->_lmid.'server'])){
            echo '<!--';print_r($_SERVER);echo '-->';
        }
        if ($encoding) $this->_pageEncoding = $encoding;
        $sHtml = '';
        if (!is_file($this->_dbPath.'/md5')){
            $this->getPackage();
        }
        if (!$this->_isCron && $this->isTimeToGetPackage('timestamp')){
            $this->getPackage();
        }
        $sCodes = $this->getCodes();
        $sHtml .= $sCodes;
        
        if(!is_array($this->_linksArray) || !$this->_linksArray){
            $this->setLinksArray();
            if(!is_array($this->_linksArray) || !$this->_linksArray){
                return $sHtml;
            }
        }
        
        if (!$num_links) $num_links = $this->_numLinks;
        $num_links = (int)$num_links;
        
        if($num_links && count($this->_linksArray)>$num_links){
            $links = array_slice($this->_linksArray, $this->_lastLinknumber, $num_links);
            $this->_lastLinknumber += $num_links;
        } else {
            $links = array_slice($this->_linksArray, $this->_lastLinknumber);
            $this->_lastLinknumber = count($this->_linksArray);
        }
        
        $links_delimiters = array();
        foreach ($links as $link){
            if ($this->_pageEncoding != $this->_siteCharset){
                $link= $this->iconvSafe($this->_siteCharset, $this->_pageEncoding, $link);
            }
            $link = trim($link);
            if (!$link) continue;
            $links_delimiters[] = $this->htmlspecialchars_decode_all($this->_site['code_props']['before_item']) 
                                  . $link
                                  . $this->htmlspecialchars_decode_all($this->_site['code_props']['after_item']);
        }
        
        $sHtml .= $this->htmlspecialchars_decode_all($this->_site['code_props']['before_block'])
               . implode($this->htmlspecialchars_decode_all($this->_site['links_delimiter']), $links_delimiters)
               . $this->htmlspecialchars_decode_all($this->_site['code_props']['after_block']);
        return $sHtml;
    }
    
    /**
     * Возвращает коды линкобирж для определенных IPs
     */
    function getCodes(){
        $remote_addr = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'';
        $remote_addr = (!$remote_addr && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$remote_addr;
        $user_agent  = (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'no';
        
        $lmCode = '<!--lm_php_ver='.$this->_ver.'-->';
        $sCodes = '';
        if (isset($this->_site['sites_linkbrokers']) && is_array($this->_site['sites_linkbrokers'])){
            foreach ($this->_site['sites_linkbrokers'] as $id=>$site_linkbroker){
                if ($id != 1 || !isset($site_linkbroker['bot_data_code'])) continue;
                $lmCode .= $site_linkbroker['bot_data_code'];
            }
            foreach ($this->_site['sites_linkbrokers'] as $id=>$site_linkbroker){
                if (!isset($site_linkbroker['bot_data_code'])) continue;
                $flag = false;
                if (isset($site_linkbroker['bot_data_ips']) && is_array($site_linkbroker['bot_data_ips']) && $site_linkbroker['bot_data_ips']){
                    if ($id == 1){
                        if (isset($site_linkbroker['bot_data_ips'][0]) && strpos(strtolower($user_agent), strtolower('mlbot.'.$site_linkbroker['bot_data_ips'][0]))!==false){
                            $flag = true;
                        }
                    }elseif ($id == 2){
                        if (   ($this->_sapeHash && isset($_COOKIE['sape_cookie']) && ($_COOKIE['sape_cookie'] == $this->_sapeHash))
                            || ($this->_site['sape_hash'] && isset($_COOKIE['sape_cookie']) && ($_COOKIE['sape_cookie'] == $this->_site['sape_hash']))
                            || (in_array($remote_addr, $site_linkbroker['bot_data_ips']))){
                            $flag = true;
                        }
                    }else{
                        if (in_array($remote_addr, $site_linkbroker['bot_data_ips'])){
                            $flag = true;
                        }
                    }
                }
                if ($flag || $this->_forceShowCode || $this->_site['code_props']['force_show_code']){
                    $sCodes .= ($id == 4)?$lmCode:$site_linkbroker['bot_data_code'];
                }
            }
        }
        return $sCodes;
    }
    
    function setLinksArray(){
        $linksArray = array();
        if (substr($this->_requestUri, mb_strlen($this->_requestUri)-1) == '/'){
            $request_uri2 = substr($this->_requestUri, 0, -1);
        }else{
            $request_uri2 = $this->_requestUri.'/';
        }
        if (substr($this->_redirectUrl, mb_strlen($this->_redirectUrl)-1) == '/'){
            $redirect_url2 = substr($this->_redirectUrl, 0, -1);
        }else{
            $redirect_url2 = $this->_redirectUrl.'/';
        }

        if (isset($this->_pages[$this->_requestUri])){
            $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[$this->_requestUri]).".html")));
        }
        if (isset($this->_pages[$request_uri2])){
            $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[$request_uri2]).".html")));
        }
        if (urlencode($this->_requestUri) != $this->_requestUri && isset($this->_pages[urlencode($this->_requestUri)])){
            $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[urlencode($this->_requestUri)]).".html")));
        }
        if (urlencode($request_uri2) != $request_uri2 && isset($this->_pages[urlencode($request_uri2)])){
            $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[urlencode($request_uri2)]).".html")));
        }
        if(!$linksArray){
            if (isset($this->_pages[$this->_redirectUrl])){
                $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[$this->_redirectUrl]).".html")));
            }
            if (isset($this->_pages[$redirect_url2])){
                $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[$redirect_url2]).".html")));
            }
            if (urlencode($this->_redirectUrl) != $this->_redirectUrl && isset($this->_pages[urlencode($this->_redirectUrl)])){
                $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[urlencode($this->_redirectUrl)]).".html")));
            }
            if (urlencode($redirect_url2) != $redirect_url2 && isset($this->_pages[urlencode($redirect_url2)])){
                $linksArray = array_merge($linksArray, explode("\n", $this->fetchLocalFile(intval($this->_pages[urlencode($redirect_url2)]).".html")));
            }
        }

        $linksArray = array_unique($linksArray);
        $this->_linksArray = $linksArray;
        return false;
    }
    
    function setRequestUri(){
        if (!is_array($this->_pages) || !$this->_pages){
            $this->_requestUri = '';
            return;
        }

        $flag           = true;
        $pages_keys     = array_keys($this->_pages);
        $request_uri    = '';
        $this->_redirectUrl = (isset($_SERVER['REDIRECT_URL']))?$this->getRequestUri($_SERVER['REDIRECT_URL'], $pages_keys):'';

        if (strlen($this->_customRequestUri)){
            $request_uri = $this->getRequestUri($this->_customRequestUri, $pages_keys);
        }
        
        if (!strlen($request_uri)){
            $request_uri = (isset($_SERVER['REQUEST_URI']))?$this->getRequestUri($_SERVER['REQUEST_URI'], $pages_keys):'';
        }
        if (!strlen($request_uri)){
            $request_uri = $this->_redirectUrl;
        }
        if (!strlen($request_uri)){
            $request_uri = (isset($_SERVER['REDIRECT_REQUEST_URI']))?$this->getRequestUri($_SERVER['REDIRECT_REQUEST_URI'], $pages_keys):'';
        }
        $this->_requestUri = strtolower($request_uri);
    }
    
    
    function getRequestUri($server_request_uri, $pages_keys){
        //if ($server_request_uri){
            $server_request_uri = strtolower($server_request_uri);
            $request_uri = $this->_host.$server_request_uri;
            if (in_array($request_uri, $pages_keys)) return strtolower($request_uri);
            if (substr($server_request_uri, mb_strlen($server_request_uri)-1) == '/'){
                $request_uri = $this->_host.substr($server_request_uri, 0, -1);
                if (in_array($request_uri, $pages_keys)) return strtolower($request_uri);
            }
        //}
        return '';
    }
    
    function htmlspecialchars_decode_all($string){
        $decode = $string;
        $decode = str_replace('&amp;', '&', $decode);
        $decode = str_replace('&quot;', '"', $decode);
        $decode = str_replace('&#039;', "'", $decode);
        $decode = str_replace('&lt;', '<', $decode);
        $decode = str_replace('&gt;', '>', $decode);
        
        return $decode;
    }
    
    function fopenSafe($file, $mode){
        $old_error_handler = set_error_handler(array($this, 'myErrorHandler'));
        $this->_sendMess   = true;
        $isError           = false;
        if (!$fpw=fopen($file, $mode)){
            $isError = true;
        }
        restore_error_handler();
        return $fpw;
    }
    
    
    function myErrorHandler($errno, $errstr, $errfile, $errline){
        $error = '';
        switch ($errno){
        case E_USER_ERROR:
            $error .= "ERROR [$errno] $errstr; ";
            $error .= "Fatal error on line $errline in file $errfile; ";
            $error .= "PHP " . PHP_VERSION . " (" . PHP_OS . "); ";
            break;
    
        case E_USER_WARNING:
            $error .= "WARNING [$errno] $errstr; ";
            break;
    
        case E_USER_NOTICE:
            $error .= "NOTICE [$errno] $errstr; ";
            break;
    
        default:
            $error .= "Unknown error type: [$errno] $errstr; ";
            break;
        }
        
        $error = trim($error);
        if ($error && strpos($error, 'Permission denied') === false){
            if ($this->_writeForce || $this->isTimeToGetPackage('timestamp_error')){
                $this->writeLog('get_package_fail', $error, $this->_sendMess);
            }
        }
        return $error;
    }
    
    function iconvSafe($from_charset, $to_charset, $str){
        if (function_exists('iconv')){
            $str = iconv($from_charset, $to_charset, $str);
        }elseif(function_exists('mb_convert_encoding')){
            $str = mb_convert_encoding($str, $to_charset, $from_charset);
        }
        return $str;
    }
    ////////////////////////////
    
}


$lm = new linkmoney("8ea8f138e7abf12fd3b69de62a906877");
