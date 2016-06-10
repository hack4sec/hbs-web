<?php

class Forms_WorkTasks_Abstract extends Forms_Abstract
{
    protected $_viewScript;

    public function init()
    {
        parent::init();

        $this->addElement(
            'text',
            'priority',
            [
                'label' => $this->_t('L_PRIORITY'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'value' => '0',
                'attribs' => ['id' => 'workTaskForm_priority']
            ]
        );

        $Hashlists = new Hashlists();
        $this->addElement(
            'multiselect',
            'hashlist_id',
            [
                'label' => $this->_t('L_HASH_LIST'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'workTaskForm_hashlist_id', 'class' => 'selectElement', 'size' => 10],
                'multiOptions' => $Hashlists->getList(),
            ]
        );

        $this->addElement(
            'select',
            'tasks',
            [
                'label' => $this->_t('L_TASKS'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'workTaskForm_tasks', 'class' => 'selectElement'],
                'multiOptions' => (new Tasks_Groups())->arrayForWorkTasksSelect(),
                'size' => 10,
                'multiple' => true,
            ]
        );
        $this->getElement('tasks')->setRegisterInArrayValidator(false);
    }

}