<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Algs extends Common
{
    protected $_name = 'algs';

    public function getList() {
        return $this->getAdapter()->fetchPairs("SELECT id, name FROM {$this->_name} ORDER BY name ASC");
    }

}