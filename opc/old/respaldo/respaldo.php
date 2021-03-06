<?php
include "../conexion.php";
include "../envioMail_Config.php";

$nombreRespaldo = date("d-m-Y_H-i-s")."_respaldo.sql"; //nombre del archivo (dejar asi)

/* Determina si la tabla ser� vaciada (si existe) cuando  restauremos la tabla. */            
$drop = false;
$tablas = false;
/* Tipo de compresion. Puede ser "gz", "bz2", o false (sin comprimir)*/
$compresion = false;
/* Se busca las tablas en la base de datos */
if ( empty($tablas) ) {
    $consulta = "SHOW TABLES FROM $bd;";
    $respuesta = mysql_query($consulta, $con)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_NUM)) {
        $tablas[] = $fila[0];
    }
}
/* Se crea la cabecera del archivo */
$info['dumpversion'] = "1.1b";
$info['fecha'] = date("d-m-Y");
$info['hora'] = date("h:m:s A");
$info['mysqlver'] = mysql_get_server_info();
$info['phpver'] = phpversion();
ob_start();
print_r($tablas);
$representacion = ob_get_contents();
ob_end_clean ();
preg_match_all('/(\[\d+\] => .*)\n/', $representacion, $matches);
$info['tablas'] = implode(";  ", $matches[1]);
$dump = <<<EOT
# +===================================================================
# | OPC {$info['dumpversion']}
# |
# | Generado el {$info['fecha']} a las {$info['hora']} por el usurio '$usurio'
# | Servidor: {$_SERVER['HTTP_HOST']}
# | MySQL Version: {$info['mysqlver']}
# | PHP Version: {$info['phpver']}
# | Base de datos: '$bd'
# | Tablas: {$info['tablas']}
# |
# +-------------------------------------------------------------------
EOT;
foreach ($tablas as $tabla) {
    
    $drop_table_query = "";
    $create_table_query = "";
    $insert_into_query = "";
    
    /* Se halla el query que ser� capaz vaciar la tabla. */
    if ($drop) {
        $drop_table_query = "DROP TABLE IF EXISTS `$tabla`;";
    } else {
        $drop_table_query = "# No especificado.";
    }

    /* Se halla el query que ser� capaz de recrear la estructura de la tabla. */
    $create_table_query = "";
    $consulta = "SHOW CREATE TABLE $tabla;";
    $respuesta = mysql_query($consulta, $con)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_NUM)) {
            $create_table_query = $fila[1].";";
    }
    
    /* Se halla el query que ser� capaz de insertar los datos. */
    $insert_into_query = "";
    $consulta = "SELECT * FROM $tabla;";
    $respuesta = mysql_query($consulta, $con)
    or die("No se pudo ejecutar la consulta: ".mysql_error());
    while ($fila = mysql_fetch_array($respuesta, MYSQL_ASSOC)) {
            $columnas = array_keys($fila);
            foreach ($columnas as $columna) {
                if ( gettype($fila[$columna]) == "NULL" ) {
                    $values[] = "NULL";
                } else {
                    $values[] = "'".mysql_real_escape_string($fila[$columna])."'";
                }
            }
            $insert_into_query .= "INSERT INTO `$tabla` VALUES (".implode(", ", $values).");\n";
            unset($values);
    }
    
$dump .= <<<EOT
# | Vaciado de tabla '$tabla'
# +------------------------------------->
$drop_table_query

# | Estructura de la tabla '$tabla'
# +------------------------------------->
$create_table_query

# | Carga de datos de la tabla '$tabla'
# +------------------------------------->
$insert_into_query
EOT;
}

/* Envio */
if ( !headers_sent() ) {
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Content-Transfer-Encoding: binary");
	
    switch ($compresion) {
    case "gz":
        header("Content-Disposition: attachment; filename=$nombreRespaldo.gz");
        header("Content-type: application/x-gzip");
        echo gzencode($dump, 9);
        break;
    case "bz2": 
        header("Content-Disposition: attachment; filename=$nombreRespaldo.bz2");
        header("Content-type: application/x-bzip2");
        echo bzcompress($dump, 9);
        break;
    default:
	//escribo el archivo
		$stream_options = array('ftp' => array('overwrite' => true));
		$stream_context = stream_context_create($stream_options);
		$gestor = fopen("ftp://ftp_aladefe:*UyesR7z@ps6956.dreamhost.com/aladefe2013conferencia.org/programa/respaldo/".$nombreRespaldo, "w", 0, $stream_context);
		fwrite($gestor, $dump);
		fclose($gestor);
		chmod($nombreRespaldo,0777);
		header ("Location: mail.php?archivo=$nombreRespaldo");
	}
} else {
    echo "<b>ATENCION: Probablemente ha ocurrido un error</b><br />\n<pre>\n$dump\n</pre>";	
}
?> 