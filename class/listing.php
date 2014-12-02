<?php

class listing {

    private $page;
    private $eps; // entries per site

    public function __construct($page, $count = 30) {
        $this->page = intval($page);
        $this->eps = intval($count);
    }

    public function getEntries() {
        $von = $this->eps * $this->page - $this->eps;
        $entries = db_function::getRangeNoten($von, $this->eps);
        return $entries;
    }

    public function test() {
        $entries = db_function::test();
        return $entries;
    }

    public function currentPage() {

    }

    public function totalPages() {

    }


}
?>
