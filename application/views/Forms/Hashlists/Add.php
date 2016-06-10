<?php
class Forms_Hashlists_Add extends Forms_Hashlists_Abstract {
    protected $_viewScript = 'hashlists/forms/add.phtml';

    public function init() {
        parent::init();

        $config = Zend_Registry::get('config');
        $this->addElement(
            'file',
            'file',
            [
                'destination' => $config->paths->storage->tmp,
                'label' => $this->_t('L_FILE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_file'],
                'onchange' => 'fillHashlistNameFromPath(this.value)'
            ]
        );

        $this->addElement(
            'checkbox',
            'have_salts',
            [
                'label' => $this->_t('L_HAVE_SALTS'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_have_salts', 'onclick' => 'activeSalts()'],
                'value' => ':',
            ]
        );

        $this->addElement(
            'text',
            'delimiter',
            [
                'label' => $this->_t('L_DELIMITER'),
                'decorators' => ['ViewHelper', 'Errors'],
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