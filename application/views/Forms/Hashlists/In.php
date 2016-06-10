<?php
class Forms_Hashlists_In extends Forms_Abstract {
    protected $_viewScript = 'hashlists/forms/in.phtml';

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

        $config = Zend_Registry::get('config');
        $this->addElement(
            'file',
            'file',
            [
                'destination' => $config->paths->storage->tmp,
                'label' => 'Файл',
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_file']
            ]
        );

        $this->addElement(
            'checkbox',
            'have_salts',
            [
                'label' => $this->_t('L_HAVE_SALTS'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_have_salts'],
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
                'label' => $this->_t('L_ADD'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'hashlistsForm_button']
            ]
        );
    }
} 