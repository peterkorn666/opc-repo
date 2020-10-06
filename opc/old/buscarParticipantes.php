<?
require("inc/sesion.inc.php");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
$sePuedeImprimir=true;
$imprimir = "";

?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function eliminar_casillero(cual){
 		var return_value = confirm("¿Esta seguro que desea eliminar este casillero?");
		
		 if ( return_value == true ) {
			 document.location.href = "eliminarCasilleroUnico.php?id_casillero=" + cual;
		 }
	 }

function saltar(){
 	    form1.action= "?id=" + form1.personas.value;
		form1.target = "_self";
		form1.submit();
}
//-->
</script>

<?
$que_busca = $_POST["buscar_"];

include('conexion.php');
include("inc/validarVistas.inc.php");
?>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top">      <table width="770" border="0" align="center" cellpadding="2" cellspacing="0">
        <tr>
          <td colspan="2">
		    <div align="center">
		    <br>
		    <form name="form1" method="post" style="display:inline;">

		 <select name="personas" class="trabajos" id="personas" onChange="saltar()">
<?
$sql = "SELECT DISTINCT ID_persona, Institucion, Pais, Curriculum, Nombre, Apellidos, Profesion FROM congreso order by Apellidos;";
$rs = mysql_query($sql, $con);
while ($row = mysql_fetch_array($rs)){
		
		    if ($row["Institucion"]!=""){
				$institucion = " - "  . $row["Institucion"];
			}else{
				$institucion = "";
			}
			
			if ($row["Pais"]!=""){
				$pais = " ("  . $row["Pais"] . ")";
			}else{
				$pais = "";
			}
  			if ($row["ID_persona"]== $_GET["id"]){
				$selected = "selected";
			}else{
				$selected = "";
			}
?>
   <option value="<?=$row["ID_persona"]?>" <? echo $selected?> ><? echo $row["Profesion"] . $row["Apellidos"] . ", " . $row["Nombre"] . $institucion . $pais; ?></option>
<?
}
?>
                </select>
