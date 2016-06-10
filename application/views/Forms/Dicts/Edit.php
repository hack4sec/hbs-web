<?php

class Forms_Dicts_Edit extends Forms_Dicts_Abstract {
    protected $_viewScript = 'dicts/forms/edit.phtml';

    public function init() {
        $this->addElement(
            'hidden',
            'id',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'dictsForm_id']
            ]
        );

        parent::init();
        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_SAVE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'dictForm_button']
            ]
        );
    }
} 