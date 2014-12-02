<?php

$titel = isset($_POST['titel']) ? $_POST['titel'] : '';
$genre = isset($_POST['genre']) ? $_POST['genre'] : 0;
$year = isset($_POST['year']) ? $_POST['year'] : 0;
$komponist = isset($_POST['komponist']) ? $_POST['komponist'] : '';
$gesang = isset($_POST['gesang']) ? 1 : 0;
$isrepo = isset($_POST['isrepertoire']) ? 1 : 0;
$repertoirenumber = (isset($_POST['repertoirenumber']) && $isrepo == 1)? $_POST['repertoirenumber'] : 0;
$schrank = isset($_POST['schrank']) ? $_POST['schrank'] : '';


if(isset($_POST['submit'])){
    $insertt = new insert(1);
    $insertt->insert($titel, $genre, $year, $komponist, $gesang, $isrepo, $repertoirenumber, $schrank);       
    
}

$temp = new template('insert');

$genres = NULL;
$genrelist = db_function::getGenres();
foreach($genrelist as $tmp){
    $genres .= '<option value="' . $tmp['id'] . '" >' . $tmp['genre'] . '</option>';
}

$temp->setContent('###GENRES###', $genres);

$temp->display();
?>
