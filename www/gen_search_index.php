<?php
//      require_once('../lib/header.php');
        $filter = array();

        $all = array();
        $initial = array();
        $id_to_address = array();

        foreach (split(',', $_GET['as_values_q']) as $l) {
                $filter[$l] = 1;
        }
        function add_filtered(&$all, $value, $name, $image = null) {
                global $web;
                global $filter;
                global $initial;
                $r = array();
                $r['name'] = $name;
                $r['value'] = $value;
                if ($image !== null)
                        $r['image'] = $image;
                $all[] = $r;
                if ($filter[$value]) {
                        $initial[] = $r;
                }
        }

	$db = new PDO('mysql:host=localhost;dbname=thedom_info', 'thedom_thedom', 'ETP+}fViQKK_');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (!$db) {
		die ('cannot connect to database');
	}

	function fill_table(&$all, $table_name, $prefix) {
		global $db;
		$st = $db->query("select id, name from $table_name");
		while ($r = $st->fetch()) {
                        add_filtered($all, $prefix.$r['id'], $r['name']);
		}
	}

	fill_table(&$all, 'locations', 'l_');
	fill_table(&$all, 'amenities', 'a_');
	add_filtered(&$all, 'b_1', 'One Bedroom');
	add_filtered(&$all, 'b_2', 'Two Bedroom');
	add_filtered(&$all, 'b_3', 'Three Bedroom');
	add_filtered(&$all, 'b_4', 'Four Bedroom');
	add_filtered(&$all, 'b_5', 'Five Bedroom');
	add_filtered(&$all, 'b_6', 'Six Bedroom');
	add_filtered(&$all, 'bm', 'Grabbed');
        add_filtered(&$all, 'me', 'Mine');

        $friends = json_decode(curl_request("https://graph.facebook.com/me/friends", array(type => 'checkin', 'access_token' => $session['access_token'], 'method' => 'GET')));

        foreach ($friends->{'data'} as $f) {
                $id = $f->{'id'};

                add_filtered(&$all, 'n_'.$f->{'id'}, 'near '.$f->{'name'}, "https://graph.facebook.com/$id/picture");
        }


        echo 'var search_index = '.Json_encode(array('items' => $all)).';';
        echo 'var search_init = '.Json_encode(array('items' => $initial)).';';
?>

