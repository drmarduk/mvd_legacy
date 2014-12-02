<?php


class mysql {

	/**
	*  	Referenz auf die DB connection
	*/
	private static $db;


	/**
	*	Methode erzeugt die DB verbindung und speichert sie in static $db. Die instanz ist Singleton
	*
	*/
	static public function getInstance() {
		if(!self::$db) {
			self::$db = new PDO(
				'mysql:host='.DB_HOST.';dbname='.DB_DB.';port='.DB_PORT,
				DB_USER,
				DB_PASS,
				array(
					PDO::ATTR_PERSISTENT => true,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
				)
			);
		}
		return self::$db;
	}
}


//Beispiel:


/*

		$params[':name'] = 'nut';	// variablen für die sql abfrage

		$sql = "SELECT id,name,pass FROM test WHERE name= :name "; 			// Query zusammenbasteln
		$stmt = mysql::getInstance()->prepare($sql);
		$stmt->execute($params);  						// Hier wird der query abgeschickt und die parameter eingesezt

		// enthält die anzahl der betroffenen datensätze.
		$stmt->rowCount();

		// ausgabe
		while ($row = $stmt->fetch()){
			echo $row['id'];
			echo $row['name'];
			echo $row['pass'];
		}


*/

?>
