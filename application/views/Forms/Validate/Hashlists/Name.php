<?php

class Forms_Validate_Hashlists_Name extends Forms_Validate_Abstract {

    protected $_exclude = 0;
    protected $_groupId = 0;
    /**
     * Константы, содержащие ключи ошибок в общем массиве
     *
     * @var string
     */
    const REPEAT = 'repeat';

    /**
     * Массив ошибок валидатора
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::REPEAT => 'L_HASHLIST_ALREADY_EXISTS'
    );

    /**
     * Метод занимающийся непосредственной проверкой
     * валидности переданного названия
     *
     * @return bool
     */
    public function isValid($value)
    {
        return !$this->repeat($value);
    }

    /**
     * Метод проверки названия на существование в базе.
     * Возвращает false если такого имени нет.
     *
     * @param string $title Проверяемое название
     * @return bool
     */
    public function repeat($title) {
        $Hashlists = new Hashlists();

        if($this->_exclude) {
            $editGroup = $Hashlists->get($this->_exclude);
            if($title == $editGroup['name'])
                return false;
        }

        if($Hashlists->exists($title)) {
            $this->_error(self::REPEAT);
            return true;
        }

        return false;
    }

    public function setExcludeId($id) {
        $this->_exclude = $id;
    }

    public function setGroupId($id) {
        $this->_groupId = $id;
    }
}
