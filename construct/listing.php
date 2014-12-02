<?php

$page = 1;
// TITEL-Count(stimmen)-Genre-Komponist-Complete-Jahr
if (isset($_GET['page'])) {
    $page = intval($_GET['page']);
}
$list = new listing($page);
$temp = new template('list');


$entries = $list->getEntries();

$entries = $list->test();

$htmlentries = NULL;
foreach ($entries as $e) {
//    $htmlentries .= '<li>' . $e['titel'] . '<div class="year">' . $e['year'] . '</div></li>';
//    $htmlentries .= '<li>' . $e['titel'] . '<div class="year">' . $e['year'] . '</div></li>';
//    $htmlentries .= '<li><a href="###URL###/view/' . $e['id'] . '">' . $e['titel'] .  '</li>';
    $htmlentries .=
            format::htmldiv(
                    format::htmldiv('<a href="###URL###/view/' . $e['id'] . '">' . $e['titel'] . '</a>') .
                    format::htmldiv($e['count']) . format::htmldiv($e['genre']) .
                    format::htmldiv(format::bool2str($e['isrepertoire'])) .
                    format::htmldiv($e['repertoirenumber']) .
                    format::htmldiv($e['schrank']) .
                    format::htmldiv($e['komponist']), 'notensatz');
}

$temp->setContent('###ROWS###', $htmlentries);
$temp->setContent('###URL###', URL);
$temp->display();
?>
