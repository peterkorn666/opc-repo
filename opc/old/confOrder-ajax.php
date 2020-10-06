<?php
require("conexion.php");
$id = $_GET["id"];
$nuevo_casillero = $_GET["nuevo_casillero"];
$viejo_casillero = $_GET["viejo_casillero"];
$id_persona = $_GET["id_persona"];
$order = $_GET["order"];
if(empty($id) || empty($nuevo_casillero))
{
	echo "Error campos vacios.";
	die();
}
if(empty($viejo_casillero))
{
	$sql = mysql_query("UPDATE congreso SET Orden_aparicion='".safes($order)."'	WHERE ID='".safes($id)."'",$con) or die(mysql_error());
}
else
{
	$getCas = mysql_query("SELECT * FROM congreso WHERE Casillero='".safes($nuevo_casillero)."' LIMIT 0,1") or die(mysql_error());
	$rowCas = mysql_fetch_array($getCas);
	
	//obtengo datos del casillero viejo
	$getCasViejo = mysql_query("SELECT * FROM congreso WHERE Casillero='".safes($viejo_casillero)."'");
	$rowCasV = mysql_fetch_array($getCasViejo);
	
	if(!empty($rowCas["Casillero"]) && empty($id_persona))
	{
		$sql = mysql_query("UPDATE congreso SET 
											Casillero='".safes($rowCas["Casillero"])."',
											Sala='".safes($rowCas["Sala"])."',
											Sala_orden='".safes($rowCas["Sala_orden"])."',
											Hora_inicio='".safes($rowCas["Hora_inicio"])."',
											Hora_fin='".safes($rowCas["Hora_fin"])."',
											Area='".safes($rowCas["Area"])."',
											Tematicas='".safes($rowCas["Tematicas"])."',
											Tipo_de_actividad='".safes($rowCas["Tipo_de_actividad"])."',
											Titulo_de_actividad='".safes($rowCas["Titulo_de_actividad"])."',
											Titulo_de_actividad_ing='".safes($rowCas["Titulo_de_actividad_ing"])."',
											Trabajo_libre='".$rowCas["Trabajo_libre"]."',
											sala_agrupada='".$rowCas["sala_agrupada"]."',
											Orden_aparicion='".safes($order)."'	WHERE ID='".safes($id)."'",$con) or die(mysql_error());
	}else if(!empty($id_persona)){
		$sql = mysql_query("INSERT INTO congreso 
					(Casillero,
					 Dia,
					 Dia_orden,
					 Sala,
					 Sala_orden,
					 Hora_inicio,
					 Hora_fin,
					 Area,
					 Tematicas,
					 Tipo_de_actividad,
					 Titulo_de_actividad,
					 Titulo_de_actividad_ing,
					 Trabajo_libre,
					 sala_agrupada,
					 Orden_aparicion,
					 
					 Titulo_de_trabajo,
					 Titulo_de_trabajo_ing,
					 En_calidad,
					 Profesion,
					 Nombre,
					 Apellidos,
					 Cargos,
					 Institucion,
					 Pais,
					 Mail,
					 Curriculum,
					 ID_persona,
					 en_crono)
					  VALUES (
					 '".safes($rowCas["Casillero"])."',
					 '".safes($rowCas["Dia"])."',
					 '".safes($rowCas["Dia_orden"])."',
					 '".safes($rowCas["Sala"])."',
					 '".safes($rowCas["Sala_orden"])."',
					 '".safes($rowCas["Hora_inicio"])."',
					 '".safes($rowCas["Hora_fin"])."',
					 '".safes($rowCas["Area"])."',
					 '".safes($rowCas["Tematicas"])."',
					 '".safes($rowCas["Tipo_de_actividad"])."',
					 '".safes($rowCas["Titulo_de_actividad"])."',
					 '".safes($rowCas["Titulo_de_actividad_ing"])."',
					 '".$rowCas["Trabajo_libre"]."',
					 '".$rowCas["sala_agrupada"]."',
					 '".($rowCas["Orden_aparicion"]+1)."',
					 '".$rowCas["Titulo_de_trabajo"]."',
					 '".$rowCas["Titulo_de_trabajo_ing"]."',
					 '".$rowCas["En_calidad"]."',
					 '".$rowCasV["Profesion"]."',
					 '".$rowCasV["Nombre"]."',
					 '".$rowCasV["Apellidos"]."',
					 '".$rowCasV["Cargos"]."',
					 '".$rowCasV["Institucion"]."',
					 '".$rowCasV["Pais"]."',
					 '".$rowCasV["Mail"]."',
					 '".$rowCasV["Curriculum"]."',
					 '".$rowCasV["ID_persona"]."',
					 '".$rowCasV["en_crono"]."'
					 )",$con) or die(mysql_error());
											
		$sql = mysql_query("UPDATE congreso SET 
											Titulo_de_trabajo='',
											Titulo_de_trabajo_ing='',
											En_calidad='',
											Profesion='',
											Nombre='',
											Apellidos='',
											Cargos='',
											Institucion='',
											Pais='',
											Mail='',
											Curriculum='',
											ID_persona='',
											en_crono=0
											WHERE Casillero='".safes($viejo_casillero)."'",$con) or die(mysql_error());
	}
											
}

if($sql)
{
	echo "Conferencistas actualizados correctamente.";
}else{
	echo "Hubo un error al actualizar los conferencistas. ";
}
?>