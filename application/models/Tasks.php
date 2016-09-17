<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class Tasks extends Common
{
    protected $_name = 'tasks';
    protected $_rowClass = 'Task';

    public function add($data) {
        $row = $this->createRow($data);
        if (in_array($row->type, ['maskdict', 'dictmask'])) {
            $row->source = json_encode([
                'mask' => $data['source_mask'],
                'dict' => $data['source_dict']
            ]);
        }
        $row->save();
        return $row;
    }

    public function edit($data) {
        $row = $this->get($data['id']);
        $row->setFromArray($data);
        if (in_array($row->type, ['maskdict', 'dictmask'])) {
            $row->source = json_encode([
                'mask' => $data['source_mask'],
                'dict' => $data['source_dict']
            ]);
        }
        $row->save();
    }

    public function getByGroupId($id) {
        return $this->fetchAll("group_id = $id", "id ASC");
    }

    public function exists($name, $groupId) {
        return (bool)$this->fetchRow("name = {$this->getAdapter()->quote($name)} AND group_id = $groupId");
    }
}