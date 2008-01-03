<?php

// the facebook client library
include_once 'facebook-php-platform/php4client/facebook.php';

// this defines some of your basic setup
include_once 'constants.php';

/*
 * Wrapper for facebook api methods. This helps isolate the functionality we need from the api client.
 */
class FBInterface {
	
	/*
	 * Facebook API client.
	 */
	var $facebook;
	
	/*
	 * User object returned when user logs in. Contains user's session id.
	 */
	var $user;
	
	/*
	 * Constructor for FBInterface. Simply requires the user to login so that their data can be accessed.
	 */
	function FBInterface() {
		$this->facebook = new Facebook($GLOBALS['api_key'], $GLOBALS['secret']);
		$this->facebook->require_frame();
		$this->user = $this->facebook->require_login();
	}
	
	/*
	 * Returns a list of the user's friend ids as an array.
	 */
	function getFIDsList() {
		return $this->facebook->api_client->friends_get($this->user);
	}
	
	/*
	 * Converts a list of user ids to a list of actual names. The max num limit there is to prevent overflow on the facebook servers.
	 * They impose a limit of about 500 in their queries.
	 *
	 * @param $uids - the list of user ids to convert
	 * @param $max_num - the maximum number
	 * @return a list of size less than or equal to $max_num of names that map to uids
	 */
	function getFriendNames($uids, $max_num) {
		$fields[0] = 'first_name';
		$fields[1] = 'last_name';
		foreach($uids as $elem) {
			if($x < $max_num) {
				$list[$x] = $elem;
			}
			$x = $x + 1;
		}
		$names = $this->facebook->api_client->users_getInfo($list, $fields);
		$x=0;
		foreach($names as $elem) {
			$result[$x] = $elem['first_name'] . " " . $elem['last_name'];
			$x = $x + 1;
		}
		return $result;
	}
}
?>