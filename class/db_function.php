<?php

/*
 * To change this template, choose Tools | Templates
* and open the template in the editor.
*/

class db_function {

	public function __construct() {

	}

	/*
	 * Fügt Noten in die DB ein
	* $titel ist der Notentitel
	* $genre ein wählbares Genre, ist Fremdschlüssel zwiscen 1...x
	* $komponist sollte Fremdschlüssel sein, need to be done
	* $gesang Bool 0 kein gesagn, 1 gesang
	*/

	public static function insertNoten($titel, $genre, $year, $komponist, $gesang, $isrepertoire, $repertoirenumber, $schrank) {
		$params[':titel'] = $titel;
		$params[':genre'] = $genre;
		$params[':year'] = $year;
		$params[':komponist'] = $komponist;
		$params[':gesang'] = $gesang;
		$params[':isrepertoire'] = $isrepertoire;
		$params[':repertoirenumber'] = $repertoirenumber;
		$params[':schrank'] = $schrank;
		$sql = 'INSERT INTO noten (titel, genre, year, komponist, gesang, isrepertoire, repertoirenumber, schrank) VALUES (:titel, :genre, :year, :komponist, :gesang, :isrepertoire, :repertoirenumber, :schrank)';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);

		$params = array();
		$params[':titel'] = $titel;
		$params[':komponist'] = $komponist;
		$params[':genre'] = $genre;
		$params[':gesang'] = $gesang;
		$sql = 'SELECT id FROM noten WHERE titel = :titel AND komponist = :komponist AND genre = :genre AND gesang = :gesang LIMIT 0,1';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
		$fetch = $stmt->fetch();

