<?php

class Rules extends Common
{
    protected $_name = 'rules';

    public function getList() {
        return $this->getAdapter()->fetchPairs(
            "SELECT id, name FROM {$this->_name} ORDER BY name ASC"
        );
    }

    public function exists($name) {
        return (bool)$this->fetchRow("name = {$this->getAdapter()->quote($name)}");
    }

    public function add($data) {
        $config = Zend_Registry::get('config');
        $data['hash'] = md5(time());

        copy(
            $config->paths->storage->tmp . "/{$data['filename']}",
            $config->paths->storage->rules . "/{$data['hash']}"
        );
        unlink($config->paths->storage->tmp . "/{$data['filename']}");

        $data['count'] = $this->_strsCount($config->paths->storage->rules . "/{$data['hash']}");

        parent::add($data);
    }

    private function _strsCount($path) {
        $count = 0;

        $fh = fopen($path, 'r');
        while (!feof($fh)) {
            $_tmp = fread($fh, 1024);
            $count += substr_count($_tmp, "\n");
        }
        fclose($fh);

        if (substr($_tmp, strlen($_tmp)-1) != "\n") {
            $count++;
        }

        return $count;
    }
}