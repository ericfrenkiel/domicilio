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
		
		$return_arr = array();
		while ($row = $prepared_statement->fetch()) {
        	$row_array[0] = $row['id'];
	        $row_array[1] = $row['name'];
	 
	        array_push($return_arr,$row_array);		}
		
		echo json_encode($return_arr);
	} catch(PDOException $e){
		die ($e->getMessage());
	}	 		
?>