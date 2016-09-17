<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Forms_Tasks_Edit_Hybride extends Forms_Tasks_Abstract {
    protected $_viewScript = 'tasks/forms/edit/hybride.phtml';

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
                'label' => $this->_t('L_SAVE'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'buttonElement', 'id' => 'taskForm_button']
            ]
        );
    }

    public function populate(array $values)
    {
        if (in_array($values['type'], ['dictmask', 'maskdict'])) {

            $values['source_mask'] = json_decode($values['source'])->mask;
            $values['source_dict'] = json_decode($values['source'])->dict;
        }
        return parent::populate($values);
    }
} 