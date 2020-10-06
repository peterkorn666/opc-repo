<?
include('inc/sesion.inc.php');
include('conexion.php');

session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache"); 

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
if ($_SESSION["registrado"]==false){
	header ("Location: AUTOR_codigo.php");
}
?>

<link href="estilos.css" rel="stylesheet" type="text/css">
<?

require("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;
$array_IDParticipantes =  Array();

if($_GET["txtClave"]!=""){

$sql1= "SELECT * FROM trabajos_libres WHERE clave = '".$_GET["txtClave"]."' LIMIT 1;";
$rs= mysql_query($sql1, $con);
while($row=mysql_fetch_array($rs)){
	$id_tl = $row["ID"];
}
	$sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $id_tl ." ORDER BY ID ASC;";
    $rs2 = mysql_query($sql2,$con);
	
	while($row2=mysql_fetch_array($rs2)){
		array_push($array_IDParticipantes, $row2["ID_participante"]);
	}
	$cantidadAutores = mysql_num_rows($rs2);
	$titulo = "Modificar";

}else{
/*ESTO NO VA
	$cantidadAutores = 3;
	$titulo = "Alta";
	
	echo "<script>\n";
	echo "form1.chkSinHora.checked = true;\n";
	echo "</script>";
*/
}

echo "<script>\n";
echo "var cantidadAutores=" . $cantidadAutores . "\n";
echo "</script>";
?>
<script>
function ayudaUbicacion(){
alert("La ubicación se interpreta de la siguiente manera:\nDIA / SALA / HORA / TITULO DE SESION");
}
function agregar(cual, medidas, param1){
	window.open(cual + "?sola=1&combo=" + param1,'','width=380,height='+medidas+',toolbar=no,directories=no,status=no,menubar=no,modal=yes');

}

function agregarItem(cual_, txt, valor){
	
	var oOption = document.createElement("OPTION");

	oOption.text = txt;

	oOption.value = valor;

	cual_.options.add(oOption);
}


</script>
<script src="js/horas.js"></script>
<script src="js/areasTL.js"></script>
<script src="js/tipoTL.js"></script>
<script src="js/personasTL.js"></script>
<script src="js/autoresTL.js"></script>
<script src="js/trabajos_libres.js"></script>
<?


$cargarArray = new trabajosLibre();
$cargarArray->arrayAreas();
$cargarArray->arrayTipoTL();
$cargarArray->personas();
$cargarArray->horas();
?>
<style type="text/css">
<!--
.Estilo1 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
	font-size:14px;
	
}

