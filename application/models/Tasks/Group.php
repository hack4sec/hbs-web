<?php
class Tasks_Group extends Zend_Db_Table_Row {
    protected $_tableClass = 'Tasks_Groups';

    public function getTasks() {
        return (new Tasks())->getByGroupId($this->id);
    }
}