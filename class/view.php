<?php

class view {

    public $id;
    public $titel;
    public $genre;
    public $genre_id;
    public $komponist;
    public $gesang;
    public $year;
    public $repertoire;
    public $repertoirenumber;
    public $schrank;
    public $score;
    

    // fürs erste, mehr kommt spaeter

    public function __construct($idp) {
        $id = $idp;

        $info = db_function::getNoten($id);
        $this->id = $info['id'];
        $this->titel = $info['titel'];
        $this->genre = $info['genre'];
        $this->genre_id = $info['genreid'];
        $this->komponist = $info['komponist'];
        $this->gesang = $info['gesang'];
        $this->year = $info['year'];
        $this->repertoire = $info['isrepertoire'];
        $this->repertoirenumber = $info['repertoirenumber'];
        $this->schrank = $info['schrank'];
        $this->score = $info['score'];
    }
    
    /*
     * Gibt ein Dateinamen zur entsprechenden Pdf aus
     */
    public function getPdf($stimmen_id){
        return db_function::getPdf($this->id, $stimmen_id);
    }

}

?>