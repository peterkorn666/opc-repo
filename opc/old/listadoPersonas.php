<script src="js/personas.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
body{
background-color:#666666;
 
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><table width="100%" border="1" cellpadding="2" cellspacing="2" bordercolor="#666666" bgcolor="#666666">
  <tr bordercolor="#CCCCCC">
    <?
	include "conexion.php";
	$indice = $_GET["indice"];

	if(($indice == "Todos")||($indice == "") ){
	$alto = 290;
	$buscar_indice= '';
	}else{
	$alto = 272;
	$buscar_indice= "WHERE apellido like '".$indice."%'";
	$buscar_indice2= "WHERE Apellidos like '".$indice."%'";
	}
	
		$sql1 = "SELECT * FROM personas WHERE deDonde=''";
		$num_result1 = mysql_query($sql1, $con);
		$cant_pers_total = mysql_num_rows($num_result1); 
		if($indice != ""){
			$sql = "SELECT * FROM personas_trabajos_libres $buscar_indice2";
			$num_result = mysql_query($sql, $con);
			$cant_pers = mysql_num_rows($num_result); 
		}

/*
$sql = "SELECT * FROM personas $buscar_indice";

$num_result = mysql_query($sql, $con);
$cant_pers = mysql_num_rows($num_result); */
?>
    <td height="10" valign="top"  bordercolor="#000000" bgcolor="#000000"><p><font color="#FFFFFF" size="2"><strong>Personas Ingresadas (<? echo $cant_pers_total; ?>):</strong></font><br>
<? if(($indice!='Todos') && ($indice != '')){?>
        <font color="#FFFFFF" size="2"><strong> Que empiezen con <font color="#FFFF33">
        <?=$indice;?>
        </font>
          <? }?>
        </strong></font></p></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td height="35" valign="top"  bordercolor="#FFFFFF" bgcolor="#FFFFFF" ><div align="center">
<? $abc = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","&Ntilde;","O","P","Q","R","S","T","U","V","W","X","Y","Z");
								foreach($abc as $i){
								
								if($_GET["indice"] ==$i){
									$estIndice = "style='background-color:#ff9999;'";
								}else{
									$estIndice = "";
								}?>
      <a href="?indice=<?=$i?>"  class="linkIndice" <?=$estIndice?>>&nbsp;
        <?=$i?>
        &nbsp;</a>-
      <?
					 	}
							if($_GET["indice"] =="" || $_GET["indice"] =="Todos"){
									$estIndice = "style='background-color:#ff9999;'";
								}else{
									$estIndice = "";
								}
					  ?>
      <a href="?indice=Todos" class="linkIndice" <?=$estIndice?>>&nbsp;Todos&nbsp;</a></div></td>
  </tr>
</table>
<div style="background-color:#FFF; padding:2px; margin:2px 4px 2px 4px"><font size="2">Con marca: <a href="#" onClick="unificarPersona()">Unificar Persona</a></font></div>

<div style="height:<?=$alto?>; overflow:auto;">
<table width="100%" height="100%" border="1" cellpadding="2" cellspacing="2" bordercolor="#666666" bgcolor="#666666">
  <tr bordercolor="#CCCCCC">
    <td valign="top" bordercolor="#FFFFCC" bgcolor="#FFFFCC">
      <form action="unificarPersonas.php" method="post" name="formP" id="formP">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <?
	
	if($indice!=''){
		if($buscar_indice==""){
			$filtro = "WHERE deDonde=''";
		}else{
			$filtro = "$buscar_indice AND deDonde=''";
		}
	$sql = "SELECT * FROM personas $filtro ORDER by apellido,nombre ASC";

	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){

		
		if ($row["Institucion"]!=""){
			$institucion = "<span style='font-size:9px'> - "  . $row["Institucion"] . "</span>";
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

		if ($row["Curriculum"]!=""){
			$curriculum = "&nbsp;<a href='bajando_cv.php?id=" .  $row["Curriculum"] . "' target='_self'><img src='img/logo_curriculum.gif' width='15' height='17' border='0' alt='Descargar curriculum de " .$row["Nombre"]. " " . $row["Apellidos"]. "'></a>";
		}else{
			$curriculum = "";
		}
		
		$idiom = "";
		switch ($row["idiomaHablado"]) {
			case "Spanish":
				$idiom = "<img border='0' src='img/es.png' />";
				break;
			case "English":
				$idiom = "<img border='0' src='img/gb.png' />";
				break;
		}
		
		if ($row["Mail"]!=""){
			$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
		}else{
			$mail = "";
		}
		
		
		
	  ?>
          <tr valign="top">
            <td width="30"><font size="2">
          <?
					  
					  echo  "<a href='altaPersonas.php?id=" . $row["ID_Personas"]  .  "'  target='_parent'> <img src='img/modificar.png' border='0' alt='Modificar esta persona'></a>";
					 echo  "<a href='javascript:eliminar_persona(" .  $row["ID_Personas"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta persona'></a> ";
					?>
            </font></td>
            <td width="20"><input name="uni[]" type="checkbox" id="uni[]" value="<?=$row["ID_Personas"]?>"></td>
            <td width="1188"><font size="2">
              <?
				  echo " <b>" . $row["apellido"] . ", " . $row["nombre"] . "</b> " . $pais . $curriculum . "&nbsp;". $idiom ."&nbsp;". $mail . $Inscripto .  "<br>";

//				  echo " <b>" . $row["Apellidos"] . ", " . $row["Nombre"] . "</b> " . $profesion  . $pais . $institucion . $curriculum . "&nbsp;". $idiom ."&nbsp;". $mail . $Inscripto .  "<br>";
				  
?>
            </font></td>
          </tr>
          <?
				}
	}//fin del if($indice

				?>
        </table>
      </form>      </td>
  </tr>
 

</table></div>
</body>




<script>
function unificarPersona(){
	document.formP.target = "_parent";
	document.formP.submit();
	//document.listado.formP.submit();
}
</script>
