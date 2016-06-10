<?php

class Hashlist extends Zend_Db_Table_Row
{
    protected $_tableClass = 'Hashlists';

    private $_counts;
    public function getCounts() {
        if (!$this->_counts) {
            $Hashes = new Hashes();
            $this->_counts['cracked'] = $Hashes->getCountByHashlistId($this->id, 1);
            $this->_counts['not_cracked'] = $Hashes->getCountByHashlistId($this->id, 0);
        }
        return $this->_counts;
    }

    public function getAlg() {
        $Algs = new Algs();
        return $Algs->getList()[$this->alg_id];
    }

    public function getWorkTasks() {
        $WorkTasks = new WorkTasks();
        return $WorkTasks->getWorkTasksByHashlist($this->id);
    }
}