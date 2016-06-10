<?php

class Forms_Dicts_Group_Abstract extends Forms_Abstract
{
    protected $_viewScript;

    public function init()
    {
        parent::init();

        $this->addElement(
            'text',
            'name',
            [
                'label' => $this->_t('L_DICTS_GROUP_NAME'),
                'decorators' => ['ViewHelper', 'Errors'],
                'validators' => [
                    new Forms_Validate_Dicts_Group_Name,
                ],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'dictGroupForm_name']
            ]
        );
    }

}