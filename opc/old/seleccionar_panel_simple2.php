<?
include ('inc/sesion.inc.php');
include('conexion.php');


$sql = "SELECT nombre_congreso, mail_contacto FROM config LIMIT 1";
$rs = mysql_query($sql, $con);
while($row=mysql_fetch_array($rs)){
	$congreso = $row["nombre_congreso"];

}




?>

<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-style: normal; font-weight: bold; text-decoration: none; color:#6600CC; font-family: Arial, Helvetica, sans-serif;}
.Estilo2 {font-size: 12px; font-style: normal; font-weight: bold; text-decoration: none; font-family: Arial, Helvetica, sans-serif;}
.Estilo3 {font-weight: bold; text-decoration: none; font-family: Arial, Helvetica, sans-serif; font-style: normal;}
-->
</style>
<script>


function dire(cual){
	document.location.href = cual;
}
function buscaTL(que){
	document.location.href = "estadoTL.php?estado=cualquier&ubicado=&area=&tipo=&clave=" + que;
}

</script>
<link href="estiloBordes.css" rel="stylesheet" type="text/css">
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<span class="menu_sel"><b>

</b></span><br><center><h2 style="color:#FFFFFF; font-family:Georgia, 'Times New Roman', Times, serif"> <?=$congreso?> </h2></center><br>

<table width="770" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <? /*<tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr> */?>
  <tr>
    <td valign="top" bgcolor="#CCCCCC"><div align="center">
	<?
		if($_SESSION["tipoUsu"]==1 || $_SESSION["tipoUsu"]==4){
		?>
	<?
	  }
	  ?>
    <br>
<div id="BordeMenu">
	<div id="DivOtro">
		<div id="divContenidoPanel">
			<ul>			
				<li><a href="todosencongreso.php">Ingresar / Modificar: Coord., Conf., Panelistas</a></li>
				<li><a href="todosencongreso.php">Ingresar / Modificar: Trabajos</a></li>				
				<li><a href="todoslostrabajos.php">Esquema: Días, Salas, Horas</a></li>
			</ul>
		 </div>
	  </div>
	   <div id="DivBuscar">
  	<div id="divContenidoPanel">	
		<form name="form2" method="post" action="buscar.php">
		<table width="305" border="0" align="center" cellpadding="1" cellspacing="1">
				<tr>
				  <td width="146"><label>
				    <input type="text" name="buscar_">
				  </label></td>
				  <td width="145" > <input name="Submit" type="submit" class="botones" value="Buscar en Congreso" style="width:100%"></td>
			    </tr>
				<tr>
				  <td><input type="text" name="txtBuscaCongreso"></td>
				  <td> <input name="Submit" type="button" class="botones" value="Buscar en Trabajos" onClick="buscaTL(txtBuscaCongreso.value)" style="width:100%"></td>
			    </tr>
			  </table>
		    </form>
			<br>
			<ul>			
				<li><a href="">Búsqueda Avanzada en Congreso</a></li>
				<li><a href="estadoTL.php?estado=cualquier&vacio=true">Búsqueda Avanzada de Trabajos</a></li>				
			</ul>
  	</div>
  </div>
  <div id="DiVExcel">
	  <div id="divContenidoPanel"><br><br><br><br>
	 	<ul>
			<li><a href="todoslostrabajos.php">Listado Trabajos</a></li>
			<li><a href="todoslosautores.php">Listado Autores</a></li>
			<li><a href="todosencongreso.php">Listado de Todo el Congreso</a></li>
		</ul>
	 </div>
  </div>
  <div id="DivMail">
 	 <div id="divContenidoPanel">
	 	<ul>
			<li><a href="envioMail_trabajosLibres_send.php">Envío masivo a Contáctos de Trabajos</a></li>
			<li><a href="envioMail_Autores_trabajosLibres.php">Envío masivo a Autores de Trabajos</a></li>
			<li><a href="envioMail_listadoParticipantes.php">Envío masivo a Conferencistas/Coordinares</a></li>
		</ul>
	 </div>
  </div>
</div>
  
   

	<p><font color="#666666" size="2">SistemaCongresos v.3.12</font><br>
      <font color="#000000" size="1">por <img src="img/gega.png" alt="GEGA" width="30" height="69" align="absmiddle" longdesc="GEGA | editorial | web | multimedia">GEGA s.r.l.</font><br>
          <br>
      </p>
    </div>    </td>
  </tr>
</table>


