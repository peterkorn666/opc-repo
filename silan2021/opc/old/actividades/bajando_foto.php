<?php 
/*$id = $_GET['id'];
$enlace = "fotos/".$id; 
header ("Content-Disposition: attachment; filename=".$id); 
header ("Content-Type: application/octet-stream"); 
header ("Content-Length: ".filesize($enlace)); 
readfile($enlace); */
    $f = $_GET["id"];
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$f\"\n");
    $fp=fopen("$f", "r");
    fpassthru($fp);

?> 
