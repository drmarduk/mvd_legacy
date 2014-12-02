<?php

    /*
     * INDEX
     *
     * Erstellt die Index Seite mit einer Liste aller vorhandenen Noten
     */

     $tmp_index = new template('index');

     // Inhalt setzen
     $noten_count = db_function::getNotenCount();
     $noten = db_function::getRepertoire();
     $tmp_index->setContent('###COUNT###', $noten_count['count']);
     $liste = '';


     for($i = 0; $i < count($noten); $i++) {
         $liste .= '<li><a href="'. URL .'/view/'. $noten[$i]['id'] .'">' . $noten[$i]['titel'] .'</a></li>';
     }
     $tmp_index->setContent('###NOTENLISTE###', $liste);


     $tmp_index->display();

?>
