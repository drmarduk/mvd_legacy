<?php

class upload {

    private $errors = array();
    private $filenamed = null;
    private $extension = null;

    public function __construct($file, $id_titel, $id_stimme) {

        if (!is_uploaded_file($file['tmp_name']) || !file_exists($file['tmp_name'])) {
            $this->errors[] = 'file not correctly uploaded';
            return;
        }

        if ($this->ispdf($file) && isset($id_titel) && isset($id_stimme)) {
            $this->extension = $this->getextension($file['name']);
            $this->filenamed = str_replace('.', '0', microtime(1)) . '_' . $this->save_filename($file['name']);

            if (copy($file['tmp_name'], ROOT . PDF_PATH . $this->filenamed . '.' . $this->extension)) {
                try {
                    db_function::insertFile($id_titel, $id_stimme, $this->filenamed . '.' . $this->extension);
                    $this->errors[] = 'File successfully uploaded';
                } catch (PDOException $err) {
                    $this->errors[] = 'Stimme existiert bereits';
                    unlink(ROOT . PDF_PATH . $this->filenamed . '.' . $this->extension);
                }                
            }
            else
                $this->errors[] = 'could not move uploaded file';
        }
    }

    // kann man aendern, dass mehr filetypes zugelassen sind. 
    private function ispdf($file) {
        if (isset($file['name']) && (strtolower($this->getextension($file['name'])) == 'pdf' || strtolower($this->getextension($file['name'])) == 'mp3')) {
            $this->extension = $this->getextension($file['name']);
            return true;
        } else {
            $this->errors[] = 'Format not supported';
            return false;
        }
    }

    private function getextension($filename) {
        $filename = strtolower($filename);
        //$exts = split("[/\\.]", $filename);
        $exts = explode('.', $filename);
        $n = count($exts) - 1;
        $exts = strtolower($exts[$n]);
        return $exts;
    }

    private function save_filename($filename) {
        $filename = explode(".", $filename);
        $filename = $filename[0];
        $filename = preg_replace("/[^\w äöü]/si", "_", $filename);


        RETURN $filename;
    }

    public function getErrors() {
        return $this->errors;
    }

}

?>
