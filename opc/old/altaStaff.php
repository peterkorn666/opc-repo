<?
include('inc/sesion.inc.php');
include('conexion.php');
?>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>
<?
$url = "altaStaffEnviar.php";
$titulo = "Alta";

if($_GET["id"]!=""){
	$url = "gestionStaff.php?modificar=true&id=" .$_GET["id"];
	$titulo = "Modificar";
  	$sql = "SELECT * FROM staff WHERE Id_staff = " . $_GET["id"] . " limit 1;";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs)){
		$idViejo = $_GET["id"];
		$staff_nombre = $row["nombre"];
		$staff_descripcion = $row["descripcion"];
		$staff_telefono = $row["telefono"];
		$staff_email = $row["email"];
		$staff_contacto = $row["contacto"];
	}
	
	//vaciar los arrays
	unset($nombre_persona_staff); 
	unset($apellido_persona_staff); 
	unset($telefono_persona_staff); 
	unset($email_persona_staff); 
	unset($pais_persona_staff); 
	unset($cargo_persona_staff); 
	unset($id_persona_staff); 
	
	//definirlos
	$nombre_persona_staff=array();
	$apellido_persona_staff=array();
	$telefono_persona_staff=array();
	$email_persona_staff=array();
	$pais_persona_staff=array();
	$cargo_persona_staff=array();
	$id_persona_staff=array();

	//llenar
	$sql = "SELECT * FROM personas_staff WHERE Id_staff = " . $_GET["id"] . " Order by id_persona;";
	$rs = mysql_query($sql,$con);
	$numero_personas=mysql_num_rows($rs);
	while ($row = mysql_fetch_array($rs)){
		array_push($nombre_persona_staff, $row["nombre"]);
		array_push($apellido_persona_staff, $row["apellido"]);
		array_push($telefono_persona_staff, $row["telefono"]);
		array_push($email_persona_staff, $row["email"]);
		array_push($pais_persona_staff, $row["pais"]);
		array_push($cargo_persona_staff, $row["cargo"]);
		array_push($id_persona_staff, $row["id_persona"]);
	}
	
}
?>
<script src="js/staff.js"></script>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<? if ($_GET["sola"]!=1){?>
<table width="770"  border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#ECF4F9">
  <tr>
    <td height="10" valign="top" bgcolor="#666666">
		<? include "menu.php";?>
    </td>
  </tr>
  <tr>
    <td  valign="top">
    	<div align="center">
        <br>
        <strong><font color="#666666"><?=$titulo;?> Staff</font></strong>
        <br>
 		<br>
        <table width="100%" border="1" cellpadding="5" cellspacing="2" bordercolor="#CCCCCC">
        	<tr valign="top">
            	<td width="50%" rowspan="2" valign="top">
			  <? }?>
			    	<form name="form1" method="post" action="<?=$url;?>">
	      				<table width="100%" border="0" cellpadding="5" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif">
                        <tr>
                            <td  colspan="2" height="10"  class="crono_trab">
                                    Antes de agregar un nuevo staff compruebe que no exista en la lista 	
                            </td>
	                    </tr>
                        <tr>
                            <td width="42%"  >
                            	Nombre:
                            </td>
                            <td width="58%"> 
                                <input name="nombre_"  type="text" id="nombre_" size="23">
                            </td>
                         </tr>
                         <tr>
                            <td>
                            	Descripci&oacute;n:
                            </td>
                            <td> 
                                <input name="descripcion_" type="text" id="descripcion_" size="23">
                            </td>
                         </tr>
			             <tr>
                            <td>
                            	Tel:
                            </td>
                            <td > 
                                <input name="tel_" type="text" id="tel_" size="23">
                            </td>
                         </tr>
                         <tr>
                            <td>
                            	Email:
                            </td>
                            <td > 
                                <input name="email_" type="text" id="email_" size="23">
                            </td>
                         </tr>
			             <tr>
                            <td>
                            	Persona Contacto:
                            </td>
                            <td > 
                                <input name="contacto_" type="text" id="contacto_" size="23">
                            </td>
                         </tr>
				         <tr>
                            <td  colspan="2" class="crono_trab">
                               <input name="Submit" type="button" class="botones" onClick="Validar()" value="<?=$titulo;?> Staff">
                            </td>
                         </tr>
				</table>			
			    </form>				
	<? if ($_GET["sola"]!=1){?>
			  </td>
              <td width="50%" height="10" bordercolor="#999999" bgcolor="#666666"><font color="#FFFFFF" size="2">
              	<strong>Staff Existentes: </strong></font>
              </td>
            </tr>
            <tr valign="top">
              <td width="50%" bordercolor="#999999" bgcolor="#FFFFCC">
                <?
					$sql = "SELECT * FROM staff ORDER by nombre ASC";
					$rs = mysql_query($sql,$con);
					while ($row = mysql_fetch_array($rs)){	
						echo  "<a href='altaStaff.php?id=" . $row["id_staff"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este Staff'></a>";
						echo  "<a href='javascript:eliminar(" .  $row["id_staff"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este Staff'></a> ";	
						echo $row["id_staff"] . " - " . $row["nombre"];
						echo  "&nbsp;<a href='javascript:agregarPersona_staff(\"".$row["id_staff"]."\")'><img src='img/prueba_persona.png' border='0'  alt='Agregar personas al Staff'></a> ";
						echo "<br>";	
					} 
			 ?>
			   </td>
            </tr>
          </table>
        <br>       
        </div>
    </td>
  </tr>
</table>

<? if($_GET["id"] != ""){ ?>
    <table width="770"  border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#ECF4F9" style="font-size:12px">
    	<tr style=" background-color:#006AB0;font-family:Tahoma, Geneva, sans-serif; color:#FFF; font-size:14px"> 
        	<td colspan="4">
            	<strong>Personas del staff <?=$staff_nombre?></strong>
            </td>
        </tr> 
        <? if($numero_personas==0){
				echo "<tr><td align='center'>No existen personas registradas</td></tr>";
			}else{
				 for ($i=0;$i<$numero_personas;$i++){ 
                 echo "<tr style='border-bottom:'1''><td height='43'>&nbsp;&nbsp;<img src='img/personas2.png' border='0'></td>
				 	   <td align='left' style='font-size:14px'>&nbsp;<strong>".$nombre_persona_staff[$i]." ". $apellido_persona_staff[$i]."</strong></td>
					   <td>&nbsp;".$email_persona_staff[$i]." / ".$telefono_persona_staff[$i]." / ".$pais_persona_staff[$i]." / <strong>Cargo:</strong>".$cargo_persona_staff[$i]."&nbsp;&nbsp;</td>";
				 
					//boton eliminar
                 echo "<td align='left'>&nbsp;<a href='javascript:eliminar_persona(".$id_persona_staff[$i].",".$_GET["id"].")'><img src='img/eliminar.png' border='0'  alt='Eliminar esta Persona'></a>";
					//boton modificar
				 echo "&nbsp;<a href='javascript:editarPersona_staff(\"".$_GET["id"]."\",\"".$id_persona_staff[$i]."\",\"".$nombre_persona_staff[$i]."\",\"".$apellido_persona_staff[$i]."\",\"".$telefono_persona_staff[$i]."\",\"".$email_persona_staff[$i]."\",\"".$pais_persona_staff[$i]."\",\"".$cargo_persona_staff[$i]."\")'><img src='img/modificar.png' border='0' alt='Modificar esta Persona'></a></td></tr>";
                 
//                echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefono: ".$telefono_persona_staff[$i]."</td></tr>";
//                echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email: ".$email_persona_staff[$i]."</td></tr>";
//                echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pa&iacute;s: ".$pais_persona_staff[$i]."</td></tr>";
//                echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cargo: ".$cargo_persona_staff[$i]."</td></tr>";
//				  echo "<tr height='2px'style='background-color:#006AB0'><td>&nbsp;</td></tr> ";
                 } 
			}
	    ?>

    </table>
<? } ?>


<br>
<? }	
if($_GET["id"] != ""){	
	echo "<script>document.form1.nombre_.value='$staff_nombre';
	document.form1.descripcion_.value='$staff_descripcion';
	document.form1.tel_.value='$staff_telefono';
	document.form1.email_.value='$staff_email';
	document.form1.contacto_.value='$staff_contacto';</script>\n";	
}
///////LLENO LOS ARRAYS
	$sql = "SELECT * FROM staff ORDER by nombre ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
{
	/*LLENO ARRAY PARA VER QUE NO EXISTA*/
	if($row["nombre"]!=$staff_nombre)
	{
	echo "<script>arrayStaffNuevo.push('" . $row["nombre"] ."')</script>\n";
	/*echo "<script>arraySalaObsNuevo.push('" . $row["Sala_obs"] ."')</script>\n";*/
	}
}
?>
<div id="divEdicion" style="display:none; position:absolute" ></div>
<iframe name="iframeForm" id="iframeForm" style="display:none;"></iframe>
<script>form1.nombre_.focus();</script>
</body>