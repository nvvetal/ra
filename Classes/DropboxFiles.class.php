<?php

class DropboxFiles
{
    protected $dbh;

    public function __construct($dbh)
    {
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
        SQLInsert('dropbox_items', $fields, $this->dbh);
    }
}