<?php

include_once 'dbconstants.php';

/*
 * The DBManager class encapsulates the logic of interacting with the MySQL database. The main methods you
 * need to worry about are addEntry (allows you to add data to the  database) and getFriendsList() which
 * allows information retrival.
 */
class DBManager {

	/*
	 * The socket connection object to the mysql database.
	 */
	var $dbCon;
	
	/*
	 * Constructor for a DBManager. Simply initializes $dbConnection, attempting to login.
	 * If login fails, $dbConnection will be  null.
	 */
	function DBManager() {
		$this->dbCon = $this->login();
	}

	/*
	 * Function used to login to mysql database with parameters (username, password, etc) specified
	 * in dbconstants file. Returns a connection object if connection could be created. It returns null
	 * otherwise.
	 *
	 * @return A connection object or null.
	 */
	function login() {
		$connection=mysql_connect ($GLOBALS['db_ip'], $GLOBALS['username'], $GLOBALS['password']); 
		if(!$connection) {
			return NULL;
		}
		$dbSelected = mysql_select_db ($GLOBALS['db_name'], $connection);
		if(!$dbSelected) {
			mysql_close($connection);
			return NULL;
		}
		return $connection;
	}
		
	/*
	 * Deletes an entry from the FriendsTable. An entry consists of a user id and the user's friends list as a
	 * comma-separated string. Returns true if the deletion operation is successful.
	 *
	 * @param $userId - the id of the user
	 * @return true or false depending on whether the deletion to the database is successful.
	 */
	function deleteEntry($userId) {
		$dbConnection = $this->dbCon;
		$userId = mysql_escape_string($userId);
		if($dbConnection==NULL)
			return false; //obviously, if the connection is not up, it can't delete the entry.
		$query = "DELETE FROM ".$GLOBALS['ftable_name']." WHERE UserId='".$userId."'"; 
		$result = mysql_query($query, $dbConnection);
		return $result;
	}
	
	/*
	 * Adds an entry to the FriendsTable. An entry consists of a user id and the user's friends list as a
	 * comma-separated string. Returns true if the addition operation is successful.
	 *
	 * @param $userId - the id of the user
	 * @param $fList - the list of friends attached to the user
	 * @return true or false depending on whether the addition to the database is successful.
	 */
	function addEntry($userId, $fList) {
		$dbConnection = $this->dbCon;
		$userId = mysql_escape_string($userId);
		if($dbConnection==NULL) {
			return false; //obviously, if the connection is not up, it can't add the entry.
		//get rid of entry if already exists. If entry doesn't exist previously,
		//this statement has really no effect.
		}
		$this->deleteEntry($userId);
		
		$friendList = "";
		foreach($fList as $elem) {
			$friendList = $friendList . $elem . "**";
		}
		
		$friendList = mysql_escape_string($friendList);
		$query = "INSERT INTO ".$GLOBALS['ftable_name']." (UserId, FriendsList) VALUES ('".$userId. "', '".$friendList."')";
		$result = mysql_query($query, $dbConnection);
		return $result;
	}
	
	/*
	 * Returns the list of friend ids stored with a user as an array of String objects, each element
	 * being a different friend user id. Returns empty list if operation is unsuccessful of if user
	 * to friend mapping does not exist.
	 *
	 * @param $userId - The user to get the friends list of
	 * @return friends list as a string array or empty array.
	 */
	function getFriendsList($userId) {
		$dbConnection = $this->dbCon;
		$rtn = array();
		if($dbConnection==NULL)
			return array(); //obviously, if the connection is not up, it can't get the friends list.
		$userId =  mysql_escape_string($userId);
		$query = "SELECT FriendsList FROM ".$GLOBALS['ftable_name']." WHERE UserId='".$userId."'";
		$result = mysql_query($query, $dbConnection);
	
		//if query fails, return empty array.
		if(!$result) {
			return $rtn;
		}
		else {
			//put friends list into array of strings.
			$friendsListArr = mysql_fetch_array($result);
			$friendsListStr = $friendsListArr[0];
			$tok = strtok($friendsListStr, "**");
			$index=0;
			while($tok!== false) {
				$rtn[$index] = $tok;
				$tok = strtok("**");
				$index++;
			}		
			return $rtn;
		}
	}
}

?>