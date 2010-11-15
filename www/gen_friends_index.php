<?php
        $require_signed=1;
        require '../lib/header.php';
        $check_ins = array();
//        var_dump($session);

        $uid = $session['uid'];
        $access_token = $session['access_token'];

//        echo curl_request("https://graph.facebook.com/search?", array(type => 'checkin', 'access_token' => $access_token, 'method' => 'GET'));
        json_decode(curl_request("https://graph.facebook.com/me/friends", array(type => 'checkin', 'access_token' => $access_token, 'method' => 'GET'))));
?>