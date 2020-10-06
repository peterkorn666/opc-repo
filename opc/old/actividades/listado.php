<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");
if($_SESSION["LogIn"]!="ok"){
	header("Location: login.php");
}
if($_SESSION["LogIn"]=="ok"){
include('../conexion.php');
require("../clases/class.baseController.php");
$base = new baseController();

$letra = $_GET["letra"];
$sql0 = "SELECT * FROM personas;";
//$sql0 = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso,personas
			//	WHERE congreso.ID_persona<>0 and  congreso.ID_persona = personas.ID_Personas ORDER by personas.apellido ASC;";
$rs0 = mysql_query($sql0,$con);
$cantidad0 = mysql_num_rows($rs0);

//Filtro
$palabra_clave = $_POST["palabra_clave"];
$area_actividad = $_POST["area_actividad"];
$categoria_ana = $_POST["categoria_ana"];
$roles = $_POST["roles"];
$confirma_viene = $_POST["confirma_viene"];
$financiado_por = $_POST["financiado_por"];

$filtro = 1;

if($palabra_clave!=""){
	$filtro .= " AND (personas.apellido LIKE '%$palabra_clave%' or personas.nombre LIKE '%$palabra_clave%' or personas.email LIKE '%$palabra_clave%' or personas.institucion LIKE '%$palabra_clave%' or personas.ID_Personas='$palabra_clave')";
}

if($confirma_viene!=""){
	$filtro .= " AND actividad_confirma_viene='$confirma_viene'";
}

//echo count($area_actividad);
if(count($area_actividad)>1){
		for($i=0;$i<count($area_actividad);$i++){
			if($area_actividad[$i]!=""){
				if($i==0){
					$sig = " AND (";
				}else{
					$sig = "OR";
				}
				if($area_actividad[$i]!="vacios"){
					$filtro .= " $sig actividad_areas = '$area_actividad[$i]'";
				}else{
					$filtro .= " $sig actividad_areas = ''";
				}
			}
			if($i+1==count($area_actividad)){
				$filtro .= ")";
			}
		}
	
}else{
	if($area_actividad[0]=="vacios"){
		$filtro .= " AND actividad_areas = ''";
	}else if($area_actividad[0]!=""){
		$filtro .= " AND actividad_areas = '$area_actividad[0]'";
	}
}


if(count($categoria_ana)>1){
		for($i=0;$i<count($categoria_ana);$i++){
			if($categoria_ana[$i]!=""){
				if($i==0){
					$sig = " AND (";
				}else{
					$sig = "OR";
				}
				if($categoria_ana[$i]!="vacios"){
					$filtro .= " $sig actividad_categoriaAna = '$categoria_ana[$i]'";
				}else{
					$filtro .= " $sig actividad_categoriaAna = ''";
				}
				if($i+1==count($categoria_ana)){
					$filtro .= ")";
				}
			}
		}
	
}else{
	if($categoria_ana[0]=="vacios"){
		$filtro .= " AND actividad_categoriaAna = ''";
	}else if($categoria_ana[0]!=""){
		$filtro .= " AND actividad_categoriaAna = '$categoria_ana[0]'";
	}
}

if(count($roles)>1){
		for($i=0;$i<count($roles);$i++){
			if($roles[$i]!=""){
				if($i==0){
					$sig = " AND (";
				}else{
					$sig = "OR";
				}
				if($roles[$i]!="vacios"){
					$filtro .= " $sig En_calidad = '$roles[$i]'";
				}else{
					$filtro .= " $sig En_calidad is NULL";
				}
				if($i+1==count($roles)){
					$filtro .= ")";
				}
			}
		}
	
}else{
	if($roles[0]=="vacios"){
		$filtro .= " AND En_calidad is NULL";
	}else if($roles[0]!=""){
		$filtro .= " AND En_calidad = '$roles[0]'";
	}
}

if(count($financiado_por)>1){
		for($i=0;$i<count($financiado_por);$i++){
			if($financiado_por[$i]!=""){
				if($i==0){
					$sig = " AND (";
				}else{
					$sig = "OR";
				}
				if($financiado_por[$i]!="vacios"){
					$filtro .= " $sig actividad_financiado  = '$financiado_por[$i]'";
				}else{
					$filtro .= " $sig actividad_financiado  = ''";
				}
				if($i+1==count($financiado_por)){
					$filtro .= ")";
				}
			}
		}
	
}else{
	if($financiado_por[0]=="vacios"){
		$filtro .= " AND actividad_financiado =''";
	}else if($financiado_por[0]!=""){
		$filtro .= " AND actividad_financiado = '$financiado_por[0]'";
	}
}


if(strlen($filtro)>1){
	$filtro = substr($filtro,6);
}
//--Filtro

if($_GET["orden"]!=""){
	if(strpos($_GET["orden"], ".")===false){
		$orden = $_GET["orden"]." ASC";
	}else{
		$orden = explode(".",$_GET["orden"]);
		$orden = $orden[0]." ".$orden[1];
	}
}else{
	$orden = "apellido ASC";
}

if($letra!=""){
	$filtro .= " AND apellido LIKE '$letra%'";
}

//$sql = "SELECT * FROM personas WHERE $filtro  ORDER BY $orden;";
//echo $sql;

$sql = "SELECT Distinct congreso.ID_persona, personas.* FROM congreso RIGHT JOIN personas ON congreso.ID_persona = personas.ID_Personas
				WHERE $filtro ORDER by $orden";
				//AND congreso.ID_persona<>0 
//echo $sql;				
$rs = $con->query($sql);
if(!$rs){
	die($con->error);
}
$cantidad = $rs->num_row;
$sql2 = "SELECT DISTINCT * FROM actividades WHERE idPersonaNueva = '".$row["ID_Personas"]."' ;";
$rs2 = $con->query($sql2);
if(!$rs2){
	die($con->error);
}
$row2 = $rs2->num_row;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Listado de conferencistas</title>
<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".selectAll").click(function(){
		if($(".personas").is(":checked")){
			$(".personas").attr("checked",false)
		}else{
			$(".personas").attr("checked", true)
		}
	})
	
	$(".envio_mail").click(function(e){
		e.preventDefault();
		document.conf.submit();
	})
});
</script>
</head>
<body style="font-family:Arial, Helvetica, sans-serif; background-color:#005395">
<center>

