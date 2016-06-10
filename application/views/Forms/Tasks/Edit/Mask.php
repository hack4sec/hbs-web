<?php
class Forms_Tasks_Edit_Mask extends Forms_Tasks_Abstract {
    protected $_viewScript = 'tasks/forms/edit/mask.phtml';

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

        $this->addElement(
            'text',
            'source',
            [
                'label' => $this->_t('L_MASK'),
                'decorators' => ['ViewHelper', 'Errors'],
                'required' => true,
                'attribs' => ['id' => 'taskForm_source', 'class' => ''],
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
            'checkbox',
            'increment',
            [
                'label' => 'Increment',
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['id' => 'taskForm_increment', 'class' => '', 'onclick' => 'activeIncrement()'],
            ]
        );

        $this->addElement(
            'text',
            'increment_min',
            [
                'label' => 'increment-min',
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['id' => 'taskForm_increment_min', 'class' => ''],
            ]
        );

        $this->addElement(
            'text',
            'increment_max',
            [
                'label' => 'increment-max',
                'decorators' => ['ViewHelper', 'Errors'],
                'attribs' => ['id' => 'taskForm_increment_max', 'class' => ''],
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