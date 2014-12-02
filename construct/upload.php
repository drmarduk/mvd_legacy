<?php

$errors = null;

if (isset($_POST['submit'])) {
    // upload
    $file = $_FILES['files'];
    $id_titel = $_POST['titel'];
    $id_stimme = $_POST['stimme'];

    $up = new upload($file, $id_titel, $id_stimme);
    $errors = $up->getErrors();
}


$tmp = new template('upload');

//###ERRORS###
if (empty($errors)) {
    $tmp->setContent('###ERRORS###', '');
} else {
    $tmperror = '<ol>';
    foreach($errors as $error){
        $tmperror .= '<li>Fehler: ' . $error . '</li>';
    }
    $tmperror .= '</ol>';
    $tmp->setContent('###ERRORS###', $tmperror);
}


//###TITEL###
$lieder = null;
$liedliste = db_function::getallNoten();
foreach ($liedliste as $lied) {
    $lieder .= '<option value="' . $lied['id'] . '">' . $lied['titel'] . '</option>';
}

//###STIMMEN###
$stimmen = null;
$stimmenliste = db_function::getStimmen();
foreach ($stimmenliste as $stimme) {
    $stimmen .= '<option value="' . $stimme['id'] . '">' . $stimme['namen'] . '</option>';
}

$tmp->setContent('###TITEL###', $lieder);
$tmp->setContent('###STIMMEN###', $stimmen);

$tmp->display();
?>
