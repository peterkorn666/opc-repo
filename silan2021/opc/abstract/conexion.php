<?php
setlocale(LC_TIME, 'spanish');
date_default_timezone_set('America/Montevideo');

	if(($_SERVER["SERVER_NAME"] == "localhost")){
		define('MYSQL_HOST', 'mysql:host=localhost;dbname=silan2020');
		define('MYSQL_USUARIO', 'root');
		define('MYSQL_PASSWORD', '');
	}else{
		define('MYSQL_HOST', 'mysql:host=mysql.gegamultimedios.net;dbname=silan2020');
		define('MYSQL_USUARIO', 'silan2020');
		define('MYSQL_PASSWORD', 'Kdw3w3#w2');
	}
	

function conectaDb(){
    try {
        
        $db = new PDO(MYSQL_HOST, MYSQL_USUARIO, MYSQL_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
        return($db);
    } catch (PDOException $e) {
        print "<p>Error: No puede conectarse con la base de datos.</p>\n";
        print "<p>Error: $e->getMessage() </p>\n";
        exit();
    }
}


?>