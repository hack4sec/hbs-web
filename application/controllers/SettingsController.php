<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class SettingsController extends Zend_Controller_Action
{
    public function indexAction() {
        $this->view->settings = Utils::getSettings();
    }
    public function phpinfoAction() {
        phpinfo();
        exit;
    }
}