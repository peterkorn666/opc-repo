<?
/*php para imprimir los datos del apartado GestionSala, llega un valor por GET q puede ser
el dia, la sala o el staff (empresa), a partir de ahi se imprimen los datos de la tabla "sala_gestion" de una manera o de otra.
Pagina llamada desde: altaGestionSala.php 
*/
include('conexion.php');
include('envioMail_Config.php');

//recogemos los valores pasados por GET, solo llega UNO de los tres.
//***********************
$dia = str_replace("(Todos)","",base64_decode($_GET["dia"]));
$sala = str_replace("(Todas)","",base64_decode($_GET["sala"]));
$staff= base64_decode($_GET["staff"]);
//***********************

//sacamos los ID's, porque llegan los nombres de los campos
//***********************
if ($dia!=""){
	$sql = "SELECT ID_Dias FROM dias Where Dia = '".$dia."' ";
	$rs = mysql_query($sql,$con);
		while ($row = mysql_fetch_array($rs)){
			$id_dia = $row["ID_Dias"];
		}
}

if ($sala!=""){
	$sql = "SELECT ID_Salas FROM salas Where Sala = '".$sala."' ";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$id_sala = $row["ID_Salas"];
	}
}
//***********************

//Miramos cual opcion toca
//***********************
if($dia!=""){
	//sacamos las salas que intervienen en ese dia, con eso generamos un array con los valores
	// Ej dato id_sala="1-3-5-10" ==> creamos array_salas (1,3,5,10)
	$sql = "Select * from gestion_sala where id_dia like '%".$id_dia."%' ;";
	$rs = mysql_query($sql,$con);
	echo '<table width="600px" border="0" cellspacing="0" cellpadding="5" align="center" style="font-family:Verdana, Arial; font-size:12px;">
	<tr>
	<td align="center" style="font-size:14px;">'.$congreso.'<br />
<strong>'.$dia.'</strong></td>
	</tr>';

	$array_salas = array();
	while ($row = mysql_fetch_array($rs)){	
		$trozo_sala = explode("-", $row["id_sala"]);
		$count = count($trozo_sala);
		for ($i=0; $i < $count; $i++) {
			if(!in_array($trozo_sala[$i],$array_salas)){
				array_push($array_salas, $trozo_sala[$i]); 
			}
		}	
	}	
	sort($array_salas);
	
	//Ahora para cada sala sacamos los datos
	foreach($array_salas as $o){
			$sql = "SELECT Sala FROM salas Where ID_Salas = '".$o."' ";
			$rs = mysql_query($sql,$con);
			while ($row = mysql_fetch_array($rs)){
				echo '<tr><td style="font-weight:bold; border-top:1px #333 solid">'.$row["Sala"].'</td></tr>';
				$sql = "SELECT gestion_sala. * , staff.telefono,staff.contacto,staff.email FROM gestion_sala INNER JOIN staff ON gestion_sala.id_staff = staff.id_staff where gestion_sala.id_dia like '%".$id_dia."%' and gestion_sala.id_sala like '%".$o."%' ";
				$rs2 = mysql_query($sql,$con);
				while ($row2 = mysql_fetch_array($rs2)){
					echo '<tr><td>&bull; '.$row2["rubro"]." - ".$row2["staff"]." - <em>Tel.:".$row2["telefono"].' - Horario: '.$row2["hora_inicio"].' a '.$row2["hora_fin"].'</em></td></tr>';
					if($row2["descripcion"]!=""){
						echo '<tr><td style="padding-left:15px">Detalle: '.$row2["descripcion"].'</td></tr>';
					}
				}
			}
			
	}
	echo "</table>";
}elseif($sala!=""){
	$sql = "Select * from gestion_sala where id_sala like '%".$id_sala	."%' ;";
	$rs = mysql_query($sql,$con);
	echo '<table width="600px" border="0" cellspacing="0" cellpadding="5" align="center" style="font-family:Verdana, Arial; font-size:12px;">
	<tr>
	<td align="center" style="font-size:14px;">'.$congreso.'<br />
<strong>'.$sala.'</strong></td>
	</tr>';
	$array_dias = array();
	while ($row = mysql_fetch_array($rs)){	
		$trozo_dia = explode("-", $row["id_dia"]);
		$count = count($trozo_dia);
		for ($i=0; $i < $count; $i++) {
			if(!in_array($trozo_dia[$i],$array_dias)){
				array_push($array_dias, $trozo_dia[$i]); 
			}
		}	
	}
	sort($array_dias);
	
	foreach($array_dias as $o){
			$sql = "SELECT Dia FROM dias Where ID_Dias = '".$o."' ";
			$rs = mysql_query($sql,$con);
			while ($row = mysql_fetch_array($rs)){
				echo '<tr><td style="font-weight:bold; border-bottom:1px #333 solid" align="right">'.$row["Dia"].'</td></tr>';
				$sql = "SELECT gestion_sala. * , staff.telefono,staff.contacto,staff.email FROM gestion_sala INNER JOIN staff ON gestion_sala.id_staff = staff.id_staff where gestion_sala.id_dia like '%".$o."%' and gestion_sala.id_sala like '%".$id_sala."%';";
				$rs2 = mysql_query($sql,$con);
				while ($row2 = mysql_fetch_array($rs2)){
					echo '<tr><td>&bull; '.$row2["rubro"].' - '.$row2["staff"].' - <em>Tel.: '.$row2["telefono"].' Horario: '.$row2["hora_inicio"].' a '.$row2["hora_fin"].'</em></td></tr>';
					if($row2["descripcion"]!=""){
						echo "<tr><td style='padding-left:15px'>Detalle: ".$row2["descripcion"]."</td></tr>";
					}
				}
			}
			
	}
	echo "</table>";
}else{
	if ($staff=="(Todas)"){
		$sql ="SELECT * FROM staff order by nombre;";
		$rs = mysql_query($sql,$con);
		echo '<table width="600px" border="0" cellspacing="0" cellpadding="5" align="center" style="font-family:Verdana, Arial; font-size:12px;">
<tr>
<td align="center" style="font-size:14px;">'.$congreso.'<br />
<strong>Listado de empresas</strong></td>
</tr>';
		while ($row = mysql_fetch_array($rs)){
			echo '<tr><td style="font-weight:bold; border-top:1px #333 solid">'.$row["nombre"]."</td></tr>";
			echo '<tr><td style="padding-left:15px">Tel: '.$row["telefono"].' - '.$row["email"].' - Contacto: '.$row["contacto"].'</td></tr>';
			if($row["descripcion"]!=""){
				echo '<tr><td style="padding-left:15px">'.$row["descripcion"].'</td></tr>';
			}
			$sql ="SELECT * FROM personas_staff where id_staff= '".$row["id_staff"]."' order by apellido;";
			$rs2 = mysql_query($sql,$con);
			while ($row2 = mysql_fetch_array($rs2)){
				echo '<tr><td style="padding-left:15px">&bull; <em>'.$row2["nombre"].' '.$row2["apellido"].'</em> ('.$row2["pais"].') - '.$row2["cargo"].'</td></tr>';
				echo '<tr><td style="padding-left:30px">Tel.: '.$row2["telefono"].' - '.$row2["email"].'</td></tr>';
			}
		}	
		echo "</table>";								
	}else{
		$sql = "Select gestion_sala.*,staff.telefono,staff.contacto,staff.email from gestion_sala INNER JOIN staff ON gestion_sala.id_staff = staff.id_staff where  gestion_sala.staff ='".$staff."'";
		$rs = mysql_query($sql,$con);  	
		$tel = mysql_fetch_array($rs);
		echo '<table width="600px" border="0" cellspacing="0" cellpadding="5" align="center" style="font-family:Verdana, Arial; font-size:12px;">
	<tr>
	<td align="center" style="font-size:14px;">'.$congreso.'<br />
<strong>'.$staff.' ('.$tel["telefono"].')</strong></td>
	</tr>';
		$array_dias = array();
		while ($row = mysql_fetch_array($rs)){
			$trozo_dia = explode("-", $row["id_dia"]);
			$count = count($trozo_dia);
			for ($i=0; $i < $count; $i++) {
				if(!in_array($trozo_dia[$i],$array_dias)){
					array_push($array_dias, $trozo_dia[$i]); 
				}
			}	
		}
		sort($array_dias);	
		$array_salas = array();
		foreach($array_dias as $o){		
			$sql = "SELECT * FROM gestion_sala Where id_dia like '%".$o."%' and staff = '".$staff."'";
			$rs = mysql_query($sql,$con);
			$controlDia = 0;
			while ($row = mysql_fetch_array($rs)){
				if($controlDia==0){
					$sqlDia = "SELECT Dia FROM dias WHERE ID_Dias = '".$o."'";
					$rsDia = mysql_query($sqlDia,$con);
					$rowDia = mysql_fetch_array($rsDia);
					echo '<tr><td style="font-weight:bold;padding-top:15px; border-bottom:1px #333 solid;" align="right">'.$rowDia["Dia"].'</td></tr>';
					$controlDia=1;
				}
				$trozo_sala = explode("-", $row["id_sala"]);
				$count = count($trozo_sala);
				for ($i=0; $i < $count; $i++) {
					if(!in_array($trozo_sala[$i],$array_salas)){
						array_push($array_salas, $trozo_sala[$i]);
					}
				}
			}	
			sort($array_salas);			
			foreach($array_salas as $b){
				$sql = "SELECT Sala FROM salas Where ID_Salas = '".$b."' ";
				$rs3 = mysql_query($sql,$con);
				while ($row3 = mysql_fetch_array($rs3)){
					$sql = "SELECT gestion_sala. * , staff.telefono,staff.contacto,staff.email FROM gestion_sala INNER JOIN staff ON gestion_sala.id_staff = staff.id_staff where gestion_sala.id_dia like '%".$o."%' and gestion_sala.id_sala like '%".$b."%'  and gestion_sala.staff = '".$staff."';";
					$rs2 = mysql_query($sql,$con);
					$controlSala=0;
					while ($row2 = mysql_fetch_array($rs2)){
						if($controlSala==0){
							echo '<tr><td style="font-weight:bold;">'.$row3["Sala"].'</td></tr>';
							$controlSala=1;
						}
						echo '<tr><td style="padding-left:15px">&bull; '.$row2["hora_inicio"].' a '.$row2["hora_fin"].' - '.$row2["rubro"].'</td></tr>';
						if($row2["descripcion"]!=""){
							echo '<tr><td style="padding-left:30px">Detalle: '.$row2["descripcion"].'</td></tr>';
						}
					}							
				}
			}		
		}
		echo "</table>";
	}
}
?>

<script>
	window.print();
</script>