<?php
class Dicts_Group extends Zend_Db_Table_Row {
    protected $_tableClass = 'Dicts_Groups';

    public function getDicts() {
        return (new Dicts())->getByGroupId($this->id);
    }
}