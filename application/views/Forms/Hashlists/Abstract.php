<?php

class Forms_Hashlists_Abstract extends Forms_Abstract
{
    protected $_viewScript;

    public function init()
    {
        parent::init();

        $Algs = new Algs();
        $this->addElement(
            'select',
            'alg_id',
            [
                'label' => $this->_t('L_ALG'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'hashlistsForm_alg_id', 'class' => 'selectElement'],
                'multiOptions' => $Algs->getList()
            ]
        );

        $this->addElement(
            'text',
            'name',
            [
                'label' => $this->_t('L_HASHLIST_NAME'),
                'decorators' => ['ViewHelper', 'Errors'],
                'validators' => [
                    new Forms_Validate_Hashlists_Name,
                ],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'hashlistsForm_name']
            ]
        );

    }

}