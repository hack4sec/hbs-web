<?php

/**
 * Created by PhpStorm.
 * User: anton
 * Date: 10.10.16
 * Time: 15:51
 */
class Dict extends Zend_Db_Table_Row
{
    protected $_tableClass = 'Dicts';

    public function delete()
    {
        $config = Zend_Registry::get('config');
        unlink("{$config->paths->storage->dicts}/{$this->hash}.dict");
        return parent::delete();
    }
}