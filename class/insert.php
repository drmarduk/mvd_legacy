<?php

class insert {

    /**
     *
     * @var INT 1 noch nichts machen, 2 einfügen
     */
    private $mode;
    private $error;
    
    public function __construct($mode) {
        $this->mode = $mode;
    }

    public static function insert($titel, $genre, $year, $komponist, $gesang, $isrepertoire, $repertoirenumber, $schrank) {

        if (true) {
            $id = db_function::insertNoten($titel, $genre, $year, $komponist, $gesang, $isrepertoire, $repertoirenumber, $schrank);
            $location = URL . '/view/' . $id;
            header('Location: ' . $location);
        } else {
            $error = 'could not insert into table';
        }
    }
    
    public static function InsertFromDir($title) {
        if($title) {
            $id = db_function::insertNoten($title, 1, 0, '', false, false, 0, 'null');
            return $id;
        }
    }
}

?>
