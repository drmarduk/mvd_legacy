<?php

$p = new planer();
$temp = new template('planer');
$newrepertoire = '';
$addnoten = '';
if (isset($_GET['view']) && isset($_GET['r_id'])) {

    if (isset($_GET['addnoten']) && $_GET['r_id']) {
        $p->addNotenRepertoire($_GET['r_id'], $_POST['n_id']);
    }


    $id = $_GET['r_id'];
    $htmlrepertoire = '<ol>';
    $tmp = $p->getallNotenRepertoire($id);
    if (count($tmp) > 0) {
        foreach ($tmp as $t) {
            $htmlrepertoire .= '<li><a href="###URL###/view/' . $t['id'] . '">' . $t['titel'] . '</a>' .
                    ' - <a href="###URL###/planer/deletenoten/' . $t['r_id'] . '/' . $t['id'] . '">Löschen</a></li>';
        }

        $htmlrepertoire .= '</ol>';
    }

    // notenliste
    $noten = db_function::getallNoten();
    $addnoten = '<form method="post" name="addnoten" action="###URL###/planer/view/' . $id . '/addnoten"><select name="n_id">';
    foreach ($noten as $n) {
        $addnoten .= '<option value="' . $n['id'] . '">' . $n['titel'] . '</option>';
    }
    $addnoten .= '</select><input type="submit" name="addnoten" value="Hinzufügen" /></form>';
    $htmlrepertoire .= '<a href="###URL###/planer/deleterepertoire/' . $id . '">Repertoire löschen</a>';
} else {
// neues Repertoire anlegen
    if (isset($_GET['new'])) {

        $p->newRepertoire($_POST['name'], $_POST['year'], $_POST['orchester'], $_POST['comment']);
    }
    // Note von Repertoire löschen
    if (isset($_GET['deletenoten']) && isset($_GET['r_id']) && isset($_GET['n_id'])) {
        $p->deleteNotefromRepertoire($_GET['r_id'], $_GET['n_id']);
    }

    // Repertoire löschen
    if (isset($_GET['deleterepertoire']) && isset($_GET['r_id'])) {
        $p->deleteRepertoire($_GET['r_id']);
    }
// Liste alle Repertoires auf
    $htmlrepertoire = format::htmldiv(format::htmldiv('Titel') . format::htmldiv('Jahr') . format::htmldiv('Orchester') . format::htmldiv('Beschreibung'), 'planer');
    $tmp = $p->getallrepertoires();
    foreach ($tmp as $t) {
        $htmlrepertoire .= format::htmldiv(format::htmldiv('<a href="###URL###/planer/view/' . $t['id'] . '">' . $t['name'] . '</a>') . format::htmldiv($t['year']) . format::htmldiv($t['orchester']) . format::htmldiv($t['comment']), 'planer');
    }

    $temp2 = new template('planernewrepertoire');
    $newrepertoire = $temp2->getVorlage();
}
$temp->setContent('###NEWREPERTOIRE###', $newrepertoire);
$temp->setContent('###ADDNOTEN###', $addnoten);
$temp->setContent('###REPERTOIRENAMEN###', $htmlrepertoire);
$temp->setContent('###URL###', URL);
$temp->display();
?>
