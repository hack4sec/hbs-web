<?php
class Forms_Dicts_Group_Add extends Forms_Dicts_Group_Abstract {
    protected $_viewScript = 'dicts/forms/group/add.phtml';

    public function init() {
        parent::init();

        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_ADD'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'dictGroupForm_button']
            ]
        );
    }
} 