<?php

abstract class Tests_CommonControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase {
    protected $_db;
    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->_db = Zend_Db_Table_Abstract::getDefaultAdapter();
    }

    public function loadSql($fileName) {
        $sqlDir = dirname(APPLICATION_PATH) . "/tests/sql/";
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $db->query("SET foreign_key_checks = 0");
        $db->query(file_get_contents("$sqlDir$fileName"));
        $db->query("SET foreign_key_checks = 1");
    }
} 