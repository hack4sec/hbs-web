<?php

class Hashlists extends Common
{
    protected $_name = 'hashlists';
    protected $_rowClass = 'Hashlist';

    public function init() {
        parent::init();
        $this->_hashesModel = new Hashes();
    }

    public function exists($name) {
        return (bool)$this->fetchRow("name = {$this->getAdapter()->quote($name)}");
    }

    private function _makeHashFromStr($hashlistId, $str, $haveSalt, $delimiter) {
        if ($haveSalt) {
            list($hash, $salt) = explode($delimiter, $str);
        } else {
            $hash = $str;
            $salt = '';
        }
        try {
            $this->_hashesModel->createRow([
                'hash' => $hash,
                'salt' => $salt,
                'hashlist_id' => $hashlistId
            ])->save();
        } catch (Exception $e) {
            if (!substr_count($e->getMessage(), "Duplicate entry")) {
                throw new Exception($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

    private function _insertHashes($listId, $hashes) {
        $tmpInserts = [];
        foreach ($hashes as $hash) {
            $tmpInserts[] = "($listId, {$this->getAdapter()->quote($hash['hash'])}, {$this->getAdapter()->quote($hash['salt'])}, {$this->getAdapter()->quote($hash['summ'])})";
        }
        $this->getAdapter()->query(
            "INSERT IGNORE INTO `hashes` (hashlist_id, hash, salt, `summ`) VALUES\n" .
            implode(",\n", $tmpInserts)
        );
    }

    private function _loadInListFromFile($list, $data) {
        $config = Zend_Registry::get('config');
        $hashes = $errors = [];
        $tmpFh = fopen("{$config->paths->storage->tmp}/{$data['filename']}", "r");
        $tmpData = '';
        while (!feof($tmpFh)) {
            $symbol = fread($tmpFh, 1);
            if ($symbol == "\n") {
                if ($data['have_salts']) {
                    if (substr_count($tmpData, $data['delimiter']) == 1) {
                        list($hash, $salt) = explode($data['delimiter'], $tmpData);
                        $summ = md5("$hash:$salt");
                    } else {
                        $errors[] = $tmpData;
                        $tmpData = '';
                        continue;
                    }
                } else {
                    $hash = $tmpData;
                    $salt = '';
                    $summ = md5("$hash");
                }
                $hashes[] = ['hash' => $hash, 'salt' => $salt, 'summ' => $summ];

                if (!(count($hashes)%$config->hashes_per_load)) {
                    $this->_insertHashes($list->id, $hashes);
                    $hashes = [];
                }

                $tmpData = '';
            } else {
                $tmpData .= $symbol;
            }
        }
        if (strlen($tmpData)) {
            if ($data['have_salts']) {
                if (substr_count($tmpData, $data['delimiter']) == 1) {
                    list($hash, $salt) = explode($data['delimiter'], $tmpData);
                    $hashes[] = ['hash' => $hash, 'salt' => $salt, 'summ' => md5("$hash:$salt")];
                } else {
                    $errors[] = $tmpData;
                }
            } else {
                $hash = $tmpData;
                $salt = '';
                $hashes[] = ['hash' => $hash, 'salt' => $salt, 'summ' => md5("$hash")];
            }
        }

        if (count($hashes)) {
            $this->_insertHashes($list->id, $hashes);
        }

        unlink("{$config->paths->storage->tmp}/{$data['filename']}");

        if (count($errors)) {
            $list->errors .= implode("\n", $errors) . "\n";
        }
        $list->save();
    }

    public function add($data)
    {
        $list = $this->createRow([
            'name' => $data['name'],
            'alg_id' => $data['alg_id'],
        ]);
        $list->save();
        $this->_loadInListFromFile($list, $data);
    }

    public function in($data) {
        $list = $this->get($data['id']);
        $this->_loadInListFromFile($list, $data);
    }

    public function import($listId, $founded) {
        return $this->getAdapter()->query(
            "SELECT hash, salt, password FROM hashes WHERE hashlist_id=$listId AND " . ($founded ? "cracked" : "!cracked")
        );
    }

    public function getList() {
        return $this->getAdapter()->fetchPairs("SELECT id, name FROM {$this->_name} ORDER BY name ASC");
    }
}