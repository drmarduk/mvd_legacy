<?php

class statistik {

    public function __construct() {
        ;
    }

    public function notentotal() {
        $result = db_function::getNotenCount();
        return $result['count'];
    }

    public function notenrepertoire() {
        $result = db_function::getRepertoireCount();
        return $result['count'];
    }

    public function filestotal() {
        $result = db_function::getPdfCount();
        return $result['count'];
    }

    public function genretotal() {
        $result = db_function::getGenreCount();
        return $result['count'];
    }

    public function stimmentotal() {
        $result = db_function::getStimmeCount();
        return $result['count'];
    }

    public function maxStimmenproNotensatz() {
        $result = db_function::maxStimmenproNotensatz();
        return $result;
    }

    public function minStimmenproNotensatz() {
        $result = db_function::minStimmenproNotensatz();
        return $result;
    }

    public function fileinqueue() {
        $queuedir = ROOT . '/queue';
        $handle = opendir($queuedir);
        $count = 0;
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $count++;
                }
            }
            closedir($handle);
        }

        return $count;
    }

    public function frequencyGenre() {
        $result = db_function::getGenreusage();
        return $result;
    }

    public function repertoiretotal() {
        $result = db_function::query('SELECT COUNT(*) as count FROM repertoire');
        return $result[0]['count'];
    }

}

?>
