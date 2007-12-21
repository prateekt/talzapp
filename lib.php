<?php

/*
 * Returns the String name of a facebook user, given their user id.
 * 
 * @param $id - The id number associated with the user.
 * @return The String name associated with the user having that id.
 */
/*function getName($id) {
  return '<fb:profile-action url="' . $GLOBALS['facebook_location'] . '?to=' . $id . '">'
       .   '<fb:name uid="' . $id . '" firstnameonly="true" capitalize="true"/> '
       .   'has been stepped on ' . $num . ' times.'
       . '</fb:profile-action>';
}*/

function getEvents($id) {
	global $facebook;

	$fqlQuery = "SELECT eid, name, tagline, nid, pic, pic_big, pic_small, host, description,
		   event_type, event_subtype, start_time, end_time, creator, update_time,
		   location, venue FROM event";
		   	$array = $facebook->api_client->fql_query($fqlQuery);
	echo "DONE";
	if($array == NULL) {
		echo "There are no friends on the list.";
	}
	else {
		echo "THERE IS DATA<br>";
		foreach($array as $elem)  {
			echo $elem['name'] . "<BR>";
		}
	}
}

function getFriendsList($id) {
	global $facebook;
	
	echo "ID: " . $id;
	//$fqlQuery = "SELECT uid2 FROM friend WHERE uid1=" . $id;
	//$fqlQuery = "SELECT uid2 FROM friend";
//	$fqlQuery = "SELECT uid, fields FROM user WHERE uid IN (".$id.")";
	$result = $facebook->api_client->call_method("facebook.friends.get","");
//	$array = $facebook->api_client->fql_query($fqlQuery);
	echo "DONE";
	if($result == NULL) {
		echo "There are no friends on the list.";
	}
	else {
		echo "THERE IS DATA<br>";
		$fql2 = "SELECT name FROM user WHERE uid IN (";
		$x=0;
		$array = array();
		foreach($result as $elem) {
			$fql2 = $fql2 . $elem . ",";
			$x++;
			if($x != 600) {
			}
			else {
				$fql2 = substr($fql2,0,-1);
				$fql2 = $fql2 . ")";
				echo $fql2 . "<BR><BR>";

				$result2 = $facebook->api_client->fql_query($fql2);
//				$array = array_merge($array,$result2);
//				$x=0;
				$fql2 = "SELECT name FROM user WHERE uid IN (";
				foreach($result2 as $elem2) {
					echo $elem2['name']. "<BR>";
				}
			}
		}

	}
}						

?>