<?php


$temp = new template('statistik');
$s = new statistik();

$m = $s->maxStimmenproNotensatz();
$x = $s->minStimmenproNotensatz();
$g = $s->frequencyGenre();

$temp->setContent('###1###', $s->notentotal());
$temp->setContent('###2###', $s->notenrepertoire());
$temp->setContent('###3###', $s->genretotal());
$temp->setContent('###4###', $s->filestotal());
$temp->setContent('###5###', round($s->filestotal() / $s->notentotal(), 2));
$temp->setContent('###22###', $s->stimmentotal());
// MAX stimmenn
$top1 = '<a href="###URL###/view/'.$m[0]['id'].'">'.$m[0]['titel'].'</a> - '. $m[0]['count'] .' ';
$top2 = '<a href="###URL###/view/'.$m[1]['id'].'">'.$m[1]['titel'].'</a> - '. $m[1]['count'] .' ';
$top3 = '<a href="###URL###/view/'.$m[2]['id'].'">'.$m[2]['titel'].'</a> - '. $m[2]['count'] .' ';
$top4 = '<a href="###URL###/view/'.$m[3]['id'].'">'.$m[3]['titel'].'</a> - '. $m[3]['count'] .' ';
$top5 = '<a href="###URL###/view/'.$m[4]['id'].'">'.$m[4]['titel'].'</a> - '. $m[4]['count'] .' ';
//min stimmen
$flop1 = '<a href="###URL###/view/'.$x[0]['id'].'">'.$x[0]['titel'].'</a> - '. $x[0]['count'] .' ';
$flop2 = '<a href="###URL###/view/'.$x[1]['id'].'">'.$x[1]['titel'].'</a> - '. $x[1]['count'] .' ';
$flop3 = '<a href="###URL###/view/'.$x[2]['id'].'">'.$x[2]['titel'].'</a> - '. $x[2]['count'] .' ';
$flop4 = '<a href="###URL###/view/'.$x[3]['id'].'">'.$x[3]['titel'].'</a> - '. $x[3]['count'] .' ';
$flop5 = '<a href="###URL###/view/'.$x[4]['id'].'">'.$x[4]['titel'].'</a> - '. $x[4]['count'] .' ';

$temp->setContent('###6###', $top1);
$temp->setContent('###7###', $top2);
$temp->setContent('###8###', $top3);
$temp->setContent('###9###', $top4);
$temp->setContent('###10###', $top5);

$temp->setContent('###11###', $flop1);
$temp->setContent('###12###', $flop2);
$temp->setContent('###13###', $flop3);
$temp->setContent('###14###', $flop4);
$temp->setContent('###15###', $flop5);
$temp->setContent('###16###', $s->fileinqueue());

$temp->setContent('###18###', $s->repertoiretotal());
// genre hauefigkeit

$htmlgenre = NULL;
foreach ($g as $tmp) {
    $htmlgenre .= '<li><a href="###URL###/list/genre/'.$tmp['id'].'">'.$tmp['genre'].'</a> - '.$tmp['count'];
}
$temp->setContent('###17###', $htmlgenre);
$temp->setContent('###URL###', URL);
$temp->display();
?>
