<?php
class Forms_Tasks_Group_Add extends Forms_Tasks_Group_Abstract {
    protected $_viewScript = 'tasks/forms/group/add.phtml';

    public function init() {
        parent::init();

        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_ADD'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'taskGroupForm_button']
            ]
        );
    }
} 