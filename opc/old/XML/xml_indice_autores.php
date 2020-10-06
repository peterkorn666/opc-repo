<?php
set_time_limit(300);
require("../conexion.php");


/*
header("Content-Type: application/xml");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=indice.xml");*/

function nodo($cual){

	$abre ="&lt;";
	$cierra = "&gt;";

	$nodo = $abre . $cual . $cierra;

	return $nodo;

}

function remp($cadena){
	$cadena = trim(utf8_encode($cadena));
 
    $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'," "),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A',"_"),
        $cadena
    );
 
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena
    );
 
    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena
    );
 
    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena
    );
 
    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena
    );
 
    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $cadena
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    /*$cadena = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ",", ":",
             ".", " "),
        '',
        $cadena
    );*/
	return $cadena;
}

//$sql = "SELECT t.ID, l.ID_trabajos_libres, l.ID_participante, t.pagina, p.Apellidos, p.Nombre, t.numero_tl FROM trabajos_libres as t JOIN trabajos_libres_participantes as l ON t.ID=l.ID_trabajos_libres JOIN personas_trabajos_libres as p ON l.ID_participante ORDER BY t.pagina,p.Apellidos ASC LIMIT 0,5";

$sql = "SELECT * FROM trabajos_libres as t JOIN trabajos_libres_participantes as l ON t.ID=l.ID_trabajos_libres JOIN personas_trabajos_libres as p ON l.ID_participante=p.ID_Personas WHERE t.pagina<>0 ORDER BY p.Apellidos,p.Nombre,t.pagina";
$query = mysql_query($sql,$con) or die(mysql_error());


echo nodo('?xml version="1.0" encoding="utf-8"?');


echo "<br>" . nodo("root");
$i = 0;
while($row = mysql_fetch_object($query)){
	if(trim(remp($row->Apellidos)." ".remp($row->Nombre))!=$autor_){
			echo "<br>";
	}
	
	//$sqlL = "SELECT * FROM trabajos_libres_participantes as l JOIN trabajos_libres as t ON t.ID=l.ID_trabajos_libres WHERE l.ID_participante='$row->ID_Personas' AND t.estado<>3 ORDER BY pagina";
	//$queryL = mysql_query($sqlL,$con) or die(mysql_error());
	if(trim(remp($row->Apellidos)." ".remp($row->Nombre))!=$autor_){
		echo nodo("autor").$row->Apellidos.", ".$row->Nombre.nodo("/autor")."@@@";
	}

	//while($rowT = mysql_fetch_object($queryL)){	
		
		
		echo nodo("pagina").$row->pagina.", ".nodo("/pagina");
		
		$autor_ = trim(remp($row->Apellidos)." ".remp($row->Nombre));
//	}
	
}

echo  "<br>" . nodo("/root");

?>