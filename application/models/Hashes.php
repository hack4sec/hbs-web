<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
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