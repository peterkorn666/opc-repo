<?
include('inc/sesion.inc.php');

if($_POST["por"] != ""){
	$_SESSION["ordenarPor"] = $_POST["por"];
}else{
	$_SESSION["ordenarPor"] = "identificador";
}

if($_POST["pos"] != ""){
	$_SESSION["ordenarPos"] = $_POST["pos"];
}else{
	$_SESSION["ordenarPos"] = "DESC";
}

include "conexion.php";
require "clases/inscripciones.php";
$inscripcion = new inscripciones;
?>

<link href="estilos.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.borddeAbajo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #77969F;
}
-->
</style>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top"><p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif"><br>
      Bandeja de entrada. Inscripciones congreso</font></strong></p>
      <form name="form1" method="post" >
        <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td colspan="2" valign="middle" bordercolor="#E0E9ED" class="borddeAbajo"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="24%"><a href="#" onClick="eliminar()"><font size="2">Eliminar los seleccionados</font></a></td>
                <td width="24%"><a href="todoslosinscriptos.php" target="_blank"><font size="2">Listado Excel de inscriptos</font></a></td>
                <td width="52%"><a href="todoslosinscriptosXLS.php"><img src="img/xls_logo.gif" border="0" align="absmiddle"> Descargar listado</a> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="2" valign="middle" bordercolor="#E0E9ED" bgcolor="#EFEFEF" class="borddeAbajo"><font color="#333333">Total de inscriptos:</font><font color="#666666"><font color="#000000"><strong>
              <?=$inscripcion->cantidadinscripto()?>
            </strong> | <font color="#333333">ordenar por:          
            </font>
			<?
			
			 if($_SESSION["ordenarPor"] == "identificador"){
			 	$selPor1 = "selected";
			 }else{
				 $selPor1 = "";
			 }
			
			 if($_SESSION["ordenarPor"] == "nombre"){
			 	$selPor2 = "selected";
			 }else{
				 $selPor2 = "";
			 }
			 
			 if($_SESSION["ordenarPor"] == "apellido"){
			 	$selPor3 = "selected";
			 }else{
				 $selPor3 = "";
			 }
			 
			 
			?>
			
            <select name="por" class="botones" id="por">
              <option value="identificador" <?=$selPor1?>>ID de inscripto</option>
              <option value="nombre" <?=$selPor2?>>Nombre</option>
              <option value="apellido" <?=$selPor3?>>Apellido</option>
            </select>
            </font><font color="#666666"><font color="#000000">
            <select name="pos" class="botones" id="pos">
             
			 <?
			 if($_SESSION["ordenarPos"] == "ASC"){
			 	$selPos = "selected";
			 }else{
				 $selPos = "";
			 }
			if($_SESSION["ordenarPos"] == "DESC"){
			 	$selPosDes = "selected";
			 }else{
				 $selPosDes = "";
			 }
			 
			 ?>
			 
			 <option value="ASC" <?=$selPos?>>Ascendente</option>
              
			  <option value="DESC" <?=$selPosDes?>>Desendente</option>
             
			 </select>
            <input name="Submit" type="button" class="botones" value="ordenar" onClick="ordenar()">
			<script>
			function ordenar(){
				form1.action = "bandejaEntradaInscripciones.php";
				form1.submit();
			}
			
			</script>
            </font></font></font></td>
          </tr>
         <?
		
		
		 $lista = $inscripcion->bandejaEntrada();
		 while ($row = mysql_fetch_object($lista)){
		
			if($row->leido == 0){
				$iniB = "<b>";
				$finB = "</b>";
				$fondo = "#D6F5F8";
			}else{
				$iniB = "";
				$finB = "";
				$fondo = "#E0E9ED";
			} 
			
		
		 ?>
		
		  <tr bgcolor="<?=$fondo?>" onMouseOver="mOvr(this)" onMouseOut="mOut(this, '<?=$fondo?>')">
            <td width="3%" valign="middle" bordercolor="#E0E9ED" class="borddeAbajo"><input name="quien[]" type="checkbox" id="quien[]" value="<?=$row->id?>"></td>
            <td  onClick="mClk(<?=$row->id?>)" width="97%" valign="middle" bordercolor="#E0E9ED"  class="borddeAbajo">ID: <?=$row->identificador?> <font color="#FFFFFF">|</font>			<?
			
			echo $iniB;
			echo $row->tituloAcademico . " " .  $row->nombre . " " . $row->apellido;
			echo $finB;
			?></td>
		  </tr>
		 
		  <?
		  }
		  ?>
		  <tr>
            <td colspan="2" valign="middle" bordercolor="#E0E9ED"><a href="#" onClick="eliminar()"><font size="2">Eliminar los seleccionados</font></a> </td>
	      </tr>
        </table>
      </form>
      <p align="center">&nbsp;</p>
      <p align="center"><strong><font color="#666666" size="3" face="Arial, Helvetica, sans-serif"><br>
    </font></strong></p>    </td>
  </tr>
</table>
<script>

function eliminar(){
		form1.action = "eliminarInscrpto.php";
		form1.submit();
}

function mOvr(cual){
	cual.bgColor= "#ffffff";
}
function mOut(cual,color){
	cual.bgColor= color;
}
function mClk(cual){
	document.location.href = "fichaInscripcion.php?id=" + cual;
	cual.bgColor= color;
}
</script>