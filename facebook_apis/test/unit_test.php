<?php

include_once '../FBInterface.php';

$fb =  new FBInterface();

$x=0;
$list = "";

$list = $fb->getFIDsList();
$result = $fb->getFriendNames($list,450);

foreach($result as $elem) {
	echo $elem . "<BR>";
}

?>