<?php

class sort {

    public $error;
    public $mode;
    public $pdf;
    public $folder;
    private $srcdir;
    private $pdfdir;
    private $queuedir;

    public function __construct() {
        $this->error = '';
        $this->srcdir = 'c:\\xampp\\htdocs\\musikverein\\raw';
        $this->pdfdir = 'c:\\xampp\\htdocs\\musikverein\\pdf';
        $this->queuedir = 'c:\\xampp\\htdocs\\musikverein\\queue';
    }

    public function error() {
        return $this->error;
    }

    public function insert($noten_id, $stimmen_id, $filename, $folder) {
        $noten_id = intval($noten_id);
        $stimmen_id = intval($stimmen_id);

        if ($this->validNotenID($noten_id)) {
            if ($this->validStimmenID($stimmen_id)) {
                if (!$this->duplicate($noten_id, $stimmen_id)) {
                    // INSERT
                    db_function::insertFile($noten_id, $stimmen_id, $filename);
                    // MOVE
                    $this->movePDF($this->srcdir . '/' . $folder, $filename, $this->pdfdir);
                    // Update last inserted
                    $this->updatelastInserted($noten_id);
                    $this->updatelastInsertedStimme($stimmen_id);

                    // DEBUG

                    $this->error .= format::green(meta::getTitel($noten_id) . ' unter ' . meta::getStimme($stimmen_id) . ' eingefügt. ');
                } else {
                    $this->error .= format::red('Befindet sich bereits in der Datenbank. ');
                }
            } else {
                $this->error .= format::red('Ungültige Stimme ausgewählt. ');
            }
        } else {
            $this->error .= format::red('Ungültiger Notensatz ausgewählt. ');
        }
    }

    public function delete($folder, $filename) {
        return unlink($this->srcdir . '/' . $folder . '/' . $filename);
    }

    public function queue($folder, $filename) {
        $this->movePDF($this->srcdir . '/' . $folder , $filename, $this->queuedir);
        $this->error .= $filename . ' in Warteschlange gestellt.';
    }

    private function movePDF($folder, $filename, $targetfolder) {
        if (!file_exists($targetfolder . '/' . $filename)) {
            rename($folder . '/' . $filename, $targetfolder . '/' . $filename);
            $this->error .= format::blue($filename . ' verschoben. ');
        } else {
            $this->error .= 'Cant override existing file';
        }
    }

    public function getAllNoten() {
        return db_function::getallNoten();
    }

    public function getAllStimmen() {
        return db_function::getStimmen(TRUE);
    }

    public function getNextPDF() {
        // open folder
        $hwd = opendir($this->srcdir);
        if ($hwd) {
            // in srcdir are only folders!!!!!!!!!
            while (false !== ($folder = readdir($hwd))) {
                if ($folder != '.' && $folder != '..') {
                    // folder shouldnt be . or ..
                    // $folder hat '(099)In the Mood'
                    $hwd2 = opendir($this->srcdir . '\\' . $folder);
                    if ($hwd2) {
                        // opened In the modd
                        while (false != ($pdf = readdir($hwd2))) {
                            if ($pdf != '.' && $pdf != '..') {
                                // FOLDER, FILE
                                return array($folder, $pdf);
                            }
                        }
                    }
                }
            }
        }
    }

    private function validNotenID($id) {
        $t = db_function::getNoten($id);

        if ($t['id'] == $id) {
            return TRUE;
        }
        return FALSE;
    }

    private function validStimmenID($id) {
        $t = db_function::getStimme($id);

        if ($t['id'] == $id) {
            return TRUE;
        }
        return FALSE;
    }

    private function duplicate($noten_id, $stimmen_id) {
        $t = db_function::getPdf($noten_id, $stimmen_id);
        if (isset($t['filename'])) {
            return TRUE;
        }
        return FALSE;
    }

    public function lastInserted() {
        $noten_id = db_function::lastInsertedPDF();
        return $noten_id['value'];
    }

    public function updatelastInserted($id){
        db_function::updatelastInsertedPDF($id);
    }

    public function lastInsertedStimme() {
        $stimmen_id = db_function::lastInsertedStimme();
        return $stimmen_id['value'];
    }

    public function updatelastInsertedStimme($id) {
        db_function::updatelastInsertedStimme($id);
    }

    // TODO: PDFs von einer Stimme zu einer anderen changen
}

?>
