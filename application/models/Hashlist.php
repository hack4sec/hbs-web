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
            $this->_counts['cracked_percents'] = $this->_counts['not_cracked'] ?
                                                 round($this->_counts['cracked'] / ($this->_counts['not_cracked']+$this->_counts['cracked']) * 100, 1) :
                                                 0;
            $this->_counts['not_cracked_percents'] =  $this->_counts['not_cracked'] ? 100 - $this->_counts['cracked_percents'] : 0;
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