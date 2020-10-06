<?php
$prueba = "hola mundo";
$pos_mundo = strpos($prueba, "mundo");
echo $pos_mundo;
$prueba[$pos_mundo] = "";
$prueba[$pos_mundo+1] = "";
$prueba[$pos_mundo+2] = "";
$prueba[$pos_mundo+3] = "";
$prueba[$pos_mundo+4] = "";
echo $prueba;
?>