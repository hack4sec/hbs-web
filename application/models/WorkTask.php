<?php
/**
 * @package HashBruteStation
 * @see for EN http://hack4sec.pro/wiki/index.php/Hash_Brute_Station_en
 * @see for RU http://hack4sec.pro/wiki/index.php/Hash_Brute_Station
 * @license MIT
 * @copyright (c) Anton Kuzmin <http://anton-kuzmin.ru> (ru) <http://anton-kuzmin.pro> (en)
 * @author Anton Kuzmin
 */
class WorkTask extends Zend_Db_Table_Row
{
    protected $_tableClass = 'WorkTasks';

    public function getTask() {
        return (new Tasks())->get($this->task_id);
    }

    public function getSpeed() {
        if (strlen($this->hc_speed)) {
            list($candidates, $msspeed) = array_map('trim', explode("\t", $this->hc_speed));
            return Utils::numberToText(round($candidates / $msspeed * 1000));
        }
        return 'n/a';
    }

    public function getProgress() {
        if ($this->status != 'done' && strlen($this->hc_progress)) {
            list($current, $all) = array_map('trim', explode("\t", $this->hc_progress));
            return (($this->status == 'done') ? ceil($current/$all*100) : round($current/$all*100, 2)) . "%";
        }
        return 'n/a';
    }

    public function getTime() {
        if (strlen($this->hc_speed) and strlen($this->hc_progress)) {
            list($candidates, $msspeed) = array_map('trim', explode("\t", $this->hc_speed));
            if (!$msspeed || !($speed = round($candidates / $msspeed * 1000))) {
                return 'n/a';
            }
            list($current, $all) = array_map('trim', explode("\t", $this->hc_progress));
            return [
                'all'  => Utils::secsToText(round($all / $speed)),
                'now'  => Utils::secsToText(round($current / $speed)),
                'need' => Utils::secsToText(round(($all - $current) / $speed)),
            ];
        }
        return 'n/a';
    }

    public function getWorkTime() {
        return $this->work_time ? Utils::secsToText($this->work_time) : '';
    }

    public function stop() {
        $this->status = ($this->status == 'work') ? 'go_stop' : 'stop';
        $this->save();
    }

    public function hide() {
        $this->hide = '1';
        $this->save();
    }

    public function resume() {
        $this->status = 'wait';
        $this->save();
    }

    public function getHcRechash() {
        return strlen($this->hc_rechash) ? array_map('trim', explode("\t", $this->hc_rechash)) : 'n/a';
    }
}