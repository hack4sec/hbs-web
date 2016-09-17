<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
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

        $this->addElement(
            'checkbox',
            'create_stopped',
            [
                'label' => $this->_t('L_CREATE_STOPPED'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'checked' => Zend_Registry::get('config')->work_tasks_create_stopped_default,
                'attribs' => ['class' => 'inputElements', 'id' => 'workTaskForm_create_stopped', 'onclick' => 'activeSalts()'],
            ]
        );

    }

}