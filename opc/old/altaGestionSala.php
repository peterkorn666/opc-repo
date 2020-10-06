<?
include('inc/sesion.inc.php');
include('conexion.php');
require("clases/GestionSalas.php");
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>
<script src="js/paises.js"></script>
<script src="js/salas.js"></script>
<script src="js/rubros.js"></script>
<script src="js/staff.js"></script>
<script src="js/horas.js"></script>
<script src="js/GestionSalas.js"></script>


<?

$_SESSION["ArraySalas"] = array ();
$_SESSION["ArrayDias"] = array ();

$cargarArray = new GestionSalas();
$cargarArray->salas();
$cargarArray->rubros();
$cargarArray->staff();
$cargarArray->horas();
$cargarArray->dias();

$url = "altaGestionSalaEnviar.php";
$titulo = "Guardar";

if($_GET["id"]!=""){
	$url = "gestionGestionSala.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	$sql = "SELECT * FROM gestion_sala WHERE id_gestion_sala = " . $_GET["id"] . ";";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$idViejo = $_GET["id"];
		$id_sala_trae = $row["id_sala"];
		$id_dia_trae = $row["id_dia"];
		$sala = $row["sala"];
		$rubro = $row["rubro"];
		$staff = $row["staff"];
		$hora_inicio = $row["hora_inicio"];
		$hora_fin = $row["hora_fin"];
		$descripcion = $row["descripcion"];
	}
}

if($_POST["filtro_dia"]<>""){$dia = $_POST["filtro_dia"];}else{$dia = "(Todos)";};
if($_POST["filtro_sala"]<>""){$sala = $_POST["filtro_sala"];}else{$sala = "(Todas)";};
if($_POST["filtro_staff"]<>""){$staff2 = $_POST["filtro_staff"];}else{$staff2 = "(Todas)";};
?>

<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="830"  border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#ECF4F9">
  <tr>
    	<td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
    	<td  valign="top" style="color: #666666">
        	<div align="center">
            <br>
    		<strong>GESTIÓN DE TAREAS</strong>
            <br>
            <br>
            <form name="form_filtro" action="altaGestionSala.php" method="post">
              <table width="100%" border="0" cellpadding="10" cellspacing="0" style="border:1px #333 solid;" >
              <tr class="tituloTL"  style='border:1px solid #009900' ></tr>
              <tr class="tituloTL"  style='border:1px solid #009900' >
                <td width="32%" align="center" valign="top" bgcolor="#FFFFFF"><div style="float:left; "> D&iacute;a
                  <select name="filtro_dia" class="camposTL" id="filtro_dia" style="width:150px;" onChange="filtrar();">
                  </select>
                  &nbsp;</div>
                  <div id="divDia" style="float:left; ">&nbsp;</div></td>
                <td width="32%" align="center" valign="top" bgcolor="#FFFFFF"><div style="float:left; "> Sala
                  <select name="filtro_sala" class="camposTL" id="filtro_sala" style="width:150px" onChange="filtrar();" >
                  </select>
                  &nbsp;</div>
                  <div id="divSala" style="float:left; ">&nbsp;</div></td>
                <td width="36%" align="center" valign="top" bgcolor="#FFFFFF"><div style="float:left; ">Empresa
                  <select name="filtro_staff" class="camposTL" id="filtro_staff" style="width:150px" onChange="filtrar();" >
                  </select>
                  &nbsp;</div>
                  <div id="divEmp" style="float:left; "><a href="impresionGestionSala.php?staff=<?=base64_encode($staff2)?>" target="_blank"><img border="0" src="img/ico_imprimir.png" width="32" height="32"></a></div></td>
              </tr>
              </table>
            </form>       
<table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
<tr valign="top">
	<td width="50%" valign="top" bgcolor="#FFFFFF">
