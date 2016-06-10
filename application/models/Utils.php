<?php

class Utils
{
    public static function numberToText($number) {
        $number = (int)$number;
        $m_nums = 1000000;
        $b_nums = 1000000000;
        $k_nums = 1000;
        $suffix = "";
        $result = "";
        /*if ($number > $b_nums) {
            return round($number/$b_nums, 2) . " B/s";
        }*/

        if ($number > $m_nums) {
            $result = round($number/$m_nums, 2);
            $suffix = " M/s";
        } elseif ($number > $k_nums) {
            $result = round($number/$k_nums, 2);
            $suffix = " K/s";
        } else {
            $result = $number;
            $suffix = "/s";
        }

        return number_format((float)$result, 2, ".", " ") . $suffix;
    }

    public static function secsToText($secs) {
        $secs = (int)$secs;

        $min_time = 60;
        $hour_time = 3600;
        $day_time = 3600*24;

        $days = $hours = $mins = 0;

        if ($secs >= $day_time) {
            $days = intval($secs/$day_time);
            $secs = $secs%$day_time;
        }

        if ($secs >= $hour_time) {
            $hours = intval($secs/$hour_time);
            $secs = $secs%$hour_time;
        }

        if ($secs >= $min_time) {
            $mins = intval($secs/$min_time);
            $secs = $secs%$min_time;
        }
        $str_time = [];
        if ($days) {
            $str_time[] = "{$days}d";
        }
        if ($hours) {
            $str_time[] = "{$hours}h";
        }
        if ($mins) {
            $str_time[] = "{$mins}m";
        }
        if ($secs) {
            $str_time[] = "{$secs}s";
        }
        return implode(" ", $str_time);
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public static function getSettings() {
        return [
            'max_execution_time' => ini_get('max_execution_time'),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize')
        ];
    }
}