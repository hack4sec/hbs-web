<?php

class Zend_View_Helper_Bytes
{
    public function Bytes($bytes) {
        $t = Zend_Registry::get('Zend_Translate');

        $toReturn = "";
        if ($bytes >= 1024*1024*1024) {
            $toReturn = round($bytes / (1024*1024*1024), 2) . " " . $t->translate("L_SIZE_GB");
        } elseif ($bytes >= 1024*1024) {
            $toReturn = round($bytes / (1024*1024), 2) . " " . $t->translate("L_SIZE_MB");
        } elseif ($bytes >= 1024) {
            $toReturn = round($bytes / (1024), 2) . " " . $t->translate("L_SIZE_KB");
        } else {
            $toReturn = $bytes . " " . $t->translate("L_SIZE_B");
        }
        return $toReturn;
    }
}