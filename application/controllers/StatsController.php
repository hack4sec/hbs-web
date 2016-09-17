<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class StatsController extends Zend_Controller_Action
{
    public function indexAction() {
        $this->view->stats = (new Stats())->getCommonStat();
    }

    public function foundAction() {
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $fname = date("Y-m-d") . "_found.txt";
        $this->getResponse()
            ->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
            ->setHeader('Content-type', 'application/unknown;charset=utf-8', true)
            ->setHeader('Content-Disposition', "attachment; filename=$fname")
            ->clearBody();
        $this->getResponse()->sendHeaders();

        $stmt = $db->query("SELECT DISTINCT password FROM hashes WHERE cracked");
        while ($row = $stmt->fetch()) {
            print $row['password'] . "\n";
        }

        exit;
    }
}