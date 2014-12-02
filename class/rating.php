<?php

class rating {
	
	public function setratingfiles($stimmen_id, $noten_id, $rating) {
		db_function::setratingfiles($noten_id, $stimmen_id, $rating);
	}
	
	public function setratingnoten($noten_id, $rating) {
		db_function::setratingtitle($noten_id, $rating);
	}
	
}
?>