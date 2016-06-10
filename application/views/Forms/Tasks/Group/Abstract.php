<?php

class Forms_Tasks_Group_Abstract extends Forms_Abstract
{
    protected $_viewScript;

    public function init()
    {
        parent::init();

        $this->addElement(
            'text',
            'name',
            [
                'label' => $this->_t('L_GROUP_NAME'),
                'decorators' => ['ViewHelper', 'Errors'],
                'validators' => [
                    new Forms_Validate_Tasks_Group_Name,
                ],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'taskGroupForm_name']
            ]
        );
    }

}