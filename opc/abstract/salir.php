<?php
//session_start();
//session_destroy();
//header("Location: index.php");

session_start();
unset($_SESSION["abstract"], $_SESSION["abstracts"]);

if($_SESSION["admin"]){

	echo  "<script type='text/javascript'>";
	echo "window.close();";
	echo "window.location = 'index.php';";
	echo "</script>";
}else{

	header("Location: index.php");
}
die();
?>