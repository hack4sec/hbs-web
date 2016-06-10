<?php
class Forms_Hashlists_Import extends Forms_Abstract {
    protected $_viewScript = 'hashlists/forms/import.phtml';

    public function setId($id) {
        $this->id->setValue($id);
    }

    public function init() {
        parent::init();

        $this->addElement(
            'hidden',
            'id',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsInForm_id'],
            ]
        );
        $this->addElement(
            'checkbox',
            'founded',
            [
                'label' => $this->_t('L_FOUND'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_founded'],
                'value' => ':',
            ]
        );
        $this->addElement(
            'checkbox',
            'salts',
            [
                'label' => $this->_t('L_LOAD_SALTS'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_salts'],
                'value' => ':',
            ]
        );

        $this->addElement(
            'text',
            'delimiter',
            [
                'label' => $this->_t('L_DELIMITER'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_delimiter'],
                'value' => ':',
            ]
        );

        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_IMPORT'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'hashlistsForm_button']
            ]
        );
    }
} 