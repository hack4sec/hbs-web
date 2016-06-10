<?php

class Forms_Dicts_Abstract extends Forms_Abstract
{
    protected $_viewScript;

    public function setGroupId($id) {
        $this->group_id->setValue($id);
    }

    public function init()
    {
        parent::init();

        $this->addElement(
            'hidden',
            'group_id',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'dictForm_group_id']
            ]
        );

        $this->addElement(
            'text',
            'name',
            [
                'label' => $this->_t('L_DICT_NAME'),
                'decorators' => ['ViewHelper', 'Errors'],
                'validators' => [
                    new Forms_Validate_Dicts_Name,
                ],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'dictForm_name']
            ]
        );

        $this->addElement(
            'textarea',
            'comment',
            [
                'label' => $this->_t('L_COMMENT'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => [
                    'class' => 'inputElements',
                    'id' => 'dictForm_comment',
                    'rows' => '12'
                ]
            ]
        );
    }

}