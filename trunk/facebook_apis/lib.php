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
	$result = $facebook->api_client->call_method("facebook.friends.get","");
	
/*	$array = array();
	$fql2 = "SELECT name FROM user WHERE uid IN (102139)";	
	$result2 = $facebook->api_client->fql_query($fql2);
	$array = array_merge($array,$result2);
	$fql2 = "SELECT name FROM user WHERE uid IN (200339)";	
	$result2 = $facebook->api_client->fql_query($fql2);
	$array = array_merge($array,$result2);
	foreach($array as $elem){
		echo $elem['name'];
	}*/

	if($result == NULL) {
		echo "There are no friends on the list.";
	}
	else {
		echo "THERE IS DATA<br>";
		
		//calculate length of results array
		/*$length = 0;
		$paramsStr = array();
		foreach($result as $elem) {
			$length++;
		}
		
		echo "<BR>LENGTH: " . $length . "<BR>";
		
		//init fields		
		$fields = array();
		$fields[0] = "name";
		$params['fields'] = $fields;

		$x=0;
		$totalCount=0;
		$array = array();
		foreach($result as $elem) {
			$paramsStr[$x] = $elem;
			$x++;
			$totalCount++;
			if($x==500 /*|| ($x!=0 && $totalCount==500)*/ //) {
			/*	echo "ENTERED<BR>";
				$params['uids'] =  $paramsStr;
				$result2 = $facebook->api_client->call_method("facebook.users.getInfo",$params);
				foreach($result2 as $elem2) {
					echo $elem2['name']. "<BR>";
				}
				$x=0;
				$paramsStr = array();
			}
		}*/
						
		//init
		$x=0;
		$totalCount=0;
		$array = array();
		$fql2 = "SELECT name FROM user WHERE uid IN (";
		
		foreach($result as $elem) {
			$fql2 = $fql2 . $elem . ",";
			$x++;
			$totalCount++;
			if($x == 100 && $totalCount < 650) {
				$fql2 = substr($fql2,0,-1);
				$fql2 = $fql2 . ")";
				echo $fql2 . "<BR><BR>";

				$result2 = $facebook->api_client->fql_query($fql2);
				$array = array_merge($array,$result2);
				$x=0;
				$fql2 = "SELECT name FROM user WHERE uid IN (";
				foreach($result2 as $elem2) {
					echo $elem2['name']. "<BR>";
				}
			}
		}
	}
}						

?>