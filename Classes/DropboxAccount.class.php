<?php

class DropboxAccount
{

    protected $dbh;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * Getting all account which is not full
     * @return array
     */
    public function getAccountsBySize()
    {
        $q = "
            SELECT *
            FROM dropbox_accounts
            WHERE current_size < max_size - 20*1024*1024
            ORDER BY current_size ASC
        ";
        $rows = SQLGetRows($q, $this->dbh);
        return $rows;
    }

    /**
     * Getting first small account by size
     * @return null|string
     */
    public function getBestAccount()
    {
        $accounts = $this->getAccountsBySize();
        if(count($accounts) == 0) return NULL;
        return $accounts[0];
    }

    /**
     * Setting current size (normal + shared)
     * @param int $accountId
     * @param int $currentSize
     */
    public function setCurrentSize($accountId, $currentSize)
    {
        $fields = array(
            'current_size' => $currentSize,
        );
        SQLUpdate('dropbox_accounts', $fields, 'WHERE id='.SQLQuote($accountId), $this->dbh);
    }

    /**
     * Setting current size (normal + shared)
     * @param int $accountId
     * @param int $maxSize
     */
    public function setMaxSize($accountId, $maxSize)
    {
        $fields = array(
            'max_size' => $maxSize,
        );
        SQLUpdate('dropbox_accounts', $fields, 'WHERE id='.SQLQuote($accountId), $this->dbh);
    }

}