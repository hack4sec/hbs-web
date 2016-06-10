<?php

/**
 * Created by PhpStorm.
 * User: anton
 * Date: 15.01.16
 * Time: 18:28
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