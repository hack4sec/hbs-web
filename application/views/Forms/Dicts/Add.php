<?php
class Forms_Dicts_Add extends Forms_Dicts_Abstract {
    protected $_viewScript = 'dicts/forms/add.phtml';

    public function init() {
        parent::init();

        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_ADD'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'dictForm_button']
            ]
        );

        $config = Zend_Registry::get('config');
        $this->addElement(
            'file',
            'file',
            [
                'destination' => $config->paths->storage->tmp,
                'label' => $this->_t('L_FILE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => [
                    'class' => 'inputElements',
                    'id' => 'dictForm_file',
                    'onchange' => 'fillDictNameFromPath(this.value)'
                ]
            ]
        );
    }
} 