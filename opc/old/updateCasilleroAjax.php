<?php
require("conexion.php");

$key = $_POST["key"];
$opt = $_POST["opt"];
$casillero = $_POST["casillero"];
$hora_inicio = $_POST["hora_inicio"];

if(empty($key) || empty($opt) || empty($casillero))
	die();
if($opt=="1")
{	
	//Obtener persona
	$sqlPers = mysql_query("SELECT * FROM personas WHERE ID_Personas='".safes($key)."'",$con);
	$rowPers = mysql_fetch_array($sqlPers);
	if(!empty($rowPers["apellido"]) || !empty($rowPers["nombre"]))
	{
		//Obtener casillero
		$sqlCas = mysql_query("SELECT * FROM congreso WHERE Casillero='".safes($casillero)."' ORDER BY Orden_aparicion DESC",$con) or die(mysql_error());
		$rowCas = mysql_fetch_array($sqlCas);
		$sql = mysql_query("INSERT INTO congreso 
							(Casillero,
							Orden_aparicion,
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
							ID_persona,
							en_crono,
							Profesion,
							Nombre,
							Apellidos,
							Pais,
							Mail,
							Institucion) VALUES (
							'".safes($casillero)."',
							'".($rowCas["Orden_aparicion"]+1)."',
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
							'".safes($key)."',
							1,
							'".safes($rowPers["profesion"])."',
							'".safes($rowPers["nombre"])."',
							'".safes($rowPers["apellido"])."',
							'".safes($rowPers["pais"])."',
							'".safes($rowPers["email"])."',
							'".safes($rowPers["institucion"])."')",$con) or die(mysql_error());
	}
}else if($opt=="2"){	
	//Actualizar trabajos si ya estaba ubicado.
	$trabajo = mysql_query("SELECT * FROM trabajos_libres WHERE ID='".safes($key)."'");
	$rowT = mysql_fetch_array($trabajo);
	if($rowT["ID_casillero"]!=0)
	{
		$id_casillero_viejo = $rowT["ID_casillero"];
	}
	
	$sql = mysql_query("UPDATE trabajos_libres SET ID_casillero='".safes($casillero)."' WHERE ID='".safes($key)."'",$con);
	
	/*$setTime = mysql_query("SELECT * FROM trabajos_libres WHERE ID_casillero='".safes($casillero)."' ORDER BY Hora_inicio",$con);
	$i = 0;
	while($row = mysql_fetch_array($setTime)){
		if($i!=0)
			$hora_inicio = date("H:i:s",strtotime("+10 minutes",strtotime($hora_inicio)));
			$hora_fin = date("H:i:s",strtotime("+10 minutes",strtotime($hora_inicio)));		
			
		mysql_query("UPDATE trabajos_libres SET Hora_inicio='$hora_inicio', Hora_fin='$hora_fin' WHERE ID='".$row["ID"]."'") or die(mysql_error());
		$i++;
	}
	$setTime = mysql_query("SELECT * FROM trabajos_libres WHERE ID_casillero='".safes($id_casillero_viejo)."' ORDER BY Hora_inicio",$con);
	$i = 0;
	while($row = mysql_fetch_array($setTime)){
		if($i==0)
		{
			$sqlCasillero = mysql_query("SELECT * FROM congreso WHERE Casillero='".$id_casillero_viejo."' ORDER BY Hora_inicio ASC LIMIT 0,1",$con);
			$rowCasillero = mysql_fetch_array($sqlCasillero);
			$hora_inicio = $rowCasillero["Hora_inicio"];
		}
		if($i!=0)
			$hora_inicio = date("H:i:s",strtotime("+10 minutes",strtotime($hora_inicio)));
			$hora_fin = date("H:i:s",strtotime("+10 minutes",strtotime($hora_inicio)));		
		
		mysql_query("UPDATE trabajos_libres SET Hora_inicio='$hora_inicio', Hora_fin='$hora_fin' WHERE ID='".$row["ID"]."'") or die(mysql_error());
		$i++;
	}*/
	
}

?>