<?php
session_start();
unset($_SESSION["abstract"]);
header("Location: index.php");
?>