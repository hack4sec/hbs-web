<?php
abstract class Forms_Validate_Abstract extends Zend_Validate_Abstract {
    public function init() {
        parent::init();
        $this->setDefaultTranslator(Zend_Registry::get('Zend_Translate'));
    }
}