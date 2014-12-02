<?php

$id = intval($_GET['id']);
$v = new view($id);

// Fuer das Updaten schaue ich alle Werte von POST mit $v->asdf an und vergleiche
if (isset($_POST['submit'])) {
    
    $id2 = $_POST['id2'];
    $titel = isset($_POST['titel']) ? $_POST['titel'] : '';
    $genre = isset($_POST['genre']) ? $_POST['genre'] : 0;
    $year = isset($_POST['year']) ? $_POST['year'] : 0;
    $komponist = isset($_POST['komponist']) ? $_POST['komponist'] : '';
    $gesang = isset($_POST['gesang']) ? 1 : 0;
    $isrepo = isset($_POST['isrepertoire']) ? 1 : 0;
    $repertoirenumber = (isset($_POST['repertoirenumber']) && $isrepo == 1) ? $_POST['repertoirenumber'] : null;
    $schrank = isset($_POST['schrank']) ? $_POST['schrank'] : '';
    $edit = new edit();
    $edit->update($id2, $titel, $genre, $year, $komponist, $gesang, $isrepo, $repertoirenumber, $schrank);
}


$temp = new template('edit');

$temp->setContent('###ID###', $id);
$temp->setContent('###TITEL###', $v->titel);
$temp->setContent('###KOMPONIST###', $v->komponist);
$temp->setContent('###GENRE###', $v->genre);
$temp->setContent('###GESANG###', $v->gesang > 0 ? 'checked' : '');
$temp->setContent('###YEAR###', $v->year);
$temp->setContent('###REPERTOIRE###', $v->repertoire > 0 ? 'checked' : '');
$temp->setContent('###REPERTOIRENUMBER###', $v->repertoirenumber);
$temp->setContent('###SCHRANK###', $v->schrank);

$genres = '<option value="' . $v->genre_id . '">' . $v->genre . '</option>';
$genrelist = db_function::getGenres();
foreach($genrelist as $tmp){
    $genres .= '<option value="' . $tmp['id'] . '" >' . $tmp['genre'] . '</option>';
}



$temp->setContent('###GENRES###', $genres);

$temp->display();
?>