-->
</style>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  >
<table width="700" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CFC2D6">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><center class="Estilo1">AIDIS 2006</center>    </td>
  </tr>
  <tr>
    <td valign="top"><div align="center"><strong><font color="#666666" size="3"><font color="#000000">Trabajo Libre</font></font> - Versi&oacute;n Definitiva </strong></div>
      <form action="altaTrabajosLibresEnviar.php" method="post" enctype="multipart/form-data" name="form1">
        <table width="100%" border="0" cellpadding="0" cellspacing="4">
          <tr>
            <td><font size="2">Estado del  trabajo libre:</font></td>
            <td colspan="2"><font color="#333333" size="2">
              <select name="estado_de_TL" id="select5"  style="width:400;" disabled="disabled" >
			 <option value="0" style="background-color:#FFCACA;">No revisados y registros On-line</option>
			 <option value="1" style="background-color:#79DEFF;">En revisi&oacute;n</option>
			 <option value="2" selected style="background-color:#82E180;">Aprobados</option>
             <option value="3" style="background-color:#999999;">Rechazados</option>
              </select>
            </font><font size="2"><a href="javascript:agregar('altaTipoTL.php', '80')"></a></font></td>
          </tr>
          <tr>
            <td><font size="2">Tipo de trabajo libre:</font></td>
            <td colspan="2"><font color="#333333" size="2">
             
			<select name="tipo_de_TL" id="select5"  style="width:400;" disabled="disabled" ></select>
            </font></td>
		  </tr>
          <tr>
            <td width="20%"><font size="2">Codigo  del trabajo libre:</font></td>
            <td colspan="2"><font color="#333333" size="2">
              <input name="numero_TL" type="text" id="numero_TL"  style="width:100
			  ;"  disabled="disabled" >
            </font></td>
          </tr>
          <tr>
            <td><font size="2">Area del trabajo libre:</font></td>
            <td colspan="2">
          
		   <select name="area_" id="area_" style="width:400;" disabled="disabled"></select>          </td>
          </tr>
          <tr>
            <td><font size="2">Ubicarlo en la actividad: </font></td>
            <td colspan="2"><font color="#333333" size="2">
              <select name="ID_casillero" id="select2"  style="width:400;"  disabled="disabled" >
                <option value=""  style="background-color:#999999; color:#FF0000;" selected>Sin Ubicación</option>
                <?
				    $sql ="SELECT * FROM congreso WHERE Trabajo_libre = 1 ORDER BY Casillero ASC;";
					$rs = mysql_query($sql,$con);
					while ($row = mysql_fetch_array($rs)){

				  ?>
                <option value="<?=$row["Casillero"]?>">
                <?=$row["Dia"]?>
                  /
				    <?=$row["Sala"]?>
                  /
				  <?=substr($row["Hora_inicio"], 0, -3)?>
                  a
 				 <?=substr($row["Hora_fin"], 0, -3)?>
                  /
				  <?=$row["Titulo_de_actividad"]?>
                </option>
                <?
					 }
					 ?>
              </select>
              <font color="#333333" size="2"><font color="#990000"><a href="#" onClick="ayudaUbicacion()"><img src="img/ctxhelp_hide.gif" alt="ayuda" width="16" height="16" border="0" align="absmiddle" longdesc="ayuda"></a></font></font></font></td>
          </tr>
          <tr>
            <td><font size="2">Hora inicio a Hora fin </font></td>
            <td width="40%"><font size="2">
              <select name="hora_inicio_" id="hora_inicio_" disabled="disabled">
			  </select  > a              
 			  <select name="hora_fin_" id="hora_fin_"  disabled="disabled" >
			  </select>
            </font></td>
            <td width="40%"><font size="2">
              <label>
              <input <?
			  if($_GET["txtClave"]==""){
			 
			  echo "checked=\"checked\"";
			  
			  } ?> name="chkSinHora" type="checkbox" onClick="SinHoras()"  disabled="disabled" >
              </label>
              <label > Sin horario</label>
             </font></td>
          </tr>
          <tr>
            <td><font size="2">Mail de contacto :</font></td>
            <td colspan="2"><input name="mailContacto_TL" type="text" id="mailContacto_TL"  style="width:400;"></td>
          </tr>
          <tr>
            <td><font size="2">Titulo del trabajo libre:</font></td>
            <td colspan="2"><input name="titulo_TL" type="text" id="titulo_TL"  style="width:100%;"></td>
          </tr>
          <tr>
            <td height="22" valign="top"><font size="2">Resumen:</font></td>
            <td colspan="2"><?
			if($_GET["txtClave"]!=""){
			$lista = $trabajos->selectTL_ID($id_tl);
			while ($row1 = mysql_fetch_object($lista)){
				$textoResume= $row1->resumen;
				}
			}
			?>
              <textarea name="resumenTL" rows="8" wrap="physical" id="resumenTL"style="width:100%;"><?=$textoResume?></textarea>			</td>
          </tr>
          <tr>
            <td height="22"><font size="2">Palabras Clave :</font></td>
            <td colspan="2"><input name="palabrasClave_TL" type="text" id="palabrasClave_TL"  style="width:400;">
              <font color="#990000" size="1">(Separe las palabras con una coma)</font></td>
          </tr>
        </table>
		
	    <div id="divCoautores">
          <?
				for($i=1;$i<=$cantidadAutores;$i++){
					if ($colorfila == 0){
						$color= "#DDD3E2";
						$colorfila=1;
						echo "<script> var colorfila=1; </script>\n";
						
					}else{
						$color="#D8CCDD";
						$colorfila=0;
						echo "<script> var colorfila = 0; </script>\n";
					}
				?>
          <table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="bordePunteadoAbajo">
            <tr bgcolor="<?=$color?>">
              <td>
			  <table width="750" border="0" cellpadding="2" cellspacing="0">
                  <tr valign="top">
                    <td width="147" height="15" valign="middle">
					<font size="2">
				<font size="1" color="#9900FF">[<?=$i?>]</font> 
				<?
				
				if($soloUnAutor!=1){
					echo "Autor:";
					$soloUnAutor=1;
				}else{
					echo "Co - Autor:";
				}
				?>
					</font>					</td>
                    <td width="509" height="15" valign="bottom"><font size="2">
                      <select name="persona[]" id="persona[]"  style="width:400;" disabled="disabled"></select>
					
                    <a href="javascript:agregar('altaPersonasTL.php?id=<?=$array_IDParticipantes[$i-1]?>&sola=1', '300' , <? echo ($i-1); ?>)">Modificar persona</a></font></td>
                    <td width="82" valign="bottom"><div align="center"><font size="2">
                      <input name="lee_[]" type="checkbox" id="lee_[]" value="1" />
                      participa?                    </font></div></td>
                  </tr>
                </table>              </td>
            </tr>
          </table>
	      <input name="lee[]" type="hidden"></input>
		  
  <?
 }
