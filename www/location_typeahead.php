<?php 
	$db = new PDO('mysql:host=localhost;dbname=thedom_info', 'thedom_thedom', 'ETP+}fViQKK_');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (!$db) {
		die ('cannot connect to database');	
	}

	$q = $_GET['q'];
	try {
		$prepared_statement = $db->prepare('select id, name from locations where name like :q');
		$prepared_statement->execute(array(':q' => $q.'%'));
		
		while ($row = $prepared_statement->fetch()) {
			echo $row[name].'|'.$row[id];
			echo '<br>';
		}
	} catch(PDOException $e){
		die ($e->getMessage());
	}	 		
?>