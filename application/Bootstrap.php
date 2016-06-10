<?php

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

