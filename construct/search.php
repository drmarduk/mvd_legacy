<?php

$searchresult = '';
$mode = '';
$searchterm = '';

if (isset($_GET['search'])) {

    $mode = $_POST['option'];
    $searchterm = $_POST['query'];
    $s = new search($mode, $searchterm);
    $searchresult = $s->getResult();
}

$temp = new template('search');

if ($searchresult == '')
    $temp->setContent('###SEARCHRESULT###', $searchresult);
else {
    // Ergebnisausgabe, kann man auch schoener machen ;)
    $t = '<ol>';
    foreach($searchresult as $result){
        $t .= '<li><a href="' . URL . '/view/' . $result['id'] . '">' . $result['titel'] . '</a></li>';
    }
    $t .= '</>';
    $temp->setContent('###SEARCHRESULT###', $t);
}

$temp->display();
?>
