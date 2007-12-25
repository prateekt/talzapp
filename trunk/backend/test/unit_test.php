<?php

include_once '/home2/mvldorg/public_html/fb/db_manager/dbmanager.php';
include_once '../backend.php';

$backend = new Backend();

//dummy data and add to database
$userId = "102";
$friendList = "101,103,104,105,106";
$backend->dbManager->addEntry($userId, $friendList);

//dummy data and add to database
$userId = "103";
$friendList = "101,102,105,132";
$backend->dbManager->addEntry($userId, $friendList);

//dummy data and add to database
$userId = "104";
$friendList = "101,102,105,132";
$backend->dbManager->addEntry($userId, $friendList);

$uid = "101";
$fList[0]  = '102';
$fList[1]  = '103';
$fList[2]  = '104';

$result = $backend->getFriendRec($uid, $fList);
echo "Result: <BR>";
foreach($result as $frec => $count) {
	echo $frec . " " . $count . "<BR>";
}

//clean up db
$result1 = $backend->dbManager->deleteEntry("101");
$result2 = $backend->dbManager->deleteEntry("102");
$result3 = $backend->dbManager->deleteEntry("103");
$result4 = $backend->dbManager->deleteEntry("104");
if($result1 && $result2 && $result3 && $result4) {
	echo "Cleanup Successful";
}
else {
	echo "r1: " . $result1 . "<BR>";
	echo "r2: " . $result2 . "<BR>";
	echo "r3: " . $result3 . "<BR>";
	echo "r4: " . $result4 . "<BR>";
}

?>