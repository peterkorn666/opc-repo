<?
header("Content-Disposition: attachment; filename=Todos_los_Trabajos.xls");
include('inc/sesion.inc.php');
require "conexion.php";
require "clases/trabajosLibres.php";
$trabajos = new trabajosLibre();

function echotd($contenido,$prop)
{
	echo "<td $prop>$contenido</td>";
}

function rem($stirng)
{
	$array = array("<br>","<br />","<br/>");
	$por = array(" "," "," ");
	$string = str_replace($array,$por,$stirng);
	return $string;
}

function ctype_alnum_plus($sCadena,$restriccion='esp',$MostrarError=true){
   if(empty($sCadena)){
 if($MostrarError)
  die('ctype_alnum_plus: el primer parámetro es obligatorío.');
    else return false;
   }
   $restriccion = trim($restriccion,';');
   $sAtajos     = array('esp','ace','dia','ene','gui','pun',
                    'num','und','apo','com','2pu','puc',
                    'par','cor');
   if (strlen($restriccion)>3 and strpos($restriccion,';')===false){
      if ($MostrarError) 
 die('ctype_alnum_plus: el segundo parámetro sólo acepta ('
 .implode(',',$sAtajos).') separados por punto y coma (;)');
      else return false;
   }   
   $sExpr = array('esp'=>'\s','ace'=>'ÁÉÍÓÚáéíóú','dia'=>'ÄËÏÖÜäëïöü','ene'=>'Ññ',
                  'pun'=>'\.','gui'=>'\-','num'=>'\d','und'=> '_','apo'=>"\'",
                  'com'=>',','2pu'=>':','puc'=>';','par'=>'()','cor'=>'\[\]',"com"=>",");
   $sPatron  = '/^[a-z';
   $restriccion = strtolower($restriccion);
   if ($restriccion=='esp'){
      $sPatron .= $sExpr['esp'];
   }else{
      $arrRestriccion = explode (';',$restriccion);
      foreach ($arrRestriccion as $name){
         if (!in_array($name,$sAtajos)) {
            if($MostrarError) 
  die('ctype_alnum_plus: el segundo parámetro sólo acepta ('
                .implode(',',$sAtajos).') separados por punto y coma (;)');
            else return false;
         }
         $sPatron .= $sExpr[$name];
      }
   }
   $sPatron .= ']+$/i';
   return preg_match($sPatron,$sCadena) ? true : false;
}

$sqlTOTAL = "SELECT DISTINCT(ID) FROM trabajos_libres ";
$rsTOTAL = mysql_query($sqlTOTAL, $con);
$totalTLS = mysql_num_rows($rsTOTAL);

$sql = "SELECT ID_Personas FROM personas_trabajos_libres WHERE inscripto = 1";
$rs = mysql_query($sql, $con);
$total_inscriptos = mysql_num_rows($rs);

$sql123 = "SELECT DISTINCT(ID_participante) FROM trabajos_libres_participantes WHERE lee = 1";
$rs123 = mysql_query($sql123, $con);
$total_leen = mysql_num_rows($rs123);
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?


echo '<table width="98%" height="39" border="1" cellspacing="0">';

echo "<tr>";
	echotd("ID","bgcolor=#CCCCCC");
	echotd("Código ".$totalTLS,"bgcolor=#CCCCCC");	
	echotd("Código Viejo","bgcolor=#CCCCCC");	
	echotd("Clave","bgcolor=#CCCCCC");	
	echotd("Orden Día","bgcolor=#CCCCCC");
	echotd("Dia","bgcolor=#CCCCCC");
	echotd("Orden Sala","bgcolor=#CCCCCC");
	echotd("Sala","bgcolor=#CCCCCC");
	echotd("Hora inicio","bgcolor=#CCCCCC");
	echotd("Título de actividad","bgcolor=#CCCCCC");
	echotd("Título","bgcolor=#CCCCCC");
	echotd("Título Nuevo","bgcolor=#CCCCCC");
	
	echotd("Congreso","bgcolor=#CCCCCC");
	echotd("Presenta Premio","bgcolor=#CCCCCC");
	echotd("Área orden","bgcolor=#CCCCCC");
	echotd("Área","bgcolor=#CCCCCC");
	echotd("Mail de Contacto","bgcolor=#CCCCCC");
	echotd("Institución","bgcolor=#CCCCCC");
	echotd("País","bgcolor=#CCCCCC");
	echotd("Apellido del 1er Autor","bgcolor=#CCCCCC");
	echotd("Nombre del 1er Autor","bgcolor=#CCCCCC");
	
	echotd("Apellido del 2ndo Autor","bgcolor=#CCCCCC");
	echotd("Nombre del 2ndo Autor","bgcolor=#CCCCCC");	
	
	echotd("Coautores","bgcolor=#CCCCCC");
	echotd("Diploma","bgcolor=#CCCCCC");
	echotd("Nombres Presentadores ". $total_leen,"bgcolor=#CCCCCC");
	echotd("Apellidos Presentadores ". $total_leen,"bgcolor=#CCCCCC");	
	echotd("Presentador Inscripto".$total_inscriptos,"bgcolor=#CCCCCC");
	echotd("Teléfono", "bgcolor=#CCCCCC");
	echotd("Estado", "bgcolor=#CCCCCC");

