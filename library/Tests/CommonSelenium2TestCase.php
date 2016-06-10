<?php

class Tests_CommonSelenium2TestCase extends PHPUnit_Extensions_Selenium2TestCase {
    protected $_db;

    public function setUp()
    {
        parent::setUp();
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://www.google.com/');

        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini');
        $dbConf = $config->toArray()['testing']['resources']['db'];
        $this->_db = Zend_Db::factory($dbConf['adapter'], $dbConf['params']);

    }

    public function loadSql($fileName) {
        $sqlDir = dirname(APPLICATION_PATH) . "/tests/sql/";
        $this->_db->query("SET foreign_key_checks = 0");
        $this->_db->query(file_get_contents("$sqlDir$fileName"));
        $this->_db->query("SET foreign_key_checks = 1");
    }

    public function printInElement($elId, $text, $clean = True) {
        if ($clean) {
            $this->byId($elId)->clear();
        }
        $this->clickOnElement($elId);
        $this->keys($text);
    }

    public function elementExistsById($id) {
        try {
            $this->byId($id);
        } catch(PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e) {
            return false;
        }
        return true;
    }

    public function clickWithSleep($elId, $sleep = 1) {
        $this->clickOnElement($elId);
        sleep($sleep);
    }

    public function url($url=NULL) {
        parent::url($url);
        $this->currentWindow()->maximize();
        sleep(1);
    }
}