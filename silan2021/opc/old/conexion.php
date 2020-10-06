<?php

function safes($str)
{
   $len=strlen($str);
    $escapeCount=0;
    $targetString='';
    for($offset=0;$offset<$len;$offset++) {
        switch($c=$str{$offset}) {
            case "'":
            // Escapes this quote only if its not preceded by an unescaped backslash
                    if($escapeCount % 2 == 0) $targetString.="\\";
                    $escapeCount=0;
                    $targetString.=$c;
                    break;
            case '"':
            // Escapes this quote only if its not preceded by an unescaped backslash
                    if($escapeCount % 2 == 0) $targetString.="\\";
                    $escapeCount=0;
                    $targetString.=$c;
                    break;
            case '\\':
                    $escapeCount++;
                    $targetString.=$c;
                    break;
            default:
                    $escapeCount=0;
                    $targetString.=$c;
        }
    }
    return $targetString;
} 

function conectarDB() {

	$con= new mysqli(server(), user(), password(), "silan2020")
			or die ("Error al conectarse al servidor mysql");
	if ($con->connect_error){
		die("Error al conectarse a la base de datos".$con->connect_error);
	}
	$result = $con->query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	
	return $con;
}

function desconectarDB($con) {
	//Me desconecto al servidor mysql
	mysql_close($con)
	or die ("Error al desconectarse del servidor mysql");
	return true;
}

function server(){

		 return "mysql.gegamultimedios.net";
		// return "localhost";
}

function user(){
		//return "root";
		return "silan2020";
}

function password(){

	//return "";
	return "Kdw3w3#w2";

}

$con=conectarDB();
?>