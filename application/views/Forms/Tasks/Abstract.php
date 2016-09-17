<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Forms_Tasks_Abstract extends Forms_Abstract
{
    protected $_viewScript;

    public function setGroupId($id) {
        $this->group_id->setValue($id);
    }

    public function setType($type) {
        $this->type->setValue($type);
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
                'attribs' => ['class' => 'inputElements', 'id' => 'taskForm_group_id']
            ]
        );

        $this->addElement(
            'hidden',
            'type',
            [
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'taskForm_type']
            ]
        );

        $this->addElement(
            'text',
            'name',
            [
                'label' => $this->_t('L_TASK_NAME'),
                'decorators' => ['ViewHelper', 'Errors'],
                'validators' => [
                    new Forms_Validate_Tasks_Name,
                ],
                'required' => true,
                'attribs' => ['class' => 'inputElements', 'id' => 'taskForm_name']
            ]
        );

        $this->addElement(
            'text',
            'additional_params',
            [
                'label' => $this->_t('L_ADDITIONAL_PARAMS_HC_RUN'),
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['class' => 'inputElements', 'id' => 'taskForm_additional_params']
            ]
        );

        $this->addElement(
            'text',
            'order',
            [
                'label' => $this->_t('L_TASK_ORDER_IN_GROUP'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'value' => 0,
                'attribs' => ['class' => 'inputElements', 'id' => 'taskForm_order']
            ]
        );
    }

}