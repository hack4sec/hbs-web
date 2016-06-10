<?php

class WorkTasks extends Common
{
    protected $_name = 'task_works'; #FIXME табличку переименовать, или классы
    protected $_rowClass = 'WorkTask';

    public function getList() {
        return $this->fetchAll(null, "ORDER BY id ASC");
    }

    public function getHashlistsInWork() {
        $Hashlists = new Hashlists();
        $toReturn = [];
        $ids = $this->getAdapter()->fetchCol(
            "SELECT DISTINCT hashlist_id FROM {$this->_name} t, hashlists h WHERE h.id = t.hashlist_id  ORDER BY h.name ASC"
        );
        foreach ($ids as $id) {
            $toReturn[] = $Hashlists->get($id);
        }
        return $toReturn;
    }

    public function getWorkTasksByHashlist($id) {
        return $this->fetchAll("hashlist_id = $id", "priority DESC");
    }

    public function add($data) {
        foreach ($data['hashlist_id'] as $hashlistId) {
            foreach ($data['tasks'] as $task) {
                $this->createRow(
                    [
                        'hashlist_id' => $hashlistId,
                        'task_id'     => $task,
                        'priority'    => (int)$data['priority'],
                    ]
                )->save();
            }
        }
    }

    public function getStatusList() {
        $ids = $this->getAdapter()->fetchCol(
            "SELECT
              id,
              IF(status = 'work', 0, IF(status='wait', 1, IF(status = 'go_stop', 2, IF(status = 'stop', 3, IF(status='done',4,status))))) as status_id
             FROM `task_works` t
             ORDER BY status_id ASC, priority DESC, hashlist_id ASC"
        );
        $tasks = [];
        foreach ($ids as $id) {
            $tasks[] = $this->get($id);
        }
        return $tasks;
    }

    public function startAll() {
        $this->getAdapter()->query("UPDATE {$this->_name} SET status='wait' WHERE status='stop'");
    }

    public function stopAll() {
        $this->getAdapter()->query("UPDATE {$this->_name} SET status=IF(status='work', 'go_stop', 'stop') WHERE status != 'done'");
    }

    public function getCurrentWorkTaskId() {
        return (int)$this->getAdapter()->fetchOne(
            "SELECT id FROM {$this->_name} WHERE status='work'"
        );
    }
}