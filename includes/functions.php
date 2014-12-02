<?php

function getUser() {
    $user = '';
    if (isset($_COOKIE['user'])) {
        $user = $_COOKIE['user'];
    } else {
        $user = 'guest';
    }

    return $user;
}

function replaceUml($str) {

    $umlaute = array("/ä/", "/ü/", "/ö/");
    $code = array("&auml;", "&auml;", "&auml;");
    
    $result = preg_replace($umlaute, $code, $str);
    //$result = str_replace('ä', '&auml;', $str);
    //$result = str_replace('ö', '&ouml;', $result);
    //$result = str_replace('ü', '&uuml;', $result);

    if (DEBUG) {
        echo $result;
    }
    return $result;
}

?>
