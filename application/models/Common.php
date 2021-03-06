<?php

/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Common extends Zend_Db_Table_Abstract
{
    public function get($id) {
        return $this->find($id)->current();
    }

    public function add($data) {
        $row = $this->createRow($data);
        $row->save();
        return $row;
    }

    public function edit($data) {
        $this->get($data['id'])->setFromArray($data)->save();
    }
}