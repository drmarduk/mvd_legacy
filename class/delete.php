<?php

class delete {

    public function __construct() {
        
    }

    /*
     * Was muss geloescht werden?
     * noten ...
     * files ... mit noten_id
     * pdfs loeschen
     */

    public function delete($id) {
        // pdf's loeschen
        $stimmenliste = db_function::getStimmen();
        foreach ($stimmenliste as $stimme) {
            $pdf = db_function::getPdf($id, $stimme['id']);

            if (!empty($pdf)) {
                unlink(ROOT . PDF_PATH . $pdf['filename']); //pdf weg
                db_function::deleteFile($id, $stimme['id'], $pdf['filename']); // entry in files weg
            }
        }

        db_function::deleteNoten($id); // entry in noten weg

        header('Location: ' . URL);
        exit(0);
    }
    
    public function deleteRawPDF($folder, $filename) {
        unlink(ROOT . $folder . $filename);        
    }

}

?>