<table width="800" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td style="padding:0px" align="center"><img src="../../images/banner.jpg" /></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td style="font-size:12px;" bgcolor="#FFFFFF"><div style="text-align:right; padding-right:25px; vertical-align:middle; width:300px; float:right">
      <table width="100%" border="0" cellspacing="2" cellpadding="1">
        <tr>
          <td align="center"><a href="../registroSolicitud.php" style="text-decoration:none; color:#003366; font-weight:bold"><img src="img/excel.png"  border="0px"/></a></td>
          <td align="center"><a href="../todoslosconferencistasXLS.php" style="text-decoration:none; color:#003366; font-weight:bold"><img src="img/excel.png"  border="0px"/></a></td>
          <td align="center"><a href="../seleccionar_panel_simple.php" style="text-decoration:none; color:#003366; font-weight:bold; vertical-align:middle" target="_blank"><img src="img/opc.png" border="0px"/></a></td>
        </tr>
        <tr>
          <td align="center"><a href="../registroSolicitud.php" style="text-decoration:none; color:#003366; font-weight:bold">Excel Solicitudes&nbsp;</a></td>
          <td align="center"><a href="../todoslosconferencistasXLS.php" style="text-decoration:none; color:#003366; font-weight:bold">Excel Completo</a></td>
          <td align="center"><a href="../seleccionar_panel_simple.php" style="text-decoration:none; color:#003366; font-weight:bold; vertical-align:middle" target="_blank">Volver al OPC+</a></td>
        </tr>
      </table>
