<?php

class Dicts_Groups extends Common
{
    protected $_rowClass = 'Dicts_Group';
    protected $_name = 'dicts_groups';

    public function exists($name) {
        return (bool)$this->fetchRow("name = {$this->getAdapter()->quote($name)}");
    }

    public function getList() {
        return $this->getAdapter()->fetchPairs(
            "SELECT id, name FROM {$this->_name} ORDER BY name ASC"
        );
    }
}