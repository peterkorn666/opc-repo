<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
include('inc/sesion.inc.php');
include("conexion.php");
$ID = $_GET["idTL"];
$sql = "SELECT * FROM trabajos_libres WHERE ID = $ID;";
$rs = mysql_query($sql, $con);

while ($row = mysql_fetch_array($rs)){
	$titulo = $row["titulo_tl"];
	$numero = $row["numero_tl"];
	
	$tipo_tl = $row["tipo_tl"];
	if ($tipo_tl!=''){$tipo_tl=$tipo_tl ." > ";}
	
	$area_tl = $row["area_tl"];
	$resumen = $row["resumen"];
	$resumen = str_replace(chr(13), "<br>", $resumen);
	
	$PalabrasClave =  $row["palabrasClave"];
	if ($PalabrasClave != ''){$PalabrasClave = "<b>Palabras Claves: </b>" .$PalabrasClave;}
	$ide = $row["ID"];
}
?>
<html>
<head>
<title>Resumen <?=$numero;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>
</html>


<style type="text/css">
<!--
.Estilo1 {
	font-family:"Times New Roman", Times, serif;
	font-weight: bold;
	font-size: 14px;
}
.botones_tl {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-decoration: none;
	background-color:#BFAFC7;
}
.textos {
	font-family:"Times New Roman", Times, serif;
	font-size: 12px;
}
.autores {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style>

<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td align="right"><div id="btnImprimir" align="right"><a href="javascript:imprimirResumen(); "><img src="img/ico_imprimir.gif" width="58" height="18" border="0" />
    </a></div></td>
  </tr>
  <tr>
    <td  class="botones_tl"><strong >&nbsp;Resumen <?=$numero;?> 
      <font color="6F0024" style="font-family:Arial, Helvetica, sans-serif" size="2"><strong>
      &nbsp;<?=$tipo_tl . $area_tl;?>
    </strong></font></strong></td>
  </tr>
  
  <tr>
    <td bgcolor="#FFFFCC"  class="Estilo1" align="center" ><strong >&nbsp;
      <?=$titulo;?>
    </strong></td>
  </tr>
  
  <tr><td align="right" class="autores">
  &nbsp;<? 	$arrayPersonas = array();
              $arrayInstituciones = array();


              $sql2 ="SELECT ID_participante, lee FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $ide ." ORDER BY ID ASC;";
              $rs2 = mysql_query($sql2,$con);
              while ($row2 = mysql_fetch_array($rs2)){
			  
              	$sql3 ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas =" . $row2["ID_participante"] . ";";
              	$rs3 = mysql_query($sql3,$con);
              	while ($row3 = mysql_fetch_array($rs3)){

              		array_push($arrayInstituciones , $row3["Institucion"]);
              		array_push($arrayPersonas, array($row3["Institucion"], $row3["Apellidos"], $row3["Nombre"], $row3["Pais"], $row3["Curriculum"], $row3["Mail"], $row2["lee"]));

              	}


              }


              $arrayInstitucionesUnicas = array_unique($arrayInstituciones);
              $arrayInstitucionesUnicasNuevaClave = array();
              if(count($arrayInstitucionesUnicas)>0){
              	foreach ($arrayInstitucionesUnicas as $u){
              		if($u!=""){
              			array_push($arrayInstitucionesUnicasNuevaClave, $u);
              		}
              	}
              }


              for ($i=0; $i < count($arrayPersonas); $i++){

              	if($i>0){
              		echo "; ";
              		
              	}


              	if($i==0){
              		if($arrayPersonas[$i][3] != ""){
              			$aster = "<font color='#ff3300'>(*)</font>";
              		}
              	}else{
              		$aster = "";
              	}


              	if($arrayPersonas[$i][0]!=""){
              		$claveIns = (array_search($arrayPersonas[$i][0] ,$arrayInstitucionesUnicasNuevaClave))+1;

              	}else{
              		$claveIns = "";
              	}

              		$curriculum = "";
              		$mail = "";
              	

              	if ($arrayPersonas[$i][6]=="1"){
              		echo "<u>";
              	
              	}

              	echo $arrayPersonas[$i][1]. ", " . $arrayPersonas[$i][2];
             
              	if ($arrayPersonas[$i][6]=="1"){
              		echo "</u>";
              	}
              	echo "<sup><font color='#ff0000' align='right'> " . $claveIns . $aster  . "</font></sup>"  . $curriculum . $mail;
              	
              }
             if(count($arrayInstitucionesUnicasNuevaClave)>0){

              	$clave = 1;

              	foreach ($arrayInstitucionesUnicasNuevaClave as $ins){


              		echo   "<table  border='0' cellspacing='0' cellpadding='0' width='100%'><tr><td align='right'><font color='#ff0000' size='1'> $clave - <font color='#666666'>" . $ins . "</font>";


              		if($clave==1){

              			if($arrayPersonas[0][3] != ""){

              				echo  "<font color='#cccccc'>  |  </font><font color='#ff3300'>(*) </font><font color='#666666'>" . $arrayPersonas[0][3] . "</font>";
						}

              		}



              		echo "</font></td></tr></table>";


              		


              		$clave = $clave + 1 ;
              	}
				
			}



			  ?>
  </td></tr>
  <tr>
    <td  class="textos"><br><?=$resumen;?><br> </td>
  </tr>
  <tr>
    <td  class="textos"><em><?=$PalabrasClave;?></em>    </td>
  </tr>
  
   <tr>
    <td align="right">&nbsp;</td></tr>
</table>

<script>
function imprimirResumen(){
	document.getElementById('btnImprimir').style.display="none";
	window.print();	
	}

document.getElementById('btnImprimir').style.display="inline";
</script>