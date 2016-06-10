<?php

class Stats
{
    protected $_db;

    public function __construct()
    {
        $this->_db = Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    public function getCommonStat() {
        return [
            'hashlists' => $this->_db->fetchOne("SELECT COUNT(id) FROM `hashlists`"),
            'tasks' => $this->_db->fetchOne("SELECT COUNT(id) FROM `tasks`"),
            'task_works_done' => $this->_db->fetchOne("SELECT COUNT(id) FROM `task_works` WHERE status='done'"),
            'task_works_wait' => $this->_db->fetchOne("SELECT COUNT(id) FROM `task_works` WHERE status='wait'"),
            'tasks_groups' => $this->_db->fetchOne("SELECT COUNT(id) FROM `tasks_groups`"),
            'hashes_all' => $this->_db->fetchOne("SELECT COUNT(id) FROM `hashes`"),
            'hashes_cracked' => $this->_db->fetchOne("SELECT COUNT(id) FROM `hashes` WHERE cracked"),
            'hashes_not_cracked' => $this->_db->fetchOne("SELECT COUNT(id) FROM `hashes` WHERE !cracked"),
            'dicts' => $this->_db->fetchOne("SELECT COUNT(id) FROM `dicts`"),
            'dicts_groups' => $this->_db->fetchOne("SELECT COUNT(id) FROM `dicts_groups`"),
        ];
    }

}