</form>
</div></td>
        </tr>
        <?
		
		
		$sql =  "SELECT * FROM congreso WHERE ";
		$sql .= "ID_persona = '".$_GET["id"]."'";
		$sql .= " ORDER by Casillero, Orden_aparicion ASC;";
	    $rs = mysql_query($sql,$con);
	
	    while ($row = mysql_fetch_array($rs)){ 
	 
//___________________________________________________________________________________________
			if($dia_anterior != $row["Dia"]){
			   echo "<tr><td colspan='3'>&nbsp;</td></tr>";
				echo "<tr><td colspan='3'><b><font face='Arial, Helvetica, sans-serif'><div align='center'>" . $row["Dia"] . "</div></font></b></td></tr>";
			    $imprimir .= "<br><p style='background-color: #CCCCCC;font-family: Arial, Helvetica, sans-serif;font-size: 18px;font-weight: bold;color: #000000;text-align: center;margin:0px;' >" . $row["Dia"] . "</p>\n";
			   $dia_anterior = $row["Dia"];
			    $arrancaSala=1;
			}        	
			
			
 		 	if($sala_anterior != $row["Sala"] || $arrancaSala==1){
        		$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 14px;font-weight: bold;color: #333333;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color:#000000;margin:0px;margin-left:20px;'>" . $row["Sala"] . "</p>\n";
				$sala_anterior = $row["Sala"];
				$arrancaSala=0;
        	}
			
				
				
				if($casillero_anterior != $row["Casillero"]){
			
				echo "<tr><td colspan='3'>&nbsp;</td></tr>";

						$sql_act = "SELECT * FROM tipo_de_actividad WHERE Tipo_de_actividad ='" . $row["Tipo_de_actividad"] . "';";
						$rs_act = mysql_query($sql_act,$con);
						while ($row_act = mysql_fetch_array($rs_act)){
							$color_fondo = $row_act["Color_de_actividad"];

        		echo "<tr><td width='100' class='hora' bgcolor='$color_fondo'>" . substr($row["Hora_inicio"], 0, -3). " a " . substr($row["Hora_fin"],0 , -3);
        			$imprimir .= "<br><p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin:0px;margin-left:20px;'>" . substr($row["Hora_inicio"], 0, -3) . " a " . substr($row["Hora_fin"],0 , -3);

        		echo "</td><td width='300' class='tipo_de_actividad' bgcolor='$color_fondo'>&nbsp;" .$row["Tipo_de_actividad"] . "</td>";
        			$imprimir .= "&nbsp;-&nbsp;" . $row["Tipo_de_actividad"] . "</p>\n";
					
        		echo "<td width='350' class='hora' bgcolor='$color_fondo'><table border='0' width='100%'>";
        		echo "<tr><td>";

        		echo "<font size='2' face='Arial, Helvetica, sans-serif'>" . $row["Sala"] . "</font>";

        		if($_SESSION["registrado"] == true){
        			echo "</td>";
        			echo  "<td width='13' align='center'><a href='modificarCasillero.php?id_casillero=" . $row["Casillero"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este casillero'></a>";
        			echo "</td><td width='13' align='center' onClick=eliminar_casillero('" .  $row["Casillero"] . "')>";
        			echo  "<a href='#'><img src='img/eliminar.png' border='0' alt='Eliminar este casillero'></a>";
        		}

        		echo "</td></tr>";
        		echo "</table></td></tr>";
				
				 }
				
				 //********************************************************
				 
				 if($row["Area"] == ""){
					 $area= "";
				 }else{
					 $area = $row["Area"];
				 }
				 if($row["Tematicas"] == ""){
				 	$tematica  = "";
				 }else{
				 	$tematica = $row["Tematicas"];
				 }
				 if($row["Area"] != "" && $row["Tematicas"] != ""){
					$tematica = " - " . $row["Tematicas"];
				 }
				 
				if($row["Area"] != "" || $row["Tematicas"] != ""){
					echo "<tr><td colspan='3' class='area_tematica'>" . $area . $tematica . "</td></tr>";
					        			$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:10px;color: #666666;;margin:0px;margin-left:105px;'>" . $area . $tematica . "</p>\n";

				}
				
				echo "<tr><td colspan='3' class='titulo_actividad'>" . $row["Titulo_de_actividad"] . "</td></tr>";
				$imprimir .=  "<p style='font-family: Arial, Helvetica, sans-serif;font-size:14px;color: #660000;font-weight: bold;margin:0px;margin-left:105px;'>" . $row["Titulo_de_actividad"] . "</p>\n";

				$casillero_anterior = $row["Casillero"];
			}
	//___________________________________________________________________________________________
			
			if($trabajo_anterior != $row["Titulo_de_trabajo"] && $row["Titulo_de_trabajo"]!=""){
				echo "<tr><td colspan='3' class='trabajos' height='10'></td></tr>";
				echo "<tr><td colspan='3' class='trabajos'><span class='linea_trabajos'>" . $row["Titulo_de_trabajo"] . "</td></tr>";
				$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;color: #000066;font-weight: bold;margin:0px;margin-left:105px;'>" . $row["Titulo_de_trabajo"] . "</p>\n";
				$trabajo_anterior = $row["Titulo_de_trabajo"];
			}
			
			if ($row["Institucion"]!=""){
				$institucion = " - "  . $row["Institucion"];
			}else{
				$institucion = "";
			}
			
			if ($row["Pais"]!=""){
				$pais = " ("  . $row["Pais"] . ")";
			}else{
				$pais = "";
			}
			
			if ($row["En_calidad"]!=""){
        		$enCalidad = $row["En_calidad"] . ": ";
        	}else{
        		$enCalidad  = "";
        	}
			
		     if ($row["Curriculum"]!=""){
				if($_SESSION["registrado"] == true || $verCurriculums == true){
					$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row["Nombre"]. " " . $row["Apellidos"]. "'></a>";
				}else{
					$curriculum = "";
				}
			}else{
				$curriculum = "";
			}
			
			if ($row["Mail"]!=""){
				$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
				
				if($_SESSION["registrado"] == true || $verMails== true){
					$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
				}else{
					$mail = "";
				}
			}else{
				$mail = "";
			}

			
			if($row["En_calidad"]=="" && $row["Profesion"]=="" && $row["Nombre"]=="" && $row["Apellidos"]=="" && $row["Institucion"]=="" && $row["Pais"]==""){
			}else{
				echo "<tr><td colspan='3' class='trabajos'><span class='linea_persona'>" .$enCalidad . $row["Profesion"] . " <b>" . $row["Nombre"] . " " . $row["Apellidos"] . "</b>" . $institucion . $pais . $curriculum .$mail . "</span></td></tr>";
        		$imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size:12px;margin:0px;margin-left:105px;'>" . $enCalidad . $row["Profesion"] . " <b>" . $row["Nombre"] . " " . $row["Apellidos"] . "</b>" . $institucion . $pais .  "</p>\n";
			}
			
			if($row["Trabajo_libre"]==1){
        		echo "<tr><td colspan='3' class='trabajos'>";
        		//
				$sql0 ="SELECT * FROM trabajos_libres WHERE ID_casillero= '" . $row["Casillero"] . "' ORDER BY Hora_inicio, numero_tl ASC;";
				$rs0 = mysql_query($sql0,$con);
				while ($row0 = mysql_fetch_array($rs0)){
		 	?>
        	
        		<table width="100%"  border="1" cellpadding="0" cellspacing="4" bordercolor="#EFEFEF">
        <tr>
          <td bordercolor="#000000"><table width="100%"  border="0" cellspacing="0" cellpadding="3">
            <tr bgcolor="#D8D9DE">
              <td width="10%" align="center" valign="top" bgcolor="#999999"><b><font size="1" face="Arial, Helvetica, sans-serif">
                <?
				 echo substr($row0["Hora_inicio"], 0, -3). " a " . substr($row0["Hora_fin"],0 , -3);
				 $imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 10px;color: #000000;border-top-width: 1px;border-bottom-width: 1px;border-top-style: solid;border-top-color: #666666;margin:0px;margin-left:105px;margin-top:5px;'>" . substr($row0["Hora_inicio"], 0, -3) . " a " . substr($row0["Hora_fin"],0 , -3) . "<b><font size='2'>&nbsp;- Nº:". $row0["numero_tl"] . "&nbsp;</font></b></p>\n";

				  ?>
              </font></b>              
              <td width="90%" height="1"><b><font color="#990000" size="2">
</font></b>
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="96%"><b><font color="#990000" size="2">
                      <?
					  $row0["titulo_tl"];
					  $imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color: #333300;margin:0px;margin-left:180px;'>" .  $row0["titulo_tl"] . "</font></b></p>\n";
					  ?>
                    </font></b></td>
				<?
					if($_SESSION["registrado"] == true){
				?>
				
                    <td width="2%"><a href="modificarTrabajosLibres.php?id=<?=$row0["ID"]?>"><img src="img/modificar.png" alt="Modificar este trabajo libre" width="12" height="13" border="0"></a></td>
                    <td width="2%"><a href="javascript:eliminar_tl(<?=$row0["ID"]?>)"><img src="img/eliminar.png" alt="Eliminar este trabajo libre" width="11" height="13" border="0"></a></td>
                 <?
				 }
				 ?>
				  </tr>
                </table>
                </td>
            </tr>
            <tr>
              <td width="10%" rowspan="2" align="center" valign="middle" bgcolor="#999999"><font color="#FFFF00"><b><font color="#FFFF00"><b><font size="3">
                <?=$row0["numero_tl"]?>
              </font></b></font></b></font>              
              <td bgcolor="#F3F4F5"><p><font size="2">
                  <?
			 $imprimir .= "<p style='font-family: Arial, Helvetica, sans-serif;font-size: 12px;margin:0px;margin-left:180px;'>";
			 $soloPuntoComa = 0;

		     $sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres=".$row0["ID"]." ORDER BY ID ASC;";
			 $rs2 = mysql_query($sql2,$con);
		     while ($row2 = mysql_fetch_array($rs2)){

			 $sql3 ="SELECT * FROM personas WHERE ID_Personas =".$row2["ID_participante"].";";
			 $rs3 = mysql_query($sql3,$con);
		     while ($row3 = mysql_fetch_array($rs3)){
			 
		     	if ($row3["Curriculum"]!=""){
		     		if($_SESSION["registrado"] == true || $verCurriculums == true){
		     			$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row3["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row3["Nombre"]. " " . $row3["Apellidos"]. "'></a>";
		     		}else{
		     			$curriculum = "";
		     		}
		     	}else{
		     		$curriculum = "";
		     	}

		     	if ($row3["Mail"]!=""){
		     		$mail = "&nbsp;<a href='mailto:" . $row3["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";

		     		if($_SESSION["registrado"] == true || $verMails== true){
		     			$mail = "&nbsp;<a href='mailto:" . $row3["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		     		}else{
		     			$mail = "";
		     		}
		     	}else{
		     		$mail = "";
		     	}

					if($row2["lee"]==1){
                  			echo "<u>";
                  			$curA = "<u>";
                  			$curC = "</u>";

                  		}else{
                  			$curA = "";
                  			$curC = "";
                  		}

						if($soloPuntoComa == 1){
							echo "; ";
							$imprimir .="; ";
						}
						$soloPuntoComa = 1;
			 
		 		 echo $row3["Apellidos"].", ".$row3["Nombre"] . 	$curriculum  . $mail;
			     $imprimir .= $curA  .  $row3["Apellidos"] . ", " . $row3["Nombre"] . $curC ."";

			  if($row2["lee"]==1){echo "</u>";}
			   echo "; ";
			   
			 }
		  }
		$imprimir .= "</p>\n";

		   ?>
</font></p>
              <? 
				if($row0["archivo_tl"]!=""){
		   			if($_SESSION["registrado"] == true || $verTL == true){
			?>
       
         <div align="right"><a href="bajando_tl.php?id=<?=$row0["archivo_tl"]?>" target="_self"  class="link"><font size="2">Haga clic aquí para ver mas sobre este Trabajo Libre</font></a></div>
           
			<?
		   			}
			}
			?></td>
            </tr>
			
          </table></td>
        </tr>
      </table>
      <?
        		//
				}
        		//
        		echo "</td><tr>";
   
        	}
			
		}
		$_SESSION["paraImprimir"]=$imprimir;
	?>
    </table></td>
  </tr>
</table>
