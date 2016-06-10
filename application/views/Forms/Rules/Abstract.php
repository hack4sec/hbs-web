<?php

class Forms_Rules_Abstract extends Forms_Abstract
{
    protected $_viewScript;

    public function init()
    {
        parent::init();

        $this->addElement(
            'text',
            'name',
            [
                'label' => $this->_t('L_RULES_LIST_NAME'),
                'decorators' => ['ViewHelper', 'Errors'],
                'validators' => [
                    new Forms_Validate_Rules_Name,
                ],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'rulesForm_name']
            ]
        );

    }

}