</div>
    <div style="padding-left:25px;" >Bienvenido <strong><?=$_SESSION["usuario"]?></strong> | <a href="cerrarSesion.php" style="text-decoration:none; color:#005395; font-weight:bold">cerrar sesi&oacute;n [x]</a>
    <br />
    <br />
     Haga click en el conferencista para editar los datos de su participaci&oacute;n.<br /><br />
     Existen <?=$cantidad0;?> conferencistas registrados.&nbsp;&nbsp;&nbsp;&nbsp;<br />
<br />
<?
 
echo "<table style='width:100%'><tr ><td align='center'><div align=center style='border:2px; border-color:#CC3300; border-style:solid; width:80%'>";
foreach( range( 'A', 'Z' ) as $letra ) {          
	echo "<a href=\"listado.php?letra=$letra\" style='text-decoration:none; color:#CC3300'><strong>$letra</strong></a> | ";
}
echo "<a href=\"listado.php\" style='text-decoration:none; color:#CC3300'><strong>TODOS</strong></a>";
echo "</div></td></tr>";
echo "</table>" ; 
?>
<br />
Se han encontrado <strong><?=$cantidad;?></strong> coincidencias.
</div>
<div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="form1">
	<table width="500" border="0" cellspacing="2" cellpadding="1" align="center">
  <tr>
    <td colspan="4">Palabra clave&nbsp;&nbsp;<input type="text" name="palabra_clave" style="width:70%" value="<?=$palabra_clave?>" /></td>
    </tr>
  <tr>
    <td height="25" valign="bottom">Confirmado</td>
    <td valign="bottom"><input type="radio" name="confirma_viene" value="1" <?=($confirma_viene==1?"checked":"")?> /> Si &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="confirma_viene" value="0" <?=($confirma_viene=="0"?"checked":"")?> /> 
    No</td>
    <td valign="bottom">&nbsp;</td>
    <td valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="bottom">&Aacute;rea</td>
    <td valign="bottom">Categor&iacute;a Ana</td>
    <td valign="bottom">Roles</td>
    <td valign="bottom">Financiado por</td>
  </tr>
  <tr>
    <td height="116">
    <?
	if($area_actividad==""){
		$area_actividad = array();
	}
	if($categoria_ana==""){
		$categoria_ana = array();
	}
	if($roles==""){
		$roles = array();
	}
	if($financiado_por==""){
		$financiado_por = array();
	}
	?>
    <select name="area_actividad[]" size="6" multiple="multiple" style="width:140px;">
      <option value="">Seleccione</option>
      <option value="vacios" <? if(in_array("vacios",$area_actividad)){echo "selected";} ?>></option>
      <?php
	  	
				$queryArea = $base->areasActividad();
				while($row = $queryArea->fetch_object()){
					foreach($area_actividad as $verf){
						if($row->id==$verf){
							$chkArea = "selected";
						}
					}
					echo "<option value='$row->id' $chkArea>".$base->getAreasActividad($row->id)."</option>";
					$chkArea = "";
				}
			?>
      <option value='7' <? if(in_array("7",$area_actividad)){echo "selected";} ?>>Protocolar</option>
      <option value='8' <? if(in_array("8",$area_actividad)){echo "selected";} ?>>Varias &aacute;reas</option>
      <option value='9' <? if(in_array("9",$area_actividad)){echo "selected";} ?>>Congreso</option>
    </select></td>
    <td><select name="categoria_ana[]" size="6" multiple="multiple" style="width:140px">
      <option value='' <? if (in_array("",$categoria_ana)){echo "selected"; }?>>Seleccione</option>
      <option value="vacios" <? if(in_array("vacios",$categoria_ana)){echo "selected";} ?>></option>
      <option value='Cte.Acad. Inte' <? if (in_array("Cte.Acad. Inte",$categoria_ana)){echo "selected"; }?>>Ct&eacute;.Acad. Inter</option>
      <option value='Cte.Acad. Nac' <? if (in_array("Cte.Acad. Nac",$categoria_ana)){echo "selected"; }?>>Ct&eacute;.Acad. Nac</option>
      <option value='VIP' <? if (in_array("VIP",$categoria_ana)){echo "selected"; }?>>VIP</option>
      <option value='VIP-VIP' <? if (in_array("VIP-VIP",$categoria_ana)){echo "selected"; }?>>VIP-VIP</option>
      <option value='No viene' <? if (in_array("No viene",$categoria_ana)){echo "selected"; }?>>No viene</option>
    </select></td>
    <td><select name="roles[]" size="6" multiple="multiple" style="width:140px">
   		<option value=''>Seleccione</option>
        <option value="vacios" <? if(in_array("vacios",$roles)){echo "selected";} ?>></option>
      		<?
				$queryRol = $base->getRoles();
				while($row = $queryRol->fetch_object()){
					foreach($roles as $rol){
						if($rol==$row->En_calidad){
							$chkR = "selected";
						}
					}
					echo "<option value='$row->En_calidad' $chkR>$row->En_calidad</option>";
					$chkR = "";
				}
            ?>
    </select></td>
    <td><select name="financiado_por[]" size="6" multiple="multiple" style="width:140px;">
      <option value="">Seleccione</option>
      <option value="vacios" <? if(in_array("vacios",$financiado_por)){echo "selected";} ?>></option>
      <option value='Comite' <? if(in_array("Comite",$financiado_por)){echo "selected";} ?>>Comit&eacute;</option>
      <option value='Individual' <? if(in_array("Individual",$financiado_por)){echo "selected";} ?>>Individual</option>
      <option value='Sponsor' <? if(in_array("Sponsor",$financiado_por)){echo "selected";} ?>>Sponsor</option>
    </select></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td  align="center">&nbsp;</td>
    <td  align="center">&nbsp;</td>
    <td  align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="48" colspan="4" align="center"><input type="button" onclick="limpiar()" value="Limpiar" style="width:100px;" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Filtrar" style="width:100px;" /></td>
    </tr>
    </table>
