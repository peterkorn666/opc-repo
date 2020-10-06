
<?
///Alta O M odificacion
include('inc/sesion.inc.php');

if(isset($_POST['btnEnviar'])) {
$id = $var;

$usuario_ = $_POST["txtNombre"];
$clave = $_POST["txtPassword"];
$tipoUsuario = $_POST["tipoUsuario"];
$AreaTL = $_POST["cbAreaTL"];

if($tipoUsuario != '2')
{
$AreaTL = '';
}

if($usuario_ !='' && $clave !=''){
if($id=='')	{

		$sql= "INSERT INTO claves(usuario, clave, tipoUsuario, AreaUsuTL)VALUES('$usuario_', '$clave', $tipoUsuario, '$AreaTL' )";
		mysql_query($sql, $con);
	}
else{
		$sql= "UPDATE claves SET usuario = '$usuario_', clave = '$clave', tipoUsuario = $tipoUsuario, AreaUsuTL = '$AreaTL'  WHERE ID_clave = $id";
		mysql_query($sql, $con);
	}
	/*echo "<font color='WHITE'>". $sql ."</font>";*/
  }
}
////

////LLENAR DATOS
$var = $_GET['id'];

if($var!='')
{
	
		$sql2 = "SELECT * FROM claves WHERE ID_clave = $var";
		$rs2 = mysql_query($sql2,$con);
		while ($row2 = mysql_fetch_array($rs2))
		{
		$usuario2 = $row2["usuario"];
		$password =  $row2["clave"];
		$tipoUsuario = $row2["tipoUsuario"];
		$AreaTL = $row2["AreaUsuTL"];
		
		/*echo "<font color='WHITE'>".$usuario2. " " . $password . " " . $tipoUsuario . " " . $AreaTL . "</font>";*/

	}
}

//////


////Eliminar Datos
$id_elim = $_GET['id_cual'];
if($id_elim!=''){
$sql = "DELETE FROM claves WHERE id_clave = " . $id_elim;
mysql_query($sql, $con);
}
/////
$usuarioGega="gega";

$sql1 = "SELECT DISTINCT ID_clave FROM claves ";
$num_result = mysql_query($sql1, $con);
$cant_total = mysql_num_rows($num_result); 

?>
<script language="javascript">
  
	 function Validar_clave(){
	  if(form2.txtNombre.value==""){
		alert("Por Favor, Ingrese un Nombre de Usuario.");
		form2.txtNombre.focus();
		return;
		}
	    if (form2.txtPassword.value==""){
		alert("Por Favor, Ingrese un Password de Usuario.");
		form2.txtPassword.focus();
		return;
		}
		
	  form2.submit();
	  }

	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar este usuario?");
		
		 if ( return_value == true ) {
			 document.location.href = "config.php?id_cual=" + cual;
		 }
		 
	 }
	 
	 function ver_area_TL()
	 { 
	 if (form2.tipoUsuario.value=='2')
		 {	
		//  document.getElementById("areaTL").style.display="inline";	
		 }
	  else{
		//  document.getElementById("areaTL").style.display="none";
		  //form2.cbAreaTL.value=""
		 }
	 }
	 
