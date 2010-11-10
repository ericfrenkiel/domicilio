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
			$row_array = array();
        	$row_array['value'] = $row['id'];
	        $row_array['name'] = $row['name'];
	 
	        array_push($return_arr,$row_array);		
		}

	    header("Content-type: application/json");
		echo json_encode($return_arr);
	} catch(PDOException $e){
		die ($e->getMessage());
	}	 		
?>