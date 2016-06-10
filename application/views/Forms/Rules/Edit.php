<?php

class Forms_Rules_Edit extends Forms_Rules_Abstract {
    protected $_viewScript = 'rules/forms/edit.phtml';

    public function init() {
        $this->addElement(
            'hidden',
            'id',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'rulesForm_id']
            ]
        );

        parent::init();
        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_SAVE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'rulesForm_button']
            ]
        );
    }
} 