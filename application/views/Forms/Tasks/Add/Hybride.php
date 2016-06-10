<?php
class Forms_Tasks_Add_Hybride extends Forms_Tasks_Abstract {
    protected $_viewScript = 'tasks/forms/add/hybride.phtml';

    public function init() {
        parent::init();

        $Groups = new Dicts_Groups();
        $this->addElement(
            'select',
            'source_dict',
            [
                'label' => $this->_t('L_DICT_GROUP'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'taskForm_source_dict', 'class' => 'selectElement'],
                'multiOptions' => $Groups->getList() //TODO сюда кол-во и размер
            ]
        );

        $this->addElement(
            'text',
            'source_mask',
            [
                'label' => $this->_t('L_MASK'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'taskForm_source_mask', 'class' => ''],
            ]
        );

        $this->addElement(
            'text',
            'custom_charset1',
            [
                'label' => $this->_t('L_USERS_CHARSET_1'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['id' => 'taskForm_custom_charset1', 'class' => ''],
            ]
        );

        $this->addElement(
            'text',
            'custom_charset2',
            [
                'label' => $this->_t('L_USERS_CHARSET_2'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['id' => 'taskForm_custom_charset2', 'class' => ''],
            ]
        );

        $this->addElement(
            'text',
            'custom_charset3',
            [
                'label' => $this->_t('L_USERS_CHARSET_3'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['id' => 'taskForm_custom_charset3', 'class' => ''],
            ]
        );

        $this->addElement(
            'text',
            'custom_charset4',
            [
                'label' => $this->_t('L_USERS_CHARSET_4'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['id' => 'taskForm_custom_charset4', 'class' => ''],
            ]
        );

        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_ADD'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'taskForm_button']
            ]
        );
    }
} 