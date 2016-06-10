<?php

class Hashes extends Zend_Db_Table_Abstract
{
    protected $_name = 'hashes';

    public function getCountByHashlistId($id, $cracked = false) {
        return $this->getAdapter()->fetchOne(
            "SELECT COUNT(id) FROM {$this->_name} WHERE hashlist_id = $id " .
            (($cracked !== false) ? " AND cracked = $cracked" : "")
        );
    }
}