<?php

class Dicts extends Common
{
    protected $_name = 'dicts';

    public function getByGroupId($id) {
        return $this->fetchAll("group_id = $id", "id ASC");
    }

    public function getListByGroupId($id) {
        return $this->getAdapter()->fetchPairs(
            "SELECT id, name FROM {$this->_name} WHERE group_id = $id ORDER BY name ASC"
        );
    }

    public function exists($name, $groupId) {
        return (bool)$this->fetchRow("name = {$this->getAdapter()->quote($name)} AND group_id = $groupId");
    }

    public function add($data) {
        $config = Zend_Registry::get('config');
        if (substr($data['filename'], -4) == '.zip') {
            $zip = new ZipArchive();
            $zip->open("{$config->paths->storage->tmp}/{$data['filename']}");
            $dicts = [];
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $dicts[] = $zip->getNameIndex($i);
            }
            $tmpDir = md5(time() . rand(0, 9999999));
            mkdir("{$config->paths->storage->tmp}/$tmpDir");
            $zip->extractTo("{$config->paths->storage->tmp}/$tmpDir");
            foreach ($dicts as $dict) {
                $data['name'] = $dict;
                $this->_addDict("$tmpDir/$dict", $data);
            }
            Utils::deleteDir("{$config->paths->storage->tmp}/$tmpDir");
        } else {#TODO здесь сделать вывод ошибок, по-любому они могут возникнуть
            $this->_addDict($data['filename'], $data);
        }
        unlink("{$config->paths->storage->tmp}/{$data['filename']}");
    }

    private function _addDict($tmpPath, $data) {
        $config = Zend_Registry::get('config');
        $hash = md5(time() . rand(0, 1000000));

        copy("{$config->paths->storage->tmp}/{$tmpPath}", "{$config->paths->storage->dicts}/{$hash}.dict");

        $linesCount = 0;
        $tmpFh = fopen("{$config->paths->storage->dicts}/{$hash}.dict", "r");
        while (!feof($tmpFh)) {
            $tmpData = fread($tmpFh, 1024);
            $linesCount += substr_count($tmpData, "\n");
        }
        $linesCount += 1;
        fclose($tmpFh);

        $dict = $this->createRow(
            [
                'name' => $data['name'],
                'hash' => $hash,
                'group_id' => $data['group_id'],
                'comment' => $data['comment'],
                'size' => filesize("{$config->paths->storage->dicts}/{$hash}.dict"),
                'count' => $linesCount
            ]
        );
        $dict->save();

        unlink("{$config->paths->storage->tmp}/{$tmpPath}");
    }
}