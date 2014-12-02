<?php

include 'includes/config.php';
include 'includes/error_reporting.php';
include 'includes/autoload.php';
include 'includes/functions.php';


// http://www.xup.in/dl,79081532/musikverein.zip/
// index.php?mode=(index|insert|view|login|...)

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'index';

switch ($mode) {
    case 'index':
        include 'construct/index.php';
        break;

    case 'info':
        include 'construct/info.php';
        break;

    case 'insert':
        include 'construct/insert.php';
        break;

    case 'view':
        include 'construct/view.php';
        break;

    case 'login':
        include 'construct/login.php';
        break;

    case 'search':
        include 'construct/search.php';
        break;

    case 'edit':
        include 'construct/edit.php';
        break;

    case 'delete':
        include 'construct/delete.php';
        break;

    case 'upload':
        include 'construct/upload.php';
        break;

    case 'input':
        include 'construct/input.php';
        break;

    case 'sort':
        include 'construct/sort.php';
        break;

    case 'stimmen':
        include 'construct/stimmen.php';
        break;

    case 'list':
        include 'construct/listing.php';
        break;

    case 'stats':
        include 'construct/statistik.php';
        break;

    case 'planer':
        include 'construct/planer.php';
        break;
        
    case 'rating':
    	include 'construct/rating.php';
    	break;
}
?>


