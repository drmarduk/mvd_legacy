<?php

class stimmen {

    public $error = '';

    public function __construct() {
        $error = '';
    }

    public function insertNewStimme($stimme) {
        if (strlen($stimme) > 1) {
            $stimme = addslashes($stimme);
            db_function::insertStimme($stimme);

            $this->error .= $stimme . ' eingef�gt.';
        }
        else
            $this->error .= 'Ung�ltiger Stimmenname vergeben.';
    }

    public function changeStimme($stimmen_id, $name) {
        if ($this->validStimmenID($stimmen_id, FALSE)) {
            $oldname = $this->validStimmenID($stimmen_id, TRUE);
            $stimmen_id = intval($stimmen_id);
            $name = addslashes($name);
            db_function::updateStimme($stimmen_id, $name);

            $this->error .= $oldname . ' zu ' . $name . ' ge�ndert.';
        } else {
            $this->error .= 'Ung�ltige Stimme angegeben.';
        }
    }

    public function deleteStimme($stimmen_id) {
        if ($this->validStimmenID($stimmen_id, FALSE)) {
            $name = $this->validStimmenID($stimmen_id, TRUE);
            db_function::deleteStimme($stimmen_id);

            $this->error .= $name . ' gel�scht.';
        } else {
            $this->error .= 'Ung�ltige Stimme angegeben.';
        }
    }

    public function getStimmen($sorted = FALSE) {
            return db_function::getStimmen($sorted);
    }

    public function error() {
        return $this->error;
    }

    private function validStimmenID($id, $mode) {
        $t = db_function::getStimme($id);

        if ($t['id'] == $id) {
            if ($mode == TRUE) {
                return $t['namen'];
            } else {
                return TRUE;
            }
        }
        return FALSE;
    }

}
?>

