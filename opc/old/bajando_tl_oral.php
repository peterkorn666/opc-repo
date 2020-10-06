<?php 
$id = $_GET['id'];
$tema = $_GET['tema'];
$enlace = "oral_tl/$tema/".$id; 
header ("Content-Disposition: attachment; filename=".$id); 
header ("Content-Type: application/octet-stream"); 
header ("Content-Length: ".filesize($enlace)); 
readfile($enlace); 

?> 