?>
        </div>
		
		<table width="100%" border="0" cellspacing="8" cellpadding="0">
		  <tr>
            <td><div align="left"><font size="2"><? // <a name="fin"></a><a href="#fin" onClick="agregarCoAutores()">[+] Agregar m&aacute;s Co-autores </a> ?></font></div>
                <div align="center"></div></td>
	      </tr>
  <tr>
    <td><div align="left"></div>
      <div align="center"></div></td>
    </tr>
  <tr>
    <td class="textos"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#FFCCFF">
      <tr>
        <td><table width="100%" border="0" cellspacing="8" cellpadding="0">
         
		 <?
		 if($_GET["txtClave"]!=""){
		 	 $lista = $trabajos->selectTL_ID($id_tl);
			 while ($row1 = mysql_fetch_object($lista)){
			 	$existeTrabajo = $row1->archivo_tl;
			 }
		 }
		if($existeTrabajo!=""){	
		 ?>
		  <tr>
            <td height="24" colspan="2" valign="top" bgcolor="#FFD5FF" class="textos"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0" class="textos">
                <tr>
                  <td><font color="#FF0000"><strong>&nbsp;&nbsp;Este trabajo contiene el archivo (&nbsp;<a href='#' onClick="bajarTL('<?=$existeTrabajo?>')"><img src='img/filesave.png' align='absmiddle' border='0' />
                          <?=$existeTrabajo?></a>&nbsp;)!!!</strong></font></td>
                </tr>
                <tr>
                  <td><input name="eliminarTrabajo" type="checkbox" id="eliminarTrabajo" value="1">
                    <strong>Eliminar el archivo existente.</strong> Si desea agregar otro trabajo es conveniente eliminar el anterior, para no sobrecargar el servidor </td>
                </tr>
              </table></td>
            </tr>
			<?
			}
			?>
          <tr>
            <td height="24" valign="top" class="textos"><div align="center">Archivo del trabajo libre<br>
                <font color="#FF0000" size="1">Debe ser menor de 2MB </font></div></td>
            <td valign="top"><input name="archivo_TL" type="file" id="archivo_TL"  style="width:590;" size="80"></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td><input name="Submit" type="button" class="botones" style="width:100%" value="Aceptar y enviar a la base de datos" onClick="validar()"></td>
  </tr>
</table>
 <input name="viejoArchivo" type="hidden" value="<?=$existeTrabajo?>">
 <input name="idEliminar" type="hidden" value="<?=$id_tl?>">
	  </form>    </td>
  </tr>
</table>


<script>
	llenarHoras();
	llenarPersonas();
	llenarTipoTL();
	llenarAreas();
	SinHoras();
</script>

<?
if($_GET["txtClave"]!=""){
	
	 $lista = $trabajos->selectTL_ID($id_tl);
	 while ($row1 = mysql_fetch_object($lista)){
		
		echo "<script>document.form1.estado_de_TL[" . $row1->estado . "].selected = true;</script>\n";
		echo "<script>seleccionarTipoTL('" . $row1->tipo_tl  . "');</script>\n";
	 	echo "<script>document.form1.numero_TL.value = '".$row1->numero_tl ."';</script>\n";
		
		echo "<script>seleccionarAreas('" . $row1->area_tl  . "');</script>\n";
		
		echo "<script>seleccionarCasillero('" . $row1->ID_casillero  . "');</script>\n";
		
		echo "<script>seleccionarHorasInicio('" .   $row1->Hora_inicio . "');</script>\n";
		echo "<script>seleccionarHorasFin('" .   $row1->Hora_fin . "');</script>\n";
		
		if($row1->Hora_inicio == "00:00:00" && $row1->Hora_fin == "00:00:00"){
			echo "<script>\n";
			echo "form1.chkSinHora.checked = true\n;";
			echo "SinHoras()\n;";
			echo "</script>";
		}

		echo "<script>document.form1.mailContacto_TL.value = '".$row1->mailContacto_tl ."';</script>\n";

		echo "<script>document.form1.titulo_TL.value = '".$row1->titulo_tl ."';</script>\n";
		echo "<script>document.form1.palabrasClave_TL.value = '".$row1->palabrasClave ."';</script>\n";
		
		echo "<script>arraySeleccion = new Array();</script>\n";
		
		$enLinea = 0;	
		$sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $row1->ID ." ORDER BY ID ASC;";
        $rs2 = mysql_query($sql2,$con);
        while ($row2 = mysql_fetch_array($rs2)){
		
			echo "<script>arraySeleccion.push('". $row2["ID_participante"] ."');</script>\n";
				
			if($row2["lee"]==1){

				echo "<script>document.form1.elements['lee_[]'][$enLinea].checked = true;</script>\n";
	
		    }
			
			$enLinea = $enLinea + 1;
		}
	 }
	 echo "<script>seleccionarPersonas();SinHoras();</script>\n";
	
}

?>