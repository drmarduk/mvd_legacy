<?php

if(isset($_GET['rating'])) {
	$noten_id = $_GET['noten_id'];
	$stimmen_id = $_GET['stimmen_id'];
	$rating = $_GET['rating'];

	$r = new rating();
	if($_GET['s'] == '2'){
		$r->setratingfiles($stimmen_id, $noten_id, $rating);
	}
	if($_GET['s'] == '1')
	{
		$r->setratingnoten($noten_id, $rating);
	}
	header('Location: /musikverein/view/' .$noten_id);
}

?>