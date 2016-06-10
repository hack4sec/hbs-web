<?php

class Algs extends Common
{
    protected $_name = 'algs';

    public function getList() {
        return $this->getAdapter()->fetchPairs("SELECT id, name FROM {$this->_name} ORDER BY name ASC");
    }

}