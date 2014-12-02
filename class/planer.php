<?php

class planer {

    public function getallrepertoires() {
        $result = db_function::query('SELECT * FROM repertoire');
        return $result;
    }

    public function getrepertoire($id) {
        $id = intval($id);
        $result = db_function::query('SELECT * FROM repertoire WHERE id = ' . $id);
        return $result;
    }

    public function getallNotenRepertoire($id) {
        $id = intval($id);
        $result = db_function::query('SELECT r.r_id, n.id, n.titel
FROM noten AS n, repertoireliste AS r
WHERE r.noten_id = n.id AND r.r_id = ' . $id);
        return $result;
    }

    public function deleteRepertoire($id) {
        $id = intval($id);
        db_function::deletequery('repertoire', 'id = ' . $id);
        db_function::deletequery('repertoireliste', 'r_id = ' . $id);
    }

    public function deleteNotefromRepertoire($r_id, $n_id) {
        $r_id = intval($r_id);
        $n_id = intval($n_id);

        db_function::deletequery('repertoireliste', 'r_id = ' . $r_id . ' AND noten_id = ' . $n_id);
    }

    public function newRepertoire($name, $year, $orchester, $comment) {
        $name = addslashes($name);
        $year = intval($year);
        $orchester = addslashes($orchester);
        $comment = addslashes($comment);

        $sql = 'INSERT INTO repertoire(id, name, year, orchester, comment) VALUES(NULL, "' . $name . '", "' . $year . '", "' . $orchester . '", "' . $comment . '")';
        db_function::insertquery($sql);
    }

    public function addNotenRepertoire($r_id, $n_id) {
        $n_id = intval($n_id);
        $r_id = intval($r_id);

        $sql = 'INSERT INTO repertoireliste(r_id, noten_id) VALUES("' . $r_id . '", "' . $n_id . '")';
        db_function::insertquery($sql);
    }

}

?>
