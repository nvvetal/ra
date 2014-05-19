<?php

class DropboxFiles
{
    protected $dbh;
    protected $dropbox;
    protected $dropboxAccount;
    protected $curl;

    public function __construct(Dropbox $dropbox, DropboxAccount $dropboxAccount, CurlWrapper $curl, $dbh)
    {
        $this->dropbox = $dropbox;
        $this->dropboxAccount = $dropboxAccount;
        $this->curl = $curl;
        $this->dbh = $dbh;
    }

    public function saveFile($dropboxId, $attachmentId, $path, $imageType)
    {
        $fields = array(
            'dropbox_id'    => $dropboxId,
            'attachment_id' => $attachmentId,
            'path'          => $path,
            'image_type'    => $imageType,
            'created_time'  => time(),
        );
        return SQLInsert('dropbox_items', $fields, $this->dbh);
    }

    public function getFileData($fileId)
    {
        $q = "
            SELECT *
            FROM dropbox_items
            WHERE id = ".SQLQuote($fileId)."
        ";
        $row = SQLGet($q, $this->dbh);
        return !isset($row['id']) ? NULL : $row;
    }

    public function showFile($fileId)
    {
        $data = $this->getFileData($fileId);
        if(is_null($data)) throw new Exception('No file '.$fileId);
        $destFile = $data['path'].'/'.$data['attachment_id'].'.'.$data['image_type'];
        $dropbox = $this->dropbox;
        $dropboxAccount = $this->dropboxAccount->getAccountById($data['dropbox_id']);
        $dropbox->setAccessToken($dropboxAccount['access_token']);
        $mediaData = $dropbox->getMedia($destFile);
        if(is_null($mediaData))  throw new Exception('No meta for '.$fileId);
        $curl = $this->curl;
        $curl->init();
        $curl->setOpt(CURLOPT_URL, $mediaData['url']);
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
        if($code != 200) throw new Exception($data['error'], $code);
        $curl->close();
        $length = strlen($res);
        $type = '';
        header('Last-Modified: '.date('r'));
        header('Accept-Ranges: bytes');
        header('Content-Length: '.$length);
        header('Content-Type: '.$type);
        header("Cache-Control: max-age=3600");
        echo $res;
    }
}