<form name="form1" method="post" action="<?=$url;?>">
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
<tr>
<td valign="top" style="border-bottom:1px #333333 solid"><strong> Dias: </strong></td>
<td valign="top" class="menu_sel"  style="border-bottom:1px #333333 solid" ><?  
                $sql = "SELECT * FROM dias ORDER by Dia_orden  ASC";
                $rs = mysql_query($sql,$con);
                $fila = 0;
                $v = 0;
                $i = 1;
                while ($row = mysql_fetch_array($rs)){
                    
                    $fila = $fila+1;
                    array_push($_SESSION["ArrayDias"], $row["ID_Dias"]);																									
                echo "<input type='checkbox' id='dia".$i."' name='dia".$i."' value='".$row["ID_Dias"]."'/>". $row["Dia"];
                    echo "<br>";
                    if ($fila > 3){
                        if ($v = 0){
                            $v = 1;
                        }
                    }
                    if ($fila > 3){
                        $fila = 0;
                    }
                    $i=$i+1;
                }
             ?></td>
</tr>
<tr>
<td width="23%" valign="top"   style=" border-bottom:1px #333333 solid"><strong> Sala: </strong></td>
<td valign="top" class="menu_sel"  style="border-bottom:1px #333333 solid" ><?  
                $sql = "SELECT * FROM salas ORDER by Sala_orden ASC";
                $rs = mysql_query($sql,$con);
                $fila = 0;
                $v = 0;
                $i = 1;
                while ($row = mysql_fetch_array($rs)){
                    
                    $fila = $fila+1;
                    array_push($_SESSION["ArraySalas"], $row["ID_Salas"]);
                    echo "<input type='checkbox' id='sala".$i."' name='sala".$i."' value='".$row["ID_Salas"]."'/>". $row["Sala"];
                    echo "<br>";
                    if ($fila > 3){
                        if ($v = 0){
                            $v = 1;
                        }
                    }
                    if ($fila > 3){
                        $fila = 0;
                    }
                    $i=$i+1;
                }
             ?></td>
</tr>
<tr>
<td valign="top"><strong> Horario: </strong></td>
<td ><div  id="CasillaHora">
<select name="hora_inicio_" id="hora_inicio_" style="font-size:10px">
</select>
<font style="font-size:10px">a </font>
<select name="hora_fin_" id="hora_fin_" style="font-size:10px">
</select>
<a href="javascript:agregar('altaHora.php', '50')"  class="linkAgregar"> <br>
Agregar horario</a> </div></td>
</tr>
<tr>
<td valign="top" ><strong> Rubro: </strong></td>
<td><select name="rubro" id="rubro" style="width:170px" >
</select></td>
</tr>
<tr>
<td valign="top"><strong> Empresa: </strong></td>
<td><select name="staff" id="staff" style="width:170px" >
</select></td>
</tr>
<tr>
<td valign="top"><strong> Descripci&oacute;n: </strong></td>
<td ><textarea name="descripcion" rows="5" wrap="physical" size="23" id="descripcion" style="width:100%;"></textarea></td>
</tr>
<tr>
<td  align="center" colspan="2" class="crono_trab"><input name="Submit" type="button" class="botones" onClick="ValidarGestion()" value=<?=$titulo?>></td>
</tr>
</table>
</form>
</td>
	<td width="46%" height="34" bgcolor="#FFFFCC" class="lista_persona"><strong>Existentes: </strong><br>
    <?	if($_POST["filtro_dia"]<>"" && $_POST["filtro_dia"] <> "(Todos)"){
    $sql = "SELECT ID_Dias FROM dias Where Dia = '".$_POST["filtro_dia"]."' ";
    $rs = mysql_query($sql,$con);
    while ($row = mysql_fetch_array($rs)){
    $id_filtro_dia = $row["ID_Dias"];
    }
    $filtro .= " AND id_dia like '%".$id_filtro_dia."%'";
    }
    if($_POST["filtro_sala"]<>"" && $_POST["filtro_sala"] <> "(Todas)"){
    $sql = "SELECT ID_Salas FROM salas Where Sala = '".$_POST["filtro_sala"]."' ";
    $rs = mysql_query($sql,$con);
    while ($row = mysql_fetch_array($rs)){
    $id_filtro_sala = $row["ID_Salas"];
    }
    $filtro .= " AND id_sala like '%".$id_filtro_sala."%'";
    }
    if($_POST["filtro_staff"]<>"" && $_POST["filtro_staff"] <> "(Todas)"){
    $filtro .= " AND staff like '%".$_POST["filtro_staff"]."%'";
    }
    
    $sql = "SELECT * FROM gestion_sala WHERE 1=1 ";
    $sql = $sql . $filtro;
    $sql = $sql . " ORDER by id_gestion_sala ";
    
    //$sql = "SELECT * FROM gestion_sala WHERE 1=1 ";
    
    $rs = mysql_query($sql,$con);
    //echo $sql;
    while ($row = mysql_fetch_array($rs)){	
    
    echo  "<a href='altaGestionSala.php?id=".$row["id_gestion_sala"]."'><img src='img/modificar.png' border='0' alt='Modificar este Staff'></a>";
    echo  "<a href='javascript:eliminar_gestion(".$row["id_gestion_sala"].")'><img src='img/eliminar.png' border='0'  alt='Eliminar este Staff'></a> ";	
    echo $row["id_gestion_sala"];
    echo "&nbsp;".$row["staff"];
    echo "&nbsp;/ ".$row["rubro"];
    echo "&nbsp;de ".$row["hora_inicio"];
    echo "&nbsp;a ".$row["hora_fin"];
    echo "<br>";	
    } ?>
    </td>
