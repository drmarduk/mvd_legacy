<?php

$temp = new template('stimmen');
$stimmen = new stimmen();
$error = NULL;

// insert
if(isset($_GET['insert'])) {
    $inputStimme = $_POST['stimme'];
    $stimmen->insertNewStimme($inputStimme);
}

// change
if(isset($_GET['change'])) {
    $inputStimme = addslashes($_POST['neuername']);
    $inputID = intval($_POST['alte']);
    $stimmen->changeStimme($inputID, $inputStimme);
}

// delete
if(isset($_GET['delete'])) {
    $inputID = intval($_POST['stimme']);
    $stimmen->deleteStimme($inputID);
}



$htmlstimmen = NULL;
$htmlstimmen2 = NULL;
$liststimmen = $stimmen->getStimmen();
foreach ($liststimmen as $s) {
    $htmlstimmen .= '<option value="' . $s['id'] . '">' . $s['namen'] . '</option>';
    $htmlstimmen2 .= '<li>' . $s['namen'] . '</li>';
}

// sortierte Stimmenliste
$htmlstimmen3 = NULL;
$listenstimme3 = $stimmen->getStimmen(TRUE);
foreach ($listenstimme3 as $s) {
    $htmlstimmen3 .= '<li>' . $s['namen'] . '</li>';
}

$error = $stimmen->error() . '<hr />';
$temp->setContent('###ERROR###', $error);
$temp->setContent('###STIMMEN###', $htmlstimmen);
$temp->setContent('###STIMMEN2###', $htmlstimmen2);
$temp->setContent('###STIMMEN3###', $htmlstimmen3);
$temp->display();
?>
