<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Forms_Tasks_Edit_Dict extends Forms_Tasks_Abstract {
    protected $_viewScript = 'tasks/forms/edit/dict.phtml';

    public function init() {
        parent::init();

        $this->addElement(
            'hidden',
            'id',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'taskForm_id']
            ]
        );

        $Groups = new Dicts_Groups();
        $this->addElement(
            'select',
            'source',
            [
                'label' => $this->_t('L_DICT_GROUP'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'taskForm_source', 'class' => 'selectElement'],
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
            ]
        );

        $this->addElement(
            'submit',
            'submit',
            [
                'label' => $this->_t('L_SAVE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'taskForm_button']
            ]
        );
    }
} 