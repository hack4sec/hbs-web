<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function preDispatch() {
        $this->bootstrap('frontController');
        $req = $this->frontController->getRequest();
    }

    public function _initTranslator() {
        $translator = new Zend_Translate(
            [
                'adapter' => 'array',
                'content' => APPLICATION_PATH.'/translates/',
                'locale' => Zend_Registry::get('config')->locale,
                'scan' => Zend_Translate::LOCALE_FILENAME
            ]
        );

        Zend_Form::setDefaultTranslator($translator);
        Zend_Registry::set('Zend_Translate', $translator);
    }
}

