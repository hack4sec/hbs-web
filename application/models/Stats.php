<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Stats
{
    protected $_db;

    public function __construct()
    {
        $this->_db = Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    public function getCommonStat() {
        return [
            'hashlists' => $this->_db->fetchOne("SELECT COUNT(id) FROM `hashlists` WHERE !common_by_alg"),
            'tasks' => $this->_db->fetchOne("SELECT COUNT(id) FROM `tasks`"),
            'task_works_done' => $this->_db->fetchOne("SELECT COUNT(id) FROM `task_works` WHERE status='done'"),
            'task_works_wait' => $this->_db->fetchOne("SELECT COUNT(id) FROM `task_works` WHERE status='wait'"),
            'tasks_groups' => $this->_db->fetchOne("SELECT COUNT(id) FROM `tasks_groups`"),
            'hashes_all' => $this->_db->fetchOne(
                "SELECT COUNT(h.id) FROM `hashes` h, `hashlists` hl
                 WHERE hl.id = h.hashlist_id AND  !hl.common_by_alg"
            ),
            'hashes_cracked' => $this->_db->fetchOne(
                "SELECT COUNT(h.id) FROM `hashes` h, `hashlists` hl
                 WHERE hl.id = h.hashlist_id AND !hl.common_by_alg AND h.cracked"
            ),
            'hashes_not_cracked' => $this->_db->fetchOne(
                "SELECT COUNT(h.id) FROM `hashes` h, `hashlists` hl
                 WHERE hl.id = h.hashlist_id AND !hl.common_by_alg AND !h.cracked"
            ),
            'dicts' => $this->_db->fetchOne("SELECT COUNT(id) FROM `dicts`"),
            'dicts_groups' => $this->_db->fetchOne("SELECT COUNT(id) FROM `dicts_groups`"),
            'algs_stat_all' => $this->_db->fetchPairs(
                "SELECT a.name, COUNT(h.id) FROM `hashes` h, `hashlists` hl, algs a
                 WHERE hl.id = h.hashlist_id AND !hl.common_by_alg AND a.id = hl.alg_id
                 GROUP BY a.id
                 ORDER BY COUNT(h.id) DESC"
            ),
            'algs_stat_cracked' => $this->_db->fetchPairs(
                "SELECT a.name, COUNT(h.id) FROM `hashes` h, `hashlists` hl, algs a
                 WHERE hl.id = h.hashlist_id AND !hl.common_by_alg AND a.id = hl.alg_id AND h.cracked
                 GROUP BY a.id
                 ORDER BY COUNT(h.id) DESC"
            ),
            'algs_stat_not_cracked' => $this->_db->fetchPairs(
                "SELECT a.name, COUNT(h.id) FROM `hashes` h, `hashlists` hl, algs a
                 WHERE hl.id = h.hashlist_id AND !hl.common_by_alg AND a.id = hl.alg_id AND !h.cracked
                 GROUP BY a.id
                 ORDER BY COUNT(h.id) DESC"
            ),
        ];
    }

}