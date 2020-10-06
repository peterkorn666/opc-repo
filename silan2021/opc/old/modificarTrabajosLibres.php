<?
include ('inc/sesion.inc.php');

$id_modificar =  $_GET["id"] ;
?>

<link href="estilos.css" rel="stylesheet" type="text/css">
<?
include('conexion.php');
?>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><br>      
          <strong><font color="#666666" size="3">Modificar Trabajos Libres</font></strong></div>
      <form action="altaTrabajosLibresEnviar.php" method="post" enctype="multipart/form-data" name="form1">
        <table width="100%" border="00" cellspacing="2" cellpadding="2">
          <tr>
            <td height="10"><div align="center"><font size="2">
                <input type="submit" name="Submit" value="Enviar a la Base de datos" style="background-color:#FF99FF; ">
            </font></div></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td><font size="2"> <font color="#333333">Hora inicio:
                      </font>
                  <select name="hora_inicio_tl" id="hora_inicio_tl">
                      <?
		  $sql = "SELECT Hora_inicio FROM trabajos_libres WHERE ID = $id_modificar;";
		  $rs = mysql_query($sql, $con);
		  while ($row = mysql_fetch_array($rs)){
			 $cual_horai_selc = $row["Hora_inicio"];
		}
	
$sql = "SELECT * FROM horas ORDER by Hora ASC";
$rs = mysql_query($sql,$con);

while ($row = mysql_fetch_array($rs)){

		if($cual_horai_selc == $row["Hora"]){
			 $horai_sel="selected";
		}else{
			 $horai_sel="";
		}
?>
                      <option value="<? echo $row["Hora"]; ?>" <?=$horai_sel?>><? echo $row["Hora"]; ?></option>
                      <?
}
?>
                    </select>
                      <font color="#333333">&nbsp;&nbsp;Hora fin:</font>    
                    <select name="hora_fin_tl" id="hora_fin_tl">
      <?
		  $sql = "SELECT Hora_fin FROM trabajos_libres WHERE ID = $id_modificar;";
		  $rs = mysql_query($sql, $con);
		  while ($row = mysql_fetch_array($rs)){
			 $cual_horaf_selc = $row["Hora_fin"];
		  }

$sql = "SELECT * FROM horas ORDER by Hora ASC";
$rs = mysql_query($sql,$con);

while ($row = mysql_fetch_array($rs)){

		if($cual_horaf_selc == $row["Hora"]){
			 $horaf_sel="selected";
		}else{
			 $horaf_sel="";
		}
?>
      <option value="<? echo $row["Hora"]; ?>" <?=$horaf_sel?>><? echo $row["Hora"]; ?></option>
      <?
}
?>
    </select>
