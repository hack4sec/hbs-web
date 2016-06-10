<?php

abstract class Forms_Abstract extends Zend_Form {
    protected $_viewScript;

    protected function _t($phrase) {
        return $this->getDefaultTranslator()->translate($phrase);
    }

    public function init() {
        parent::init();

        $this->setDecorators(
            [
                [
                    'viewScript',
                    [
                        'viewScript' => $this->_viewScript
                    ]
                ]
            ]
        );
    }
}