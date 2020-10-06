<?php
$page = $_SERVER['PHP_SELF'];
$sec = "3";
header("Refresh: $sec; url=$page");

$rand = rand(1,10);
echo $rand;
if($rand>5)
	die();
?>