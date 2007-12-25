<?php

include_once '../dbmanager.php';

$dbm = new DbManager();

//Addition Test
$addResult = $dbm->addEntry($userId, $friendsList);
if($addResult)
	echo "Addition test successful.<BR><BR>";
else
	echo "Addition test failed.<BR><BR>";

//Friend List
$list = $dbm->getFriendsList($userId);
echo "Contents of Friends List:<BR>";
foreach($list as $elem) {
	echo $elem . "<BR>";
}
echo "<BR>";

//clean up
$clean = $dbm->deleteEntry($userId);
if($clean)
	echo "Cleanup successful.";
else
	echo "Cleanup failed.";

?>