&nbsp;<a href="altaHora.php">Agregar nuevo horario</a></font></td>
              </tr>
              <tr>
                <td><div align="left"> <font color="#333333" size="2"><br>
                  </font>
                  <font color="#333333" size="2">N&ordm; de TL:</font><font size="2">
                  <select name="numero_tl" id="numero_tl">
				    <?
					 $sql = "SELECT numero_tl FROM trabajos_libres WHERE ID = $id_modificar;";
					 $rs = mysql_query($sql,$con);
					 while ($row = mysql_fetch_array($rs)){
					   $numTL= $row["numero_tl"];
					 }
				    for($i=1;$i<=1000;$i++){
							if($i==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
				    ?>
				  
                      <option value="<?=$i?>" <?=$numTLsel?>><?=$i?></option>
					  
					        
					    <?
					}
					for($mil=1001;$mil<=1015;$mil++){
						if($mil==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$mil?>" <?=$numTLsel?>><?=$mil?></option>
    				<?
					} for($dos=2000;$dos<=2015;$dos++){
						if($dos==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$dos?>" <?=$numTLsel?>>
                        <?=$dos?>
                        </option>
    				<?
					} for($tres=3000;$tres<=3020;$tres++){
						if($tres==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$tres?>" <?=$numTLsel?>>
                        <?=$tres?>
                        </option>
    				<?
					} for($cuatro=4000;$cuatro<=4030;$cuatro++){
						if($cuatro==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$cuatro?>" <?=$numTLsel?>>
                        <?=$cuatro?>
                        </option>
    				<?
					} for($cinco=5000;$cinco<=5010;$cinco++){
						if($cinco==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$cinco?>" <?=$numTLsel?>>
                        <?=$cinco?>
                        </option>
    				<?
					} for($seis=6000;$seis<=6010;$seis++){
						if($seis==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$seis?>" <?=$numTLsel?>>
                        <?=$seis?>
                        </option>
    				<?
					} for($siete=7000;$siete<=7015;$siete++){
						if($siete==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$siete?>" <?=$numTLsel?>>
                        <?=$siete?>
                        </option>
    				<?
					} for($ocho=8000;$ocho<=8010;$ocho++){
						if($ocho==$numTL){
							$numTLsel="selected";
							}else{
							$numTLsel="";
							}
					?>
  						<option value="<?=$ocho?>" <?=$numTLsel?>>
                        <?=$ocho?>
                        </option>
    				<?
					} ?>

                   </select>
                   </font><font color="#333333" size="2">&nbsp;&Aacute;rea:
				            
		  		   <select name="tematica" id="tematica"> 
  				   <option ></option>      
                     <?

$sql_tema = "SELECT tematica FROM trabajos_libres WHERE ID = " .$id_modificar ;
$rs_tema = mysql_query($sql_tema, $con);
while ($row_tema = mysql_fetch_array($rs_tema)){
$tematica = $row_tema["tematica"]; 

 }

			$sql = "SELECT * FROM tematicas ORDER by Tematica ASC";
			$rs = mysql_query($sql,$con);
			while ($row = mysql_fetch_array($rs)){

			if($row["Tematica"]==$tematica){
				$sel_tema2 = "selected";
			}else{
				$sel_tema2 = "";
			}

					?>
                     <option value="<?=$row["Tematica"];?>" <?=$sel_tema2?>> <? echo $row["Tematica"]; ?></option> 
                     <?
						}
					?>
                   </select> 
                   </font><font size="2"><br>
                   </font>
               </div></td>
              </tr>
              <tr>
                <td height="38"><font color="#333333" size="2">Ubicarlo en la actividad</font><font size="2">                    
                  <select name="ID_casillero" id="select">
  					                     
					<option value=""  style="background-color:#999999; color:#FF0000;" selected>Sin Clasificación</option>
                      <?
					$sql11 = "SELECT ID_casillero FROM trabajos_libres WHERE ID = $id_modificar;";
					$rs11 = mysql_query($sql11,$con);
					while ($row11 = mysql_fetch_array($rs11)){
						$casilleroSel = $row11["ID_casillero"];
					}
					 
					 
				    $sql ="SELECT * FROM congreso WHERE trabajo_libre = 1 ORDER BY Casillero ASC;";
					$rs = mysql_query($sql,$con);
					while ($row = mysql_fetch_array($rs)){
			
			if($casilleroSel==$row["Casillero"]){
				$selCasillero = "selected";
			}else{
				$selCasillero = "";
			}


				  ?>
                      <option value="<?=$row["Casillero"]?>" <?=$selCasillero?>>
                      <?
					 echo "<font color='#666666'>".$row["Dia"] ." | ". $row["Hora_inicio"] ." - " .$row["Hora_fin"]. " | ". $row["Sala"] ." | </font><b>". $row["Tipo_de_actividad"] ."</b> | ". $row["Titulo_de_actividad"];           
					?>
                      </option>
                      <?
					 }
					 ?>
                    </select>
                </font></td>
              </tr>
              <tr>
                <td height="65"><div align="left"> <font color="#333333" size="2">Titulo TL:</font><font size="2">
                    </font>  <font size="2">
					 <?
					 $sql = "SELECT titulo_tl FROM trabajos_libres WHERE ID = $id_modificar;";
					$rs = mysql_query($sql,$con);
					while ($row = mysql_fetch_array($rs)){
					?>
                    <input name="titulo_tl" type="text" id="trabajo_" value="<?=$row["titulo_tl"]?>" size="110">
					<?
					}
					?>
 <hr>               </font></div></td>
              </tr>
              <tr valign="top">
                <td bordercolor="#000000"><font size="2">                  <br>
                    <font color="#333333">                  </font></font>
                  <table width="100%"  border="0" cellspacing="0" cellpadding="3">
					<?
					if($_GET["cuantosCoAutores"]==""){
						$sql7 = "SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = $id_modificar;";
						$rs7 = mysql_query($sql7,$con);
						$cuantosCoAutores = 0;
						while ($row7 = mysql_fetch_array($rs7)){  
							$cuantosCoAutores =  $cuantosCoAutores+1;
						}
						$cuantosCoAutores =  $cuantosCoAutores-1;
					}else{
						$cuantosCoAutores = $_GET["cuantosCoAutores"];
					}
					$solo1=0;
					for($i=0;$i<=$cuantosCoAutores;$i++){
					?>
                    <tr>
                      <td width="9%"><font size="2">
					    <?
					  if($solo1==0){
					 	 echo "Autor";
					 	 $solo1=1;
					  }else{
						  echo "Co-Autor";
					  }
					  ?>
					  <font size="2"> </font></font></td>
                      <td width="91%"><font size="2"><font size="2">
                        <select name="autor[]" id="autor[]">
						
<?
$sql8 = "SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = $id_modificar ORDER BY ID LIMIT $i,1 ;";
$rs8 = mysql_query($sql8,$con);
while ($row8 = mysql_fetch_array($rs8)){  
	$personaSelect =  $row8["ID_participante"];
	$personaLee = $row8["lee"];
}
?>
						
						
                          <option selected></option>
                          <?
$sql = "SELECT * FROM personas ORDER by Apellidos, Nombre  ASC";
$rs = mysql_query($sql,$con);

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
		if ($row["Profesion"]!=""){
			$profesion = "(".$row["Profesion"].")";
			}else{
			$profesion = "";
		}
		
		if ($row["ID_Personas"]==$personaSelect){
			$perSelect = "selected";
		}else{
			$perSelect = "";
		}
		
		


?>
                          <option value="<?=$row["ID_Personas"]?>" <?=$perSelect?>>
                          <?  echo " <b>" . $row["Apellidos"] . ", " . $row["Nombre"] . "</b>" . $profesion .  $pais . $curriculum . "<br>";?>
                          </option>
                          <?
}
			if($personaLee==1){
				$autorLee="selected";
			}else{
				$autorLee="";
			}
?>
                        </select>
                        <font size="2">
<select name="autor_lee[]" id="autor_lee[]">
                          <option value="0" style="background-color:#999999;">No lee</option>
                          <option value="1"  style="background-color:#FFFF00;" <?=$autorLee?>>Si lee</option>
 </select>
<a href="altaPersonas.php">Agregar nueva persona</a>&nbsp; </font></font></font></td>
                    </tr>
					
					<?
					}
					?>
                  </table>
                  <div align="right"><font size="2"><font color="#333333"><a href="?id=<?=$id_modificar?>&cuantosCoAutores=<? echo $cuantosCoAutores-1;?>">-</a> | <a href="?id=<?=$id_modificar?>&cuantosCoAutores=<? echo $cuantosCoAutores+1;?>">+</a></font></font></div></td>
              </tr>
              <tr valign="top">
                <td><font size="2">Archivo del Trabajo libre
				    <?
				 $sql = "SELECT archivo_tl FROM trabajos_libres WHERE ID = $id_modificar;";
				 $rs = mysql_query($sql,$con);
				 while ($row = mysql_fetch_array($rs)){
					
					  if($row["archivo_tl"]!=""){
					  	echo "&nbsp;Existente: <b>'".$row["archivo_tl"]."'</b><br>"; 
							$archivoExistente = $row["archivo_tl"];
							
							?>
							<br><input name="eliminarTL" type="checkbox" value="1"> Eliminar este archivo
							<?
							
							echo "<br><br>Desea colocarle uno nuevo&nbsp;";
					  }
					?>
                    <input name="archivo" type="file" id="archivo">
				    <?
					}
					?>
				</font></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>
              <div align="center">
                <font size="2">
                <input type="submit" name="Submit" value="Enviar a la Base de datos" style="background-color:#FF99FF; ">
                <input name="ID_viejo" type="hidden" id="ID_unico_viejo" value="<?=$id_modificar?>">
				    <input name="archivoExistente" type="hidden" id="archivoExistente" value="<?=$archivoExistente?>">
</font>                </div></td></tr>
        </table>
      </form>
</td>
  </tr>
</table>


<script language="javascript">
	function activarSeLlamara(valor){
		if(valor > 1){
			document.getElementById('se_expanira_').style.visibility = "visible";
			document.getElementById('se_expanira_').style.height = "auto";
		}else{
			document.getElementById('se_expanira_').style.visibility = "hidden";	
			document.form1.seLlamara_tex.value="";
			document.form1.seLlamara_com.value="";
			document.getElementById('se_expanira_').style.height = 0;
		}
	}
	document.getElementById('se_expanira_').style.visibility = "hidden";
	
	function validarFin(){
		form1.hora_fin_.value = form1.hora_inicio_.value;
	}
</script>