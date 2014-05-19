<?php

class DropboxFiles
{
    protected $dbh;
    protected $dropbox;
    protected $dropboxAccount;

    public function __construct(Dropbox $dropbox, DropboxAccount $dropboxAccount, $dbh)
    {
        $this->dropbox = $dropbox;
        $this->dropboxAccount = $dropboxAccount;
        $this->dbh = $dbh;
    }

    public function saveFile($dropboxId, $attachmentId, $path, $imageType)
    {
        $fields = array(
            'dropbox_id'    => $dropboxId,
            'attachment_id' => $attachmentId,
            'path'          => $path,
            'imageType'     => $imageType,
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
        $destFile = $data['path'].'/'.$data['attachment_id'].'.'.$data['imageType'];
        $dropbox = $this->dropbox;
        $dropboxAccount = $this->dropboxAccount->getAccountById($data['dropbox_id']);
        $dropbox->setAccessToken($dropboxAccount['access_token']);
        $mediaData = $dropbox->getMedia($destFile);
        $length = '';
        $type = '';
        $imageData = '';
        header('Last-Modified: '.date('r'));
        header('Accept-Ranges: bytes');
        header('Content-Length: '.$length);
        header('Content-Type: '.$type);
        header("Cache-Control: max-age=3600");
        echo $imageData;
    }
}