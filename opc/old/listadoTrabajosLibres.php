<?
include('inc/sesion.inc.php');
?>
<style>

.link {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	text-decoration: none;
	color:#6600CC;
}
.link:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-style: normal;
	text-decoration: none;
	color:#0000FF;
}
.pais{
font-family:Arial, Helvetica, sans-serif;
color:#000033;
font-size:11px;
text-decoration:none;
}
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?
include('conexion.php');
include("inc/validarVistas.inc.php");


		$solo = false;
		  if ($_GET["filtro"]=="" || $_GET["filtro"]=="Todos"){
	     	 $sql ="SELECT * FROM trabajos_libres ORDER BY numero_tl ASC;";
		$solo = true;
		  }
		  if ($_GET["filtro"]=="Sin Clasificación"){
	     	 $sql ="SELECT * FROM trabajos_libres WHERE  ID_casillero='' ORDER BY numero_tl ASC;";
		  }
		  if ($_GET["filtro"]!="" && $_GET["filtro"]!="Sin Clasificación"  && $_GET["filtro"]!="Todos"){
	     	 $sql ="SELECT * FROM trabajos_libres WHERE  ID_casillero='" . $_GET["filtro"] . "' ORDER BY Hora_inicio, numero_tl ASC;";
		  }

/*$sql = "SELECT * FROM trabajos_libres ;";*/
$num_result = mysql_query($sql, $con);
$cant_tl = mysql_num_rows($num_result); 
?>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CFC2D6">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center">

      <p align="left"><a href="altaTrabajosLibres.php" class="link"><b>&nbsp;&nbsp;Crear trabajo libre nuevo </b> </a></p>
 <? if($cant_tl == '0' && $solo == true){?>    
<br>
<br>
<strong><font color="#CC0000" size="4"><p align="center">&nbsp;&nbsp;No hay Trabajos Libres ingresados </p></font></strong>
<? }else{ ?>
 <p align="center"><strong><font color="#666666" size="3">Listado de  Trabajos Libres</font></strong></p>
 <strong><font color="#666666" size="3"><p align="left">&nbsp;&nbsp;Hay  <font color="#CC0000"  size="3"><? echo $cant_tl; ?></font>&nbsp;trabajos libres en esta ubicación</p></font></strong>

      <p align="left"><font size="2">&nbsp;&nbsp;Ver ubicados en </font><font color="#333333" size="2">
        <select name="ID_casillero" id="ID_casillero" onChange="fliar(this.value)">
		<?
		if ($_GET["filtro"] == "Todos"){
		?><option value="Todos" selected>Todos</option><?
	}else{
		?><option value="Todos">Todos</option><?
	}
	?>
		
		<?
		if ($_GET["filtro"] == "Sin Clasificación"){
		?> <option style="background-color:#999999; color:#FF0000;" value="Sin Clasificación" selected>Sin Clasificación</option><?
	}else{
		?> <option style="background-color:#999999; color:#FF0000;" value="Sin Clasificación">Sin Clasificación</option><?
	}
	?>
         
          <?
				    $sql ="SELECT * FROM congreso WHERE Trabajo_libre = 1 ORDER BY Casillero ASC;";
					$rs = mysql_query($sql,$con);
					while ($row = mysql_fetch_array($rs)){
	
	if ($_GET["filtro"] == $row["Casillero"]){
		$sel= "selected";
	}else{
		$sel= "";
	}
				  ?>
          <option value="<?=$row["Casillero"]?>" <?=$sel?>>
          <?=$row["Dia"]?>
|
  <?=$row["Hora_inicio"]?> - <?=$row["Hora_fin"]?>
  |
  <?=$row["Sala"]?>
  |
  <?=$row["Titulo_de_actividad"]?>
          </option>
          <?
					 }
					 ?>
      </select><? } ?>
      </font><font color="#666666" size="3"><strong><br>
          </strong></font></p>
          <?
		  
		  if ($_GET["filtro"]=="" || $_GET["filtro"]=="Todos"){
	     	 $sql ="SELECT * FROM trabajos_libres ORDER BY numero_tl ASC;";
		  }
		  if ($_GET["filtro"]=="Sin Clasificación"){
	     	 $sql ="SELECT * FROM trabajos_libres WHERE  ID_casillero='' ORDER BY numero_tl ASC;";
		  }
		  if ($_GET["filtro"]!="" && $_GET["filtro"]!="Sin Clasificación"  && $_GET["filtro"]!="Todos"){
	     	 $sql ="SELECT * FROM trabajos_libres WHERE  ID_casillero='" . $_GET["filtro"] . "' ORDER BY Hora_inicio, numero_tl ASC;";
		  }
		  $rs = mysql_query($sql,$con);
		 while ($row = mysql_fetch_array($rs)){
	  ?>
      <br>
      <div align="left">
          <font size="2">&nbsp;&nbsp;Ubicado en:
          <?
					$relCasillero = "<font color='#ff0000'>Sin Clasificación</font>";
					$sql0 ="SELECT * FROM congreso WHERE Casillero = '".$row["ID_casillero"]."';";
					$rs0 = mysql_query($sql0,$con);
					while ($row0 = mysql_fetch_array($rs0)){
						$relCasillero =  "<font color='#666666'>".$row0["Dia"] ." | ".$row0["Hora_inicio"] ." - " .$row0["Hora_fin"]. " | " .$row0["Sala"] ." | </font><b>". $row0["Tipo_de_actividad"] ."</b> | ". $row0["Titulo_de_actividad"];           
					}
					echo $relCasillero;
					?>
</font> </div>
      <table width="100%"  border="1" cellpadding="0" cellspacing="4" bordercolor="#CCCCCC">
        <tr>
          <td bordercolor="#000000"><table width="100%"  border="0" cellspacing="0" cellpadding="3">
            <tr bgcolor="#D8D9DE">
              <td width="10%" align="center" valign="top" bgcolor="#999999"><b><font size="1" face="Arial, Helvetica, sans-serif">
                <?
				 echo substr($row["Hora_inicio"], 0, -3). " a " . substr($row["Hora_fin"],0 , -3);
				  ?>
              </font></b>              
              <td width="90%" height="1"><b><font color="#990000" size="2">
</font></b>
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="96%"><b><font color="#990000" size="2">
                      <?=$row["titulo_tl"]?>
                    </font></b></td>
				<?
					if($_SESSION["registrado"] == true){
				?>
				
                    <td width="2%"><a href="modificarTrabajosLibres.php?id=<?=$row["ID"]?>"><img src="img/modificar.png" alt="Modificar este trabajo libre" width="12" height="13" border="0"></a></td>
                    <td width="2%"><a href="javascript:eliminar_tl(<?=$row["ID"]?>)"><img src="img/eliminar.png" alt="Eliminar este trabajo libre" width="11" height="13" border="0"></a></td>
                 <?
				 }
				 ?>
				  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td width="10%" rowspan="2" align="center" valign="middle" bgcolor="#999999"><font color="#FFFF00"><b><font color="#FFFF00"><b><font size="3">
                <?=$row["numero_tl"]?>
              </font></b></font></b></font>              
              <td bgcolor="#F3F4F5"><font size="2">
                  <? 
			 $soloPuntoComa = 0;
			 $primero = 0;
				
		     $sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres=".$row["ID"]." ORDER BY ID ASC;";
			 $rs2 = mysql_query($sql2,$con);
		     while ($row2 = mysql_fetch_array($rs2)){

			 $sql3 ="SELECT * FROM personas WHERE ID_Personas =".$row2["ID_participante"].";";
			 $rs3 = mysql_query($sql3,$con);
		     while ($row3 = mysql_fetch_array($rs3)){
				
			 if($row2["lee"]==1){echo "<u>";}
			 
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
			if($soloPuntoComa == 1){
				echo "; ";
				$imprimir .="; ";
			}
			$soloPuntoComa = 1;

		 		if($primero == 0){
						
						
						if($row3["Institucion"]!=''){
						$aster = "(*) ";
						$inst_primero = "(*) " . $row3["Institucion"];
						}else{
						$inst_primero='';
						$aster = "";
						}
							if($inst_primero == ""  ){
						$pais_primero = $row3["Pais"];
							}else{
								if($row3["Pais"] == ""){
								$pais_primero = "";
								}else{
						$pais_primero =  " / " . $row3["Pais"]  ;
							}}						
						}else{
						$aster = "";
						}
						$primero=1; 
					
					//PARA QUE NO SALGA SI NO TIENE AUTORES
					if($row3["Apellidos"]!="" or $row3["Nombre"]!=""){	
                  		echo $row3["Apellidos"].", ".$row3["Nombre"] . $aster . $curriculum .$mail  ;
						}
						
						
			  if($row2["lee"]==1){echo "</u>";}
			 
	   				
			 }
		  }
		 
		  
			
			     echo "<tr><td bgcolor = '#F3F4F5' class='pais'>". $inst_primero . $pais_primero ;
			
	
		   ?>
</font>
              <? 
				if($row["archivo_tl"]!=""){
		 		 if($_SESSION["registrado"] == true || $verTL == true){
			?>
     
       		  <div align="right"><a href="bajando_tl.php?id=<?=$row["archivo_tl"]?>" target="_self"  class="link"><font size="2">Haga clic aquí para ver mas sobre este Trabajo Libre</font></a></div></td></tr>
           
			<?
				}
			}
			?></td>
            </tr>
			
          </table></td>
        </tr>
      </table>
  	  <?
	  }
	  ?>
      <p>&nbsp;</p>
    </div>
      <br></td>
  </tr>
</table>


<script language="javascript">
 	 function eliminar_tl(cual){
 		var return_value = confirm("¿Esta seguro que desea eliminar este trabajo libre?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarTrabajoLibre.php?id=" + cual;
		 }
	 }
	  function fliar(cual){
 		
			 document.location.href = "?filtro=" + cual;

	 }
</script>