<?php

// the facebook client library
include_once 'facebook-php-platform/php4client/facebook.php';

// some basic library functions
include_once 'lib.php';

// this defines some of your basic setup
include_once 'constants.php';

$facebook = new Facebook($api_key, $secret);
$facebook->require_frame();
$user = $facebook->require_login();

$result = $facebook->api_client->friends_get($user);
$count=0;
echo "HELLO";

foreach($result as $elem) {
	echo "elem: " . $elem .  "<BR>";
	if($count=0) {
		$result1 = $facebook->api_client->friends_get($elem);
		if($result==NULL) {
			echo "<BR>no data";
		}
		else  {			
			foreach($result1 as $elem1) {
				echo $elem1 . "<BR>";
			}
		}
	}
	$count++;
}

//echo "Hello World";
//getFriendsList($user);

?>