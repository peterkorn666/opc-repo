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
	
		if(($indice == "Todos")||($indice == "")){
			$alto = 1080;
			$buscar_indice= '';
		}else{
			$alto = 1080 ;
			$buscar_indice= "WHERE Apellidos like '".$indice."%'";
		}
		$buscarp = "";
		$textP = "";
		if($_GET["buscarp"]!=""){
			$textP = $_GET["buscarp"];
			$buscarp = "WHERE Nombre LIKE '%$textP%' or Apellidos LIKE '%$textP%' or Institucion LIKE '%$textP%' or Mail LIKE '%$textP%' or Pais LIKE '%$textP%' or ID_Personas LIKE '%$textP%'";
		}
		
		//echo "bbbb";
			$sql1 = "SELECT * FROM personas_trabajos_libres";
			$num_result1 = mysql_query($sql1, $con);
			$cant_pers_total = mysql_num_rows($num_result1); 
		if($indice != "" or $buscarp!=''){
			$sql = "SELECT * FROM personas_trabajos_libres $buscar_indice";
			$num_result = mysql_query($sql, $con);
			$cant_pers = mysql_num_rows($num_result); 
		}


	


//echo $indice;
?>
    <td height="10" valign="top"  bordercolor="#000000" bgcolor="#000000"><p><font color="#FFFFFF" size="2"><strong>Personas Ingresadas (<? echo $cant_pers_total; ?>):</strong></font><br>
            <?
if(($indice!='Todos') && ($indice != '')){
?>
            <font color="#FFFFFF" size="2"><strong> Que empiezen con <font color="#FFFF33">
            <?=$indice;?>
            </font> (
              <?=$cant_pers?>
              )
              <? 
							  }
							  ?>
        </strong></font></p></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td height="35" valign="top"  bordercolor="#FFFFFF" bgcolor="#FFFFFF" >
    
    <div align="center">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="GET"><input type="text" name="buscarp" placeholder="Buscar persona" value="<?=$textP?>"> 
    <strong>(<span id="cantidadp">0</span>)</strong>
    </form>
      <?
								$abc = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","&Ntilde;","O","P","Q","R","S","T","U","V","W","X","Y","Z");
								foreach($abc as $i){
								
								if($_GET["indice"] ==$i){
									$estIndice = "style='background-color:#ff9999;'";
								}else{
									$estIndice = "";
								}
								?>
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
<div style="background-color:#FFF; padding:2px; margin:2px 4px 2px 4px"><font size="2">Con marca: <a href="#" onClick="unificarPersona()">Unificar Persona</a></font> | <a href="javascript:marcarInscripto()">Inscripto</a></div>

<div style="height:<?=$alto?>; overflow:auto;">
<table width="100%" height="100%" border="1" cellpadding="2" cellspacing="2" bordercolor="#666666" bgcolor="#666666">
  <tr bordercolor="#CCCCCC">
    <td valign="top" bordercolor="#FFFFCC" bgcolor="#FFFFCC">
      <form action="unificarPersonasTL.php" method="post" name="formP" id="formP">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <?
	
	if($indice!='' or $buscarp!=''){
		//echo "aaa".$indice;
	$sql = "SELECT * FROM personas_trabajos_libres $buscar_indice $buscarp ORDER by  Apellidos,Nombre ASC";

	$rs = mysql_query($sql,$con);
	$cantidades = mysql_num_rows($rs);
	echo "<script>document.getElementById('cantidadp').innerHTML = '$cantidades';</script>";
	while ($row = mysql_fetch_array($rs)){

		
		if ($row["Institucion"]!=""){
			$sqlI = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='".$row["Institucion"]."'",$con);
			$rowI = mysql_fetch_array($sqlI);
			$institucion = " - "  . $rowI["Institucion"];
		}else{
			$institucion = "";
		}
		
		
			
		if ($row["Pais"]!=""){
			$sqlP = mysql_query("SELECT * FROM paises WHERE ID_Paises='".$row["Pais"]."'",$con);
			$rowP = mysql_fetch_array($sqlP);
			$pais = " ("  . $rowP["Pais"] . ")";
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
		if ($row["Mail"]!=""){
			//$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'><img src='img/logo_mail.gif' border='0' alt='Enivar mail a esta persona'></a>";
			$mail = "&nbsp;<a href='mailto:" . $row["Mail"]  . "'>".$row["Mail"]."</a> ";
		}else{
			$mail = "";
		}
		if ($row["inscripto"]=="1"){
					$Inscripto = "<img src='img/puntoVerde.png' />&nbsp;";
		}
		else{
					$Inscripto = "";
		}		
		
	  ?>
          <tr valign="top">
            <td width="39"><font size="2">
              <?
				echo  "<a href='altaPersonasTL.php?id=" . $row["ID_Personas"]  .  "'  target='_parent'> <img src='img/modificar.png' border='0' alt='Modificar esta persona'></a>";
				echo  "<a href='javascript:eliminar_personaTL(" .  $row["ID_Personas"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta persona'></a> ";
				?>
            </font></td>
            <td width="28"><input name="uni[]" type="checkbox" id="uni[]" value="<?=$row["ID_Personas"]?>"></td>

                <td width="17" style="font-size:9px"><?="[".$row["ID_Personas"]."]"?></td>
                <td width="123" align="left" nowrap style="font-size:9px"><?=$row["Apellidos"]?></td>
                <td width="184" align="left" nowrap style="font-size:9px"><?=$row["Nombre"]?></td>
                <td width="93" align="left"><?=$mail?></td>
                <td width="445" align="left" style="font-size:9px"><?=$institucion?></td>
                <td width="17" align="left" style="font-size:9px"><?=$profesion?></td>
                <td width="17" align="left" style="font-size:9px"><?=$pais?></td>
                <td width="17" align="left" style="font-size:9px"><?=$curriculum?></td>
                <td width="25" align="left" style="font-size:9px"><?=$Inscripto?></td>

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

function marcarInscripto(){
	document.formP.target = "_parent";
	document.formP.action = "marcarInscriptoTL.php";
	document.formP.submit();
	//document.listado.formP.submit();
}

<?
if($_GET["estado"]=="ok"){
?>
alert("Se marcaron los participantes correctamente.");
document.location.href="altaPersonasTL.php";
<?
}
if($_GET["insc"]!=""){
?>
alert("Algunos participantes no se marcaron como inscripto: <?=$_GET["insc"]?>");
document.location.href="altaPersonasTL.php";
<?
}
?>

</script>