</tr>
</table>
        <br>       
	</div>
    </td>
  </tr>
</table>

<script>

	llenarDias_combo();
	llenarSalas_combo();
	llenarStaff_combo();
	
    llenarRubros();	
	llenarStaff();
	llenarHoras();
</script>
<br>
<?
if($_GET["id"] != ""){	
	//Cargo los dias (checks) del registro a modificar
	//**********************
	$trozos = explode("-", $id_dia_trae);
	$count = count($trozos);
	for ($i=0; $i < $count; $i++) {
		echo "<script>llenarDias('$trozos[$i]');</script>\n";	
	}
	//*********************
	
	//Cargo las salas (checks) del registro a modificar
	//**********************
	$trozos2 = explode("-", $id_sala_trae);
	$count = count($trozos2);
	for ($i=0; $i < $count; $i++) {
		echo "<script>llenarSalas('$trozos2[$i]');</script>\n";	
	}
	//**********************

	//Cargo el resto de los campos
	//**********************
	echo "<script>document.form1.rubro.value='$rubro';
	document.form1.staff.value='$staff';
	document.form1.hora_inicio_.value='$hora_inicio';
	document.form1.hora_fin_.value='$hora_fin';
	document.form1.descripcion.value='$descripcion';</script>\n";	
}
?>

<? 
echo "<script>document.form_filtro.filtro_dia.value='$dia';
	document.form_filtro.filtro_sala.value='$sala';
	document.form_filtro.filtro_staff.value='$staff2';";
echo 'function mostrar_print(){
	if(document.form_filtro.filtro_dia.value=="(Todos)"){
		document.getElementById("divDia").innerHTML= "";
	}else{
		document.getElementById("divDia").innerHTML= \'<a  href="impresionGestionSala.php?dia='.base64_encode($dia).'" target="_blank"><img border="0" src="img/ico_imprimir.png" alt="" width="32" height="32"></a>\';
	}	
	if(document.form_filtro.filtro_sala.value=="(Todas)"){
		document.getElementById("divSala").innerHTML= "";
	}else{
		document.getElementById("divSala").innerHTML= \'<a  href="impresionGestionSala.php?sala='.base64_encode($sala).'" target="_blank"><img border="0" src="img/ico_imprimir.png" alt="" width="32" height="32"></a>\';
	}
}';
echo "mostrar_print();</script>";	
?>

<div id="divEdicion" style="display:none; position:absolute" ></div>
<iframe name="iframeForm" id="iframeForm" style="display:none;"></iframe>
</body>