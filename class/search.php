<?php

class search {

    private $result = '';

    public function __construct($mode, $searchterm) {
        switch ($mode) {
            case 'titel':
                $this->result = db_function::searchTitle($searchterm);
                break;
            case 'komponist':
                $this->result = db_function::searchKomponist($searchterm);
                break;
            case 'year':
                $this->result = db_function::searchYear($searchterm);
                break;
            case 'genre':
                $this->result = db_function::searchGenre($searchterm);
                break;
            case 'gesang':
                $this->result = db_function::searchGesang();
                break;
            case 'repertoire':
                $this->result = db_function::searchRepertoire();
                break;
            default:
                $this->result = 'no searchmode given';
                break;
        }
    }

    public function getResult() {
        return $this->result;
    }

}

?>
