<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
abstract class Forms_Validate_Abstract extends Zend_Validate_Abstract {
    public function init() {
        parent::init();
        $this->setDefaultTranslator(Zend_Registry::get('Zend_Translate'));
    }
}