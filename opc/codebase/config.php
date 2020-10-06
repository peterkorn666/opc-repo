<?php
	//setlocale(LC_TIME, 'en_utf8', 'English_Australia.1252', 'English');
	setlocale(LC_TIME, 'es_ES');
	//setlocale(LC_ALL, 'en_US');
	//date_default_timezone_set('America/Montevideo');
	if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "crono.loc"){
		define('MYSQL_HOST', 'localhost');
		define('MYSQL_HOST2', 'mysql:host=localhost;dbname=bd_fepal2020');
		define('MYSQL_BD','bd_fepal2020');
		define('MYSQL_USUARIO', 'root');
		define('MYSQL_PASSWORD', '');
	}else{
		define('MYSQL_HOST', 'mysql.gegamultimedios.net');
		define('MYSQL_HOST2', 'mysql:host=mysql.gegamultimedios.net;dbname=bd_fepal2020');
		define('MYSQL_BD','bd_fepal2020');
		define('MYSQL_USUARIO', 'fepal2020');
		define('MYSQL_PASSWORD', 'smMxJS1G00YNOL');
	}
	$mysql_server= MYSQL_HOST;
	$mysql_db = MYSQL_BD;
	$mysql_user = MYSQL_USUARIO;
	$mysql_pass = MYSQL_PASSWORD;
	$dbtype = "PDO";
	
	function conectaDb(){
		try {
			$db = new PDO(MYSQL_HOST2, MYSQL_USUARIO, MYSQL_PASSWORD, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>TRUE,PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
			return($db);
		} catch (PDOException $e) {
			print "<p>Error: No puede conectarse con la base de datos.</p>\n";
			print "<p>Error: " . $e->getMessage() . "</p>\n";
			exit();
		}
	}

	$res = conectaDb();
	
	define("BR","<br>")
?>