echo "</tr>";

$sql = "SELECT * FROM trabajos_libres WHERE estado <> 3 ORDER BY numero_tl ";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	if($row["estado"]==0){$NomEstado = "Recibidos";}
	elseif($row["estado"]==1){$NomEstado = "En Revisión";}
	elseif($row["estado"]==2){$NomEstado = "Aprobado";}
	elseif($row["estado"]==4){$NomEstado = "Notificados";}
	//elseif($row["estado"]==3){$NomEstado = "Rechazado";}

	/*echo "<tr><td>".$NomEstado."&nbsp;</td>";*/
	$sql4="SELECT Dia, Dia_orden, Sala, Sala_orden, Hora_inicio, Hora_fin, Titulo_de_actividad FROM congreso WHERE Casillero = ".$row['ID_casillero'];
$rs4 = mysql_query($sql4, $con);
while($row4=mysql_fetch_array($rs4)){
	$UbicaDiaOrden=$row4["Dia_orden"];
	$UbicaDia=$row4["Dia"];
	$UbicaSalaOrden=$row4["Sala_orden"];
	$UbicaSala=$row4["Sala"];
	$UbicaHoraInicio=$row4["Hora_inicio"];
	$Titulo_de_actividad=$row4["Titulo_de_actividad"];
}
	echo "<tr>";
	//echo "<td>".$row["numero_tl"]."&nbsp;</td>";
	if($row["ID"]<=9){
		$ID = "00" . $row["ID"];
	}
	elseif($row["ID"]<=99){
		$ID = "0" . $row["ID"];
	}
	else{
		$ID = $row["ID"];
	}
	echotd($row["ID"]."&nbsp;","bgcolor=#FFFFFF  align='center'");
	echotd($row["numero_tl"]."&nbsp;","bgcolor=#FFFFFF  align='center'");
	echotd($row["numero_tl_viejo"]."&nbsp;","bgcolor=#FFFFFF  align='center'");
	echotd($row["clave"]."&nbsp;","bgcolor=#FFFFFF  align='center'");
	//echo "<td align='center'>".$row["numero_tl"."&nbsp;</td>";
	echotd($UbicaDiaOrden."&nbsp;","bgcolor=#FFFFFF");
	echotd($UbicaDia,"bgcolor=#FFFFFF");
	echotd($UbicaSalaOrden,"bgcolor=#FFFFFF");
	echotd($UbicaSala."&nbsp;","bgcolor=#FFFFFF");
	echotd($UbicaHoraInicio."&nbsp;","bgcolor=#FFFFFF");	
	echotd($Titulo_de_actividad."&nbsp;","bgcolor=#FFFFFF");
	echotd(rem($row["titulo_tl"])."&nbsp;","bgcolor='#FFFFFF'");
	//if(ctype_alnum_plus($row["titulo_tl"],"esp;ace;ene;gui;pun;num;apo;puc;par;2pu;com")){
	echotd(ucfirst(mb_strtolower(rem($row["titulo_tl"]),"utf-8"))."&nbsp;","bgcolor='#FFFFFF'");
	//}else{
		//echotd($row["titulo_tl"]."&nbsp;","bgcolor='#FFFFFF'");
	//}
	//echo "<td>".$row["idioma"]."&nbsp;</td>";
	echotd($row["congreso"]."&nbsp;","bgcolor=#FFFFFF");

	echotd($row["premio"],"bgcolor=#FFFFFF");

	//echo "<td>".$row["tipo_tl"]."&nbsp;</td>";
	echotd($row["area_tl"]."&nbsp;","bgcolor=#FFFFFF");
	echotd($trabajos->areaID($row["area_tl"])->Area."&nbsp;","bgcolor=#FFFFFF");
	//echo "<td>".$row["area_tl"]."&nbsp;</td>";
	echotd($row["contacto_mail"]."&nbsp;","bgcolor=#FFFFFF");
	//echo "<td>".$row["mailContacto_tl"]."&nbsp;</td>";
	$coautores ="";
	$diploma = "";
	$autor1 = false;
	$inscript ="&nbsp;";
	$IDPresentador=0;
	$sql3 = "SELECT * FROM trabajos_libres_participantes WHERE ID_Trabajos_libres = ". $row["ID"] .  " ORDER BY ID ASC";
	$rs3 = mysql_query($sql3, $con);
	$cantAutores = mysql_num_rows($rs3);
	$ia = 0;
	$tieneCoautor = false;
	while($row3=mysql_fetch_array($rs3)){
	
	$sqlEv = "SELECT * FROM evaluaciones as ev JOIN evaluadores as e ON ev.idEvaluador=e.id WHERE ev.numero_tl='".$row["numero_tl"]."'";
	$queryEv = mysql_query($sqlEv,$con);
	
	if($row3["lee"]==1){$IDPresentador = $row3["ID_participante"];}

		$sql2 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $row3["ID_participante"] . " LIMIT 1";
		$rs2 = mysql_query($sql2, $con);
		$row2 = mysql_fetch_array($rs2);
		
		$inscriptoPresentador = $row2["inscripto"];	
		if($inscriptoPresentador==1){
			$inscriptoPresentador = "inscripto";
		}else{
			$inscriptoPresentador = "";
		}
			
			if($ia==0){		
				if(!empty($row2["Institucion"]))
				{
					$getInstitucion = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row2["Institucion"]."'",$con);		
					$rowInstitucion = mysql_fetch_array($getInstitucion);
				}
					
				echotd($rowInstitucion["Institucion"]."&nbsp;","bgcolor=#FFFFFF");
				echotd($trabajos->getPaisID($row2["Pais"])."&nbsp;","bgcolor=#FFFFFF");
				echotd($row2["Apellidos"]."&nbsp;","bgcolor=#FFFFFF");
				echotd($row2["Nombre"]."&nbsp;","bgcolor=#FFFFFF");
			}else{
				$coautores .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
			}
				
			
			if($ia==1)
			{
				echotd($row2["Apellidos"]."&nbsp;","bgcolor=#FFFFFF");
				echotd($row2["Nombre"]."&nbsp;","bgcolor=#FFFFFF");
				$tieneCoautor = true;
			}		
			
			$ia++;
			if($ia==$cantAutores && !$tieneCoautor)
			{
				echotd("&nbsp;","bgcolor=#FFFFFF");
				echotd("&nbsp;","bgcolor=#FFFFFF");
			}
					
			if($row2["inscripto"]==1){
				$inscript .= $row2["Apellidos"].", ".$row2["Nombre"]."; ";
			}
			
			$diploma .=	$row2["Nombre"]." ".$row2["Apellidos"]."; ";
	
			/*if($presID == $row2["ID_Personas"]){
				$presentador = $row2["Apellidos"];
			}	*/
		}	

	echotd($coautores."&nbsp;","bgcolor=#FFFFFF");
	echotd($diploma."&nbsp;","bgcolor=#FFFFFF");
	//echo "<td>".$coautores."&nbsp;</td>";	
	$presentador="";
		$sql22 = "SELECT * FROM personas_trabajos_libres WHERE ID_Personas = ". $IDPresentador . " LIMIT 1";
		$rs22 = mysql_query($sql22, $con);
		$row22=mysql_fetch_array($rs22);
		$presentadorNombre=$row22["Nombre"];
		$presentadorApellido = $row22["Apellidos"];
		
	echotd($presentadorNombre,"bgcolor=#FFFFFF");	
	echotd($presentadorApellido,"bgcolor=#FFFFFF");	
	echotd($inscript."&nbsp;","bgcolor=#FFFFFF");
	echotd($row["telefono"]."&nbsp;","bgcolor=#FFFFFF");
	
	

	
	if($row["archivo_tl"]!=""){
		$archivotl = $row["archivo_tl"];
	}else{
		$archivotl = "No";
	}
	if($row["poster_tl"]!=""){
		$poster_tl = $row["poster_tl"];
	}else{
		$poster_tl = "No";
	}
	if($row["oral_tl"]!=""){
		$oral_tl = $row["oral_tl"];
	}else{
		$oral_tl = "No";
	}
	
	echotd($NomEstado."&nbsp;","bgcolor=#FFFFFF");
	

	
	
	echo "</tr>";
	$UbicaDiaOrden="";
	$UbicaDia="";
	$UbicaSalaOrden="";
	$UbicaSala="";
	$UbicaHoraInicio="";
}
echo "</table>";
?>


