<?php

// the facebook client library
include_once '../php4client/facebook.php';

// some basic library functions
include_once 'lib.php';

// this defines some of your basic setup
include_once 'constants.php';

$facebook = new Facebook($api_key, $secret);
$facebook->require_frame();
$user = $facebook->require_login();

echo "Hello World";
getFriendsList($user);

?>