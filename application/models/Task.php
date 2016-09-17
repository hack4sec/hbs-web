<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Task extends Zend_Db_Table_Row
{
    protected $_tableClass = 'Tasks';

    public function getSource() {
        $t = Zend_Registry::get('Zend_Translate');

        switch ($this->type) {
            case 'mask':
                return $this->source; //TODO как-то надо тут ещё чарсеты вывести
                break;
            case 'dict':
                $Groups = new Dicts_Groups();
                return $t->translate('L_DICT_GROUP') . " {$Groups->get($this->source)->name}";
                break;
            case 'dictmask':
                $Groups = new Dicts_Groups();
                $source = json_decode($this->source);
                return $t->translate('L_DICT_GROUP') . "{$Groups->get($source->dict)->name} + {$source->mask}";
                break;
            case 'maskdict':
                $Groups = new Dicts_Groups();
                $source = json_decode($this->source);
                return "{$source->mask} + {$t->translate('L_DICT_GROUP')} {$Groups->get($source->dict)->name}";
                break;
        }
    }

    public function getGroup() {
        return (new Tasks_Groups())->get($this->group_id);
    }
}