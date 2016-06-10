<?php

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