</script>
<style type="text/css">
<!--
.Estilo7 {	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<link href="estilos.css" rel="stylesheet" type="text/css" />

<?
$sql = "SELECT tipoUsuario FROM claves WHERE  usuario = '" . $_SESSION["usuario"] . "' LIMIT 1";
$rs = mysql_query($sql,$con);
while ($row = mysql_fetch_array($rs)){
		$tipo = $row["tipoUsuario"];
}

if($tipo == 1){



?>

<form action="config.php" method="post" name="form2" id="form2" style="display:inline;">
  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#000000" bgcolor="#CCCCCC">
    <tr>
      <td height="69" bordercolor="#000000"><table width="100%" border="0" cellpadding="4" cellspacing="2" bordercolor="#333333">
          <tr>
              <td colspan="3"><strong><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">Administrar Usuarios (solo administradores) </font></strong></td>
          </tr>
            <tr bordercolor="#333333">
              <td width="74" bgcolor="#EEF0F3"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">Nombre: </font></td>
              <td width="102" bgcolor="#EEF0F3"><strong><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">
                <input name="txtNombre" type="text"  value="<?=$usuario2?>" size="15"/>
              </font></strong></td>
              <td width="860" bgcolor="#666666"><span class="Estilo7"><font size="2" face="Arial, Helvetica, sans-serif">Usuarios (
                      <?=$cant_total;?>
                ):</font></span></td>
            </tr>
            <tr>
              <td width="74" height="30" bgcolor="#EEF0F3"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">Contrase&ntilde;a: </font></td>
              <td width="102" bgcolor="#EEF0F3"><strong><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">
                <input name="txtPassword" type="text" value="<?=$password?>" size="15"/>
              </font></strong></td>
              <td rowspan="4" valign="top" bgcolor="#FFFFCC"><font size="2" face="Arial, Helvetica, sans-serif">
                <? 
	
		
	$sql = "SELECT * FROM claves ORDER by id_clave ASC";
	$rs = mysql_query($sql,$con);
	while ($row = mysql_fetch_array($rs))
{

	if ($row["usuario"] != $usuarioGega){
	echo  "<a href='config.php?id=" . $row["ID_clave"]  . "'><img src='img/modificar.png' border='0' alt='Modificar este Usuario'></a>";
	echo  "<a href='javascript:eliminar(" . $row["ID_clave"] . ")'><img src='img/eliminar.png' border='0'  alt='Eliminar este Usuario'></a> ";
	echo $row["usuario"] . "<br>";
	}
	else{

	echo  "<img src='img/modificar_gris.jpg' border='0' alt='Modificar este Usuario'>";
	echo  "<img src='img/eliminar_gris.jpg' border='0'  alt='Eliminar este Usuario'> ";
	echo $row["usuario"] . "<br>";
	}
}	


	  ?>
              </font> </td>
            </tr>
            <tr>
              <td width="74" bgcolor="#EEF0F3"><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">Tipo de <br />
              Usuario :</font> </td>
              <td width="102" bgcolor="#EEF0F3"><select style="width:120;" name="tipoUsuario" onblur="ver_area_TL()" onchange="ver_area_TL()">
                <option <? if($tipoUsuario=='0'){echo 'selected';}?>  value="0">Usuario</option>
                <option <? if($tipoUsuario=='2'){echo 'selected';}?> value="2">Usuario-TL</option>
                <option <? if($tipoUsuario=='1'){echo 'selected';}?> value="1">Administrador</option>
              </select></td>
            </tr>
			</table>
			
			
        <div id="areaTL" style="width:100; display:none;">
          <table width="213" border="0" cellpadding="4" cellspacing="2" bordercolor="#333333">
			<tr>
              <td width="70" bgcolor="#EEF0F3"><label><font color="#333333" size="2" face="Arial, Helvetica, sans-serif">&Aacute;rea TL:</font></label></td>
              <td width="122"  bgcolor="#EEF0F3"><select name="cbAreaTL" style="width:120px"  >
                <option></option>
                <?  
					
				$sql = "SELECT * FROM areas ORDER by Area ASC";
				$rs = mysql_query($sql,$con);
				while($row = mysql_fetch_array($rs)){
				
					if ($AreaTL == $row["ID_Areas"])
					{
						$areaSel = "selected";
					}
					else
					{
						$areaSel = "";
					}
				?>
                <option value="<?=$row["ID_Areas"];?>" <?=$areaSel?>><? echo $row["Area"]; ?></option>
                <?
				}
				?>
              </select></td>
             
            </tr>
		  </table> 
	    </div>
        <table width="176" border="0" align="center" cellpadding="4" cellspacing="2" bordercolor="#333333">
			
			<tr>
              <td width="202" colspan="2" bgcolor="#DBDEE6"><div align="center">
                  <input name="var" type="hidden" value="<?=$var?>"/>
                  <input name="btnEnviar" type="submit" class="botones" style="width:100%"  onclick="Validar_clave()" value="Enviar"/>
			  </div></td>
            </tr>
        </table></td>
    </tr>
  </table>
  
  
</form>
<? 
if ($AreaTL <>'') 
		{
		?>		
		<script language="javascript">
		document.getElementById("areaTL").style.display = 'inline';
		</script>
		<? }
}?>

