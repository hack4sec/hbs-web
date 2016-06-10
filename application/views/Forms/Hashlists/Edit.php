<?php

class Forms_Hashlists_Edit extends Forms_Hashlists_Abstract {
    protected $_viewScript = 'hashlists/forms/edit.phtml';

    public function init() {
        $this->addElement(
            'hidden',
            'id',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'hashlistsForm_id']
            ]
        );

        parent::init();
        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_SAVE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'hashlistsForm_button']
            ]
        );
    }
} 