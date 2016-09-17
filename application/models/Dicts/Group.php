<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Dicts_Group extends Zend_Db_Table_Row {
    protected $_tableClass = 'Dicts_Groups';

    public function getDicts() {
        return (new Dicts())->getByGroupId($this->id);
    }
}