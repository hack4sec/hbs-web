<?php
class Forms_Rules_Add extends Forms_Rules_Abstract {
    protected $_viewScript = 'rules/forms/add.phtml';

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
                'attribs' => ['class' => 'inputElements', 'id' => 'rulesForm_file'],
                'onchange' => 'fillRulesNameFromPath(this.value)'
            ]
        );

        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_ADD'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'rulesForm_button']
            ]
        );
    }
} 