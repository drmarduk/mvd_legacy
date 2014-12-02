<?php

/*
 * VIEW
 * 
 * Erstellt die Anzeige eines Liedstückes
 */
$id = intval($_GET['id']);
$temp = new template('view');

$v = new view($id);

$temp->setContent('###TITEL###', $v->titel);
$temp->setContent('###KOMPONIST###', $v->komponist);
$temp->setContent('###GENRE###', $v->genre);
$temp->setContent('###GESANG###', $v->gesang > 0 ? 'ja' : 'nein');
$temp->setContent('###YEAR###', $v->year);
$temp->setContent('###REPERTOIRE###', $v->repertoire > 0 ? 'ja' : 'nein');
$temp->setContent('###REPERTOIRENUMBER###', $v->repertoirenumber);
$temp->setContent('###SCHRANK###', $v->schrank);
$temp->setContent('###ID###', $id);

$htmltitlerating = NULL;
for($i = 1; $i <= $v->score; $i++) {
	$htmltitlerating .= '<a href="###URL###/rating/1/'.$id.'/0/'.$i.'"><img width="8" src="/musikverein/pics/rating.png" alt="'. $i.'" /></a>';
}
for (; $i <= 5; $i++) {
	$htmltitlerating .= '<a href="###URL###/rating/1/'.$id.'/0/'.$i.'"><img width="8" src="/musikverein/pics/rating2.png" alt="'. $i.'" /></a>';
}



$stimmen = '';
$stimmenliste = db_function::getStimmen();
foreach ($stimmenliste as $stimme) {
    $files = $v->getPdf($stimme['id']);
    if (!empty($files)){
    	$htmlrating = '';
    	for($i = 1; $i <= $files['score']; $i++) {
    		$htmlrating .= '<a href="###URL###/rating/2/'.$id.'/'.$stimme['id'].'/'.$i.'"><img width="8" src="/musikverein/pics/rating.png" alt="'. $i.'" /></a>';
    	}
    	for (; $i <= 5; $i++) {
    		$htmlrating .= '<a href="###URL###/rating/2/'.$id.'/'.$stimme['id'].'/'.$i.'"><img width="8" src="/musikverein/pics/rating2.png" alt="'. $i.'" /></a>';
    	}
        $stimmen .= '<li><a href="' . URL . '/pdf/' . $files['filename'] . '">' . $stimme['namen'] . '</a>              '. $htmlrating.'</li>';
    }
}

$temp->setContent('###STIMMEN###', $stimmen);
$temp->setContent('###TITLERATING###', $htmltitlerating);
$temp->setContent('###URL###', URL);
$temp->display();
?>
