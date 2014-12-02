<?php

class edit {
    
    public function __construct() {
        
    }

    public function update($id, $titel, $genre, $year, $komponist, $gesang, $isrepertoire, $repertoirenumber, $schrank) {
        db_function::updateNoten($id, $titel, $genre, $year, $komponist, $gesang, $isrepertoire, $repertoirenumber, $schrank);
        $location = URL . '/view/' . $id;
        header('Location: ' . $location);
    }

}

?>