		return $fetch['id'];
	}

	public static function insertFile($titelid, $stimmenid, $filename) {
		$params[':titel_id'] = $titelid;
		$params[':stimmen_id'] = $stimmenid;
		$params[':filename'] = $filename;
		$sql = 'INSERT INTO files (noten_id, stimmen_id, filename) VALUES (:titel_id, :stimmen_id, :filename)';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function updateNoten($id, $titel, $genre, $year, $komponist, $gesang, $isrepertoire, $repertoirenumber, $schrank) {
		$params[':id'] = $id;
		$params[':titel'] = $titel;
		$params[':genre'] = $genre;
		$params[':year'] = $year;
		$params[':komponist'] = $komponist;
		$params[':gesang'] = $gesang;
		$params[':isrepertoire'] = $isrepertoire;
		$params[':repertoirenumber'] = $repertoirenumber;
		$params[':schrank'] = $schrank;
		$sql = 'UPDATE noten SET titel = :titel, genre = :genre, year = :year, komponist = :komponist, gesang = :gesang, isrepertoire = :isrepertoire, repertoirenumber = :repertoirenumber, schrank = :schrank WHERE id = :id';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	/*
	 * Gibt ein Notensatz aus, anhand der ID wählbar
	*/

	public static function getNoten($id) {
		$params[':id'] = $id;
		//$sql = 'SELECT * FROM noten WHERE id = :id LIMIT 0,1';
		$sql = 'SELECT noten.id as id, noten.titel as titel, noten.genre as genreid, noten.year as year, noten.komponist as komponist, noten.gesang as gesang, noten.isrepertoire as isrepertoire, noten.repertoirenumber as repertoirenumber, genre.id as genreid2, genre.genre as genre, noten.schrank as schrank, noten.score as score FROM noten JOIN genre ON noten.genre = genre.id WHERE noten.id = :id LIMIT 0,1';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
		$fetch = $stmt->fetch();

		return $fetch;
	}

	/*
	 * Gibt ein Array mit allen Noten aus
	* may be huge
	*/

	public static function getallNoten() {
		$sql = 'SELECT * FROM noten';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function getRepertoire() {
		$sql = 'SELECT * FROM noten WHERE isrepertoire = 1';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function getRepertoireCount() {
		$sql = 'SELECT COUNT(*) as count FROM noten WHERE isrepertoire = 1';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = $stmt->fetch();
		return $return['count'];
	}

	public static function getStimmen($sorted = TRUE) {
		$sql = 'SELECT * FROM stimmen';
		if ($sorted) {
			$sql = 'SELECT * FROM stimmen WHERE rank > 0 ORDER BY rank ASC';
		}
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function getStimme($id) {
		$params[':id'] = $id;
		$sql = 'SELECT * FROM stimmen WHERE id = :id';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);

		$fetch = $stmt->fetch();
		return $fetch;
	}

	public static function getStimmeCount() {

		$sql = 'SELECT COUNT(*) as count FROM stimmen';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$fetch = $stmt->fetch();
		return $fetch;
	}

	public static function insertStimme($stimme) {
		$params[':stimme'] = $stimme;
		$sql = 'INSERT INTO stimmen (id, namen) VALUES (NULL, :stimme)';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function updateStimme($id, $stimme) {
		$params[':id'] = $id;
		$params[':stimme'] = $stimme;
		$sql = 'UPDATE stimmen SET namen = :stimme WHERE id = :id';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function deleteStimme($id) {
		$params[':id'] = $id;
		$sql = 'DELETE FROM stimmen WHERE id = :id';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function getPdf($noten_id, $stimmen_id) {
		$params[':noten_id'] = $noten_id;
		$params[':stimmen_id'] = $stimmen_id;
		$sql = 'SELECT * FROM files WHERE noten_id = :noten_id AND stimmen_id = :stimmen_id LIMIT 0,1';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
		$fetch = $stmt->fetch();

		return $fetch;
	}

	public static function getPdfCount() {
		$sql = 'SELECT COUNT(*) as count FROM files';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
		$fetch = $stmt->fetch();
		return $fetch;
	}

	/*
	 * Anzahl der Noten in der Datenbank
	*/

	public static function getNotenCount() {
		$sql = 'SELECT COUNT(*) as count FROM noten';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
		$fetch = $stmt->fetch();

		return $fetch;
	}

	/*
	 * Liestet alle Genre auf
	*/

	public static function getGenres() {
		$sql = 'SELECT id, genre FROM genre';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function getGenreusage() {
		$sql = 'SELECT COUNT( noten.genre ) AS count, genre.genre, genre.id
		FROM noten, genre
		WHERE noten.genre = genre.id
		GROUP BY noten.genre';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	/*
	 * Gibt ein spezielles Genre zurk�ck
	*/

	public static function getGenre($id) {
		$params[':id'] = $id;
		$sql = 'SELECT id, genre FROM genre WHERE id = :id';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);

		$fetch = $stmt->fetch();
		return $fetch;
	}

	public static function getGenreCount() {

		$sql = 'SELECT COUNT(*) as count FROM genre';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$fetch = $stmt->fetch();
		return $fetch;
	}

	/*
	 * Gibt die Noten eines Liedes mit @titel zurueck
	*/

	public static function searchTitle($title) {
		$params[':title'] = $title;
		$sql = 'SELECT * FROM noten WHERE titel = :title';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	/*
	 * Gibt die Noten eines Komponisten aus
	*/

	public static function searchKomponist($komponist) {
		$params[':komponist'] = $komponist;
		$sql = 'SELECT * FROM noten WHERE komponist = :komponist';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	// TODO muss gemacht werden, etwas aetzend wegen fremdschluessel und so lol
	// SELECT * FROM `noten` WHERE genre = (select id from genre where genre = "Polka")
	// select * from noten join genre on noten.genre = genre.id where genre.genre = "Polka" 0.0003 sek
	public static function searchGenre($genre) {
		$params[':genre'] = $genre;
		$sql = 'SELECT * FROM noten JOIN genre ON noten.genre = genre.genre WHERE genre.genre = :genre';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function searchYear($year) {
		$params[':year'] = $year;
		$sql = 'SELECT * FROM noten WHERE year = :year';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function searchGesang() {
		$sql = 'SELECT * FROM noten WHERE gesang = 1';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function searchRepertoire() {
		$sql = 'SELECT * FROM noten WHERE isrepertoire = 1';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	/*
	 * gibt es den User?
	*/

	public static function checkLogin($name) {
		$params[':name'] = $name;
		$sql = "SELECT * FROM user WHERE user = :name";
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
		$fetch = $stmt->fetch();

		return $fetch;
	}

	public static function deleteNoten($id) {
		$params[':id'] = $id;
		$sql = 'DELETE FROM noten WHERE id = :id';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function deleteFile($noten_id, $stimmen_id, $filename) {
		$params[':noten_id'] = $noten_id;
		$params[':stimmen_id'] = $stimmen_id;
		$params[':filename'] = $filename;
		$sql = 'DELETE FROM files WHERE noten_id = :noten_id AND stimmen_id = :stimmen_id AND filename = :filename';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function lastInsertedPDF() {
		$sql = "SELECT value FROM options WHERE `option` = 'lastinserted'";
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
		$fetch = $stmt->fetch();

		return $fetch;
	}

	public static function updatelastInsertedPDF($value) {
		$params[':value'] = $value;
		$sql = "UPDATE options SET value = :value WHERE `option` = 'lastinserted'";
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function lastInsertedStimme() {
		$sql = "SELECT value FROM options WHERE `option` = 'laststimme'";
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
		$fetch = $stmt->fetch();

		return $fetch;
	}

	public static function updatelastInsertedStimme($value) {
		$params[':value'] = $value;
		$sql = "UPDATE options SET value = :value WHERE `option` = 'laststimme'";
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function getRangeNoten($von, $limit) {
		$start = intval($von);
		$limit = intval($limit);
		$sql = 'SELECT * FROM noten LIMIT ' . $start . ',' . $limit;
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}
		return $return;
	}

	public static function test() {
		$sql = 'SELECT COUNT( noten.titel ) AS count, noten.id, noten.titel, genre.genre, noten.year, noten.komponist, noten.gesang, noten.isrepertoire, noten.repertoirenumber, noten.schrank, stimmen.namen, files.filename FROM noten, genre, files, stimmen WHERE noten.genre = genre.id AND noten.id = files.noten_id AND stimmen.id = files.stimmen_id GROUP BY noten.titel ORDER BY count';

		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$return = array();
		while ($fetch = $stmt->fetch()) {
			$return[] = $fetch;
		}

		return $return;
	}

	public static function maxStimmenproNotensatz() {
		$sql = 'SELECT COUNT( noten_id ) AS count, noten.titel, noten.id
		FROM files, noten
		WHERE noten.id = files.noten_id
		GROUP BY files.noten_id
		ORDER BY count DESC
		LIMIT 0 , 5
		';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
		$result = array();
		while ($fetch = $stmt->fetch()) {
			$result[] = $fetch;
		}
		return $result;
	}

	public static function minStimmenproNotensatz() {
		$sql = 'SELECT COUNT( noten_id ) AS count, noten.titel, noten.id
		FROM files, noten
		WHERE noten.id = files.noten_id
		GROUP BY files.noten_id
		ORDER BY count ASC
		LIMIT 0 , 5
		';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
		$result = array();
		while ($fetch = $stmt->fetch()) {
			$result[] = $fetch;
		}
		return $result;
	}


	public static function query($sql) {
		$sql = addslashes($sql);
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();

		$result = array();
		while ($fetch = $stmt->fetch()) {
			$result[] = $fetch;
		}

		return $result;
	}

	public static function deletequery($from, $where) {
		$sql = addslashes('DELETE FROM '.$from.' WHERE '.$where);
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
	}

	public static function insertquery($sql) {
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute();
	}

	public static function setratingfiles($noten_id, $stimmen_id, $rating) {
		$params[':noten_id'] = intval($noten_id);
		$params[':stimmen_id'] = intval($stimmen_id);
		$params[':rating'] = intval($rating);
		$sql = "UPDATE files SET score = :rating WHERE `noten_id` = :noten_id AND `stimmen_id` = :stimmen_id";
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}

	public static function setratingtitle($noten_id, $rating) {
		$params[':noten_id'] = intval($noten_id);
		$params[':rating'] = intval($rating);
		$sql = 'UPDATE noten SET score = :rating WHERE `id` = :noten_id';
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);
	}
}

?>
