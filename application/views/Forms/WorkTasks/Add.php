<?php
class Forms_WorkTasks_Add extends Forms_WorkTasks_Abstract {
    protected $_viewScript = 'work-tasks/forms/add.phtml';

    public function init() {
        parent::init();


        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_ADD'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'workTaskForm_button']
            ]
        );
    }
} 