</form>
</div>
<div style="text-align:right; padding-right:25px;"></div>
    <br />
    <center>
    <? if($cantidad==0){
	echo "No se han encontrado coincidencias.<br />
<br />
";
	}else{?>
<form action="envio/index.php" name="conf" method="post">
      <table width="1093" border="0" cellpadding="3" cellspacing="1" style="font-size:14px; text-align:center" align="center">
        <tr style="color:#000000">
          <td colspan="10" align="right" bgcolor="#FFFFFF" style="font-size:12px"><a href="#" class="envio_mail">Enviar mail a conferencistas seleccionados</a></td>
          </tr>
        <tr style="color:#FFFFFF">
          <td width="9" bgcolor="#005395"><input type="checkbox" class="selectAll"/></td>
          <td width="96" bgcolor="#005395"><strong><a href="?orden=ID_Personas<?=($_GET["orden"]=="ID_Personas")?".DESC":""?>" style="color:white; text-decoration:none">ID</a></strong></td>
          <td width="96" bgcolor="#005395"><strong><a href="?orden=nombre<?=($_GET["orden"]=="nombre")?".DESC":""?>" style="color:white; text-decoration:none">Nombre</a></strong></td>
          <td width="100" bgcolor="#005395"><strong><a href="?orden=apellido<?=($_GET["orden"]=="apellido")?".DESC":""?>" style="color:white; text-decoration:none">Apellido</a></strong></td>
         <td width="107" bgcolor="#005395"><strong>N&deg; actividades</strong></td>
         <td width="124" bgcolor="#005395"><strong>Rol</strong></td>
          <td width="124" bgcolor="#005395"><strong>Confirmados</strong></td>
          <td width="122" bgcolor="#005395"><strong>Email</strong></td>
          <td width="122" bgcolor="#005395"><strong><a href="?orden=actividad_categoriaAna<?=($_GET["orden"]=="actividad_categoriaAna")?".DESC":""?>" style="color:white; text-decoration:none">Categor&iacute;a Ana</a></strong></td>  
          <td width="122" bgcolor="#005395"><strong><a href="?orden=actividad_areas<?=($_GET["orden"]=="actividad_areas")?".DESC":""?>" style="color:white; text-decoration:none">&Aacute;rea</a></strong></td>        
        </tr>

    <? while($row = $rs->fetch_array()){
	$sql2 = "SELECT * FROM congreso WHERE ID_persona = '".$row["ID_Personas"]."' GROUP BY Dia_orden, Hora_inicio, Titulo_de_actividad;";
	$rs2 = $con->query($sql2);
	$row2 = $rs2->num_row;
	if($row2==0){
		$bgcolor='bgcolor="#C5D1E0"';
	}else{
		$bgcolor='bgcolor="#C5D1E0"';
	}
	$sql3 = "SELECT  * FROM actividades WHERE idPersonaNueva = '".$row["ID_Personas"]."' ;";
	$rs3 = $con->query($sql3);
	$confirmadoTabla = array();
	$ubicadosTabla = array();
	while ($row3 = $rs3->fetch_array()){
		array_push($confirmadoTabla, $row3["confirmado"]);
		array_push($ubicadosTabla, $row3["ubicado"]);
	}
	
	$RemitID = base64_encode($row["ID_Personas"]);
	
	$sqlCongreso = "SELECT En_calidad,ID_persona FROM congreso WHERE ID_persona='".$row["ID_Personas"]."' AND En_calidad<>'' AND seExpande<=1";
	//echo $sqlCongreso;
	$queryCongreso = $con->query($sqlCongreso);
	
	while($rowC = $queryCongreso->fetch_object()){
		$en_calidad[] = $rowC->En_calidad;
	}
?>	
	
	<tr <?=$bgcolor?> style="cursor:pointer">
          <td><input type="checkbox" name="personas[]" class="personas" value="<?=base64_decode($RemitID)?>" /></td>
		  <td valign="top"  onclick="iraweb('<?=$RemitID?>')"><?=base64_decode($RemitID)?></td>
          <td valign="top"  onclick="iraweb('<?=$RemitID?>')"><?=$row["nombre"]?></td>
		 <td valign="top"  onclick="iraweb('<?=$RemitID?>')"><?=$row["apellido"]?></td>
		  <td valign="top"  onclick="iraweb('<?=$RemitID?>')"><?=$row2?></td>
		  <td valign="top"  onclick="iraweb('<?=$RemitID?>')"><?=((count($en_calidad)>0)?implode(", ",$en_calidad):"")?></td>
		  <td valign="top"  onclick="iraweb('<?=$RemitID?>')"><?
		  unset($en_calidad);

		  foreach($confirmadoTabla as $i){
		  if($i == 1){
		  	$i = "Si";
			}else{
			$i = "No";
			}
		  echo $i." ";
		  }
?></td>
		  <td valign="top" onclick="iraweb('<?=$RemitID?>')"><?=$row["email"]?></td>
		  <td valign="top" onclick="iraweb('<?=$RemitID?>')"><?=$row["actividad_categoriaAna"]?></td>
          <td valign="top"  onclick="iraweb('<?=$RemitID?>')"><?=$base->getAreasActividad($row["actividad_areas"])?></td>
		  </tr>
<?          
	}
	?>
	</table>
    </form>
    <? }?>
    </center></td>
  </tr>
</table>

</center>
</body>
</html>
<script>
function iraweb(valor){
window.location.href='ingresarActividad.php?idP='+valor;
}
function limpiar(){
	document.form1["palabra_clave"].value = "";
	document.form1["area_actividad[]"].selectedIndex  = 0;
	document.form1["categoria_ana[]"].selectedIndex  = 0;
	document.form1["roles[]"].selectedIndex  = 0;
	document.form1["financiado_por[]"].selectedIndex  = 0;
	document.form1["confirma_viene"][0].checked  = false;
	document.form1["confirma_viene"][1].checked  = false;
}
</script>
<? 
}
?>