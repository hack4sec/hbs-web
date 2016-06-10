<?php

class Forms_Tasks_Group_Edit extends Forms_Tasks_Group_Abstract {
    protected $_viewScript = 'tasks/forms/group/edit.phtml';

    public function init() {
        $this->addElement(
            'hidden',
            'id',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'taskGroupForm_id']
            ]
        );

        parent::init();
        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_SAVE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'taskGroupForm_button']
            ]
        );
    }
} 