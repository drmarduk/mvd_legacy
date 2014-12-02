<?php

class meta {

    public function __construct() {
        ;
    }

    // Titel einer Noten_ID
    public static function getTitel($noten_id) {
        $t = db_function::getNoten($noten_id);
        return $t['titel'];
    }

    // Stimme einer Stimmen_ID
    public static function getStimme($stimmen_id) {
        $t = db_function::getStimme($stimmen_id);
        return $t['namen'];
    }

    
}
?>
