<?php

$temp = new template('sort');
$sort = new sort();

$error = " ";
$noten_id = 0;
// Einfuegen
if (isset($_GET['submit'])) {
    if (isset($_POST['filename'])) {
        $filename = addslashes($_POST['filename']);
        if (isset($_POST['folder'])) {
            $folder = addslashes($_POST['folder']);
            $noten_id = intval($_POST['titel']);
            $stimme_id = intval($_POST['stimme']);

            $sort->insert($noten_id, $stimme_id, $filename, $folder);
        } else {
            $error .= 'Folder wrong. ';
        }
    } else {
        $error .= 'Filename wrong. ';
    }
}

// Deleten
if (isset($_GET['delete'])) {
    if (isset($_POST['filename'])) {
        $filename = addslashes($_POST['filename']);
        if (isset($_POST['folder'])) {
            $folder = addslashes($_POST['folder']);
            $sort->delete($folder, $filename);
        } else {
            ; // error
        }
    } else {
        ; // error
    }
}

// QUEUE
if (isset($_GET['queue'])) {
    if (isset($_POST['filename'])) {
        $filename = addslashes($_POST['filename']);
        if (isset($_POST['folder'])) {
            $folder = addslashes($_POST['folder']);


            $sort->queue($folder, $filename);
        } else {
            $error .= 'Folder wrong. ';
        }
    } else {
        $error .= 'Filename wrong. ';
    }
}


$tmp = $sort->getNextPDF();
$stimmen = $sort->getAllStimmen();
$titel = $sort->getAllNoten();
$filename = $tmp[1];
$folder = $tmp[0];

$htmlstimmen = NULL;
$laststimme = $sort->lastInsertedStimme();
foreach ($stimmen as $s) {
    if ($laststimme == $s['id']) {
        $htmlstimmen .= '<option selected="selected" value="' . $s['id'] . '">' . $s['namen'] . '</option>';
    } else {
        $htmlstimmen .= '<option value="' . $s['id'] . '">' . $s['namen'] . '</option>';
    }
}

$last = $sort->lastInserted();
$htmltitel = NULL;
foreach ($titel as $n) {
    if ($last == $n['id']) {
        $htmltitel .= '<option selected="selected" value="' . $n['id'] . '">' . $n['titel'] . '</option>';
    } else {
        $htmltitel .= '<option value="' . $n['id'] . '">' . $n['titel'] . '</option>';
    }
}

// set content
$temp->setContent('###TITELID###', $last);
$temp->setContent('###TITELNAME###', meta::getTitel($last));
$temp->setContent('###FILENAME###', $filename);
$temp->setContent('###FOLDER###', $folder);
$temp->setContent('###STIMMEN###', $htmlstimmen);
$temp->setContent('###TITEL###', $htmltitel);
$temp->setContent('###PDF###', URL . "/raw/" . $folder . '/' . $filename);
$temp->setContent('###URL###', URL);
$error .= $sort->error();
$temp->setContent('###ERROR###', $error);
$temp->display();
?>
