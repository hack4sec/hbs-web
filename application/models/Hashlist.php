<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Hashlist extends Zend_Db_Table_Row
{
    protected $_tableClass = 'Hashlists';
    private $_counts;

    public function getCounts() {
        if (!$this->_counts) {
            $this->_counts['cracked'] = $this->cracked;
            $this->_counts['not_cracked'] = $this->uncracked;
            $this->_counts['cracked_percents'] = $this->uncracked ?
                                                 round($this->cracked / ($this->uncracked + $this->cracked) * 100, 1) :
                                                 0;
            $this->_counts['not_cracked_percents'] =  $this->uncracked ? 100 - $this->_counts['cracked_percents'] : 0;
        }
        return $this->_counts;
    }

    public function getAlg() {
        return (new Algs())->getList()[$this->alg_id];
    }

    public function getWorkTasks() {
        return (new WorkTasks())->getWorkTasksByHashlist($this->id);
    }

    public function delete() {
        foreach((new WorkTasks())->getWorkTasksByHashlist($this->id) as $task) {
            $task->delete();
        }
        parent::delete();
    }
}