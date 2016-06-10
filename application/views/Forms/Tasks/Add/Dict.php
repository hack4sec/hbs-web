<?php
class Forms_Tasks_Add_Dict extends Forms_Tasks_Abstract {
    protected $_viewScript = 'tasks/forms/add/dict.phtml';

    public function init() {
        parent::init();

        $Groups = new Dicts_Groups();
        $this->addElement(
            'select',
            'source',
            [
                'label' => $this->_t('L_DICT_GROUP'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => '', 'class' => 'selectElement'],
                'multiOptions' => $Groups->getList() //TODO сюда кол-во и размер
            ]
        );

        $Rules = new Rules();
        $rulesList = $Rules->getList();
        $rulesList[0] = "-------";
        $this->addElement(
            'select',
            'rule',
            [
                'label' => $this->_t('L_RULES_LIST'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => '', 'class' => 'selectElement'],
                'multiOptions' => $rulesList,
                'value' => 0
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