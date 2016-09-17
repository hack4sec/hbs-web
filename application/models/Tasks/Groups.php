<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Tasks_Groups extends Common
{
    protected $_rowClass = 'Tasks_Group';
    protected $_name = 'tasks_groups';

    public function exists($name) {
        return (bool)$this->fetchRow("name = {$this->getAdapter()->quote($name)}");
    }

    public function arrayForWorkTasksSelect() {
        $toReturn = [];
        $groups = $this->fetchAll(null, "name ASC");
        foreach ($groups as $group) {
            $toReturn[$group->name] = $this->getAdapter()->fetchPairs(
                "SELECT id, name FROM tasks WHERE group_id = {$group->id} ORDER BY name ASC"
            );
        }
        return $toReturn;
    }
}