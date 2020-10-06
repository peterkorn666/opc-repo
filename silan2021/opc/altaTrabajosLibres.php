<?
//include('inc/sesion.inc.php');
include('conexion.php');
?>
<style>

.div_buscar_persona_TL{
	 width:480px;
	 overflow:hidden;
	 white-space:  nowrap;
	 float:left;
	 vertical-align:middle;
	 height:28px;
	 line-height:20px; 
	 font-family:Arial, Helvetica, sans-serif; 
	 font-size:12px; 
	 border-bottom:solid 1px  #999999; 
	 background-color:#C2DEED; 
	 padding:3px;
	 margin:0px;

}
.camposTL{

font-family:Arial, Helvetica, sans-serif;
font-size:11px;
}
.persona_search {

	width:480px; 
	overflow-X:hidden; 
	height:20px; 
	font-family:Arial, Helvetica, sans-serif; 
	font-size:12px; 
	border:solid 1px #000000; 
	background-color:#D2E1F7;
	padding:2px;
	
}

</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?

require("clases/trabajosLibres.php");
$trabajos = new trabajosLibre;

if($_GET["id"]!=""){
	 	
	$sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $_GET["id"]." ORDER BY ID ASC;";
    $rs2 = mysql_query($sql2,$con);

	
	$cantidadAutores = mysql_num_rows($rs2) + 2;
	$titulo = "Modificar";
	
}else{
	$cantidadAutores = 3;
	$titulo = "Alta";
	
}

echo "<script>\n";
echo "var cantidadAutores=" . $cantidadAutores . "\n";
echo "</script>";
?>
<script>

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
<script src="js/ajax.js"></script>
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
//$cargarArray->personas();
$cargarArray->horas();
?>
<? if  ($_SESSION["tipoUsu"]!=2) {include "inc/vinculos.inc.php";}?>
<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  >
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CFC2D6">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php";?></td>
  </tr>
  <tr>
    <td valign="top"><div align="center">
      <table width="100%" border="1" cellspacing="0" cellpadding="2">
        <tr>
          <td width="31%" height="30" align="center" valign="middle" bordercolor="#FF0000" bgcolor="#FFCACA" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("0");?>] </b><a href="estadoTL.php?estado=0">No revisados y registros On-line</a></td>
          <td width="19%" height="30" align="center" valign="middle" bordercolor="#0099CC" bgcolor="#79DEFF" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("1");?>]</b> <a href="estadoTL.php?estado=1">En revisi&oacute;n</a></td>
          <td width="25%" height="30" align="center" valign="middle" bordercolor="#006600" bgcolor="#82E180" class="menu_sel"><b>[<b><?=$trabajos->cantidadInscriptoTL_estado("2");?></b>]</b> <a href="estadoTL.php?estado=2">Aprobados</a></td>
          <td width="25%" height="30" align="center" valign="middle" bordercolor="#333333" bgcolor="#999999" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("3");?>] </b><a href="estadoTL.php?estado=3">Rechazados</a></td>
        </tr>
      </table>
      <br>      
          <strong><font color="#666666" size="3"><?=$titulo?> <font color="#000000">Trabajos Libres</font></font></strong></div>
      <form action="altaTrabajosLibresEnviar.php" method="post" enctype="multipart/form-data" name="form1">
	  	<div>
		  <div align="right">
		    <input name="Submit222" type="button" class="menuPrincipales" style="width:150px" onClick="validar()" value="GUARDAR">
&nbsp;		  </div>
		</div>
     <div style="background-color:#D8E9DD; border:solid 1px #666666; padding:5px; margin:5px;">
	  <div>
	    <div align="right"><em><strong><font color="#B7B7B7" size="3" face="Georgia, Times New Roman, Times, serif">Comite - Secretar&iacute;a </font></strong></em>&nbsp;<a href="javascript:abrir_cerrar_div('TL0')" class="linkAgregar" style="font-weight:normal;">mostrar/ocultar</a></div>
	  </div>
	   <div id="TL0">
	    <table width="750" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="118" bgcolor="#D8E9DD"><font size="2">Estado del  trabajo:</font></td>
            <td width="120" bgcolor="#D8E9DD"><font color="#333333" size="2">
              <select name="estado_de_TL" class="camposTL" id="estado_de_TL"  style="width:180px;">
                <option value="0" selected style="background-color:#FFCACA;">No revisados y registros On-line</option>
                <option value="1" style="background-color:#79DEFF;">En revisi&oacute;n</option>
                <option value="2" style="background-color:#82E180;">Aprobados</option>
                <option value="3" style="background-color:#999999;">Rechazados</option>
              </select>
            </font><font size="2"><a href="javascript:agregar('altaTipoTL.php', '80')"></a></font></td>
            <td width="174" bgcolor="#D8E9DD"><div align="right"><font size="2">Tipo de trabajo:</font></div></td>
            <td width="310" bgcolor="#D8E9DD"><font color="#333333" size="2">
             
			<select name="tipo_de_TL" class="camposTL" id="tipo_de_TL"  style="width:120px;">
			</select>
            </font><font size="2"><a href="javascript:agregar('altaTipoTL.php', '80')" class="linkAgregar">Agregar tipo de trabajo</a></font></td>
          </tr>          
          <tr>
            <td width="118" bgcolor="#D8E9DD"><strong><font size="2">Codigo  del trabajo:</font></strong></td>
            <td bgcolor="#D8E9DD"><font color="#333333" size="2">
              <input name="numero_TL" type="text" class="camposTL" id="numero_TL"  style="width:100
			  ;">
            </font></td>
            <td bgcolor="#D8E9DD"><div align="right"><font size="2">Idioma:</font></div></td>
            <td bgcolor="#D8E9DD">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#D8E9DD"><font size="2">Nombre contacto:</font></td>
            <td bgcolor="#D8E9DD"><input name="nombreContacto_tl" type="text" class="camposTL" id="nombreContacto_tl"  style="width:180px;"></td>
            <td align="right" bgcolor="#D8E9DD"><font size="2">Institucion contacto:</font></td>
            <td bgcolor="#D8E9DD"><input name="institucionContacto_tl" type="text" class="camposTL" id="institucionContacto_tl"  style="width:180px;"></td>
          </tr>
          <tr>
            <td bgcolor="#D8E9DD"><font size="2">Apellido contacto:</font></td>
            <td bgcolor="#D8E9DD"><input name="apellidoContacto_tl" type="text" class="camposTL" id="apellidoContacto_tl"  style="width:180px;"></td>
            <td bgcolor="#D8E9DD">&nbsp;</td>
            <td bgcolor="#D8E9DD">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#D8E9DD"><strong><font size="2">Mail de contacto:</font></strong></td>
            <td bgcolor="#D8E9DD"><input name="mailContacto_TL" type="text" class="camposTL" id="mailContacto_TL"  style="width:180px;"></td>
            <td bgcolor="#D8E9DD"><div align="right"><font size="2">Tel de contacto:</font></div></td>
            <td bgcolor="#D8E9DD"><font size="2">
              <input name="telContacto_TL" type="text" class="camposTL" id="telContacto_TL"  style="width:140px;">
            </font></td>
          </tr>
          <tr>
            <td width="118"><font size="2">Area:</font></td>
            <td colspan="3">
          
		   <select name="area_" class="camposTL" id="area_" style="width:400;">
           		<?php
					$sqlArea = "SELECT * FROM areas_trabjos_libres ORDER BY Area";
					$queryArea = mysql_query($sqlArea,$con) or die(mysql_error());
					while($rowArea = mysql_fetch_object($queryArea)){
						echo "<option value='$rowArea->id'>$rowArea->Area</option>";
					}
				?>
		   </select>
           <a href="javascript:agregar('altaAreaTL.php', '80')" class="linkAgregar">Agregar &aacute;rea</a></td>
          </tr>
          <tr>
            <td width="118"><font size="2">Ubicarlo en la actividad: </font></td>
            <td colspan="3"><font color="#333333" size="2">
              <select name="ID_casillero" class="camposTL" id="select2"  style="width:400;">
                <option value=""  style="background-color:#999999; color:#FF0000;" selected>Sin Ubicaci&oacute;n</option>
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
		          <?=$row["Tipo_de_actividad"]?>
				   /
		          <?=$row["Tematicas"]?>
                </option>
                <?
					 }
					 ?>
              </select>
              <font color="#333333" size="2"><font color="#990000"><a href="#"></a></font></font></font></td>
          </tr>
          <tr>
            <td><font size="2">Hora inicio a Hora fin </font></td>
            <td colspan="3"><font size="2">
              <select name="hora_inicio_" class="camposTL" id="hora_inicio_">
              </select>
              a
              <select name="hora_fin_" class="camposTL" id="hora_fin_">
              </select>
              </font> <font size="2">&nbsp;<a href="javascript:agregar('altaHora.php', '50')" class="linkAgregar">Agregar horario</a></font><font size="2">
                <label for="chkSinHora" style="cursor:pointer">
                  <input <?
			  if($_GET["id"]==""){
			 
			  echo "checked=\"checked\"";
			  
			  } ?> name="chkSinHora" type="checkbox" onClick="SinHoras()" id="chkSinHora">
                  Sin horario</label>
              </font></td>
          </tr>
        </table>
		</div>
		</div>
		
		
		
		
		<div style="background-color:#DCECFC; border:solid 1px #666666; padding:5px; margin:5px;">
	  <div>
	    <div align="right"><font color="#ABD1F8"><em><strong><font size="3" face="Georgia, Times New Roman, Times, serif">Trabajo</font></strong></em><font size="3"> </font></font>&nbsp;<a href="javascript:abrir_cerrar_div('TL1')" class="linkAgregar" style="font-weight:normal;">mostrar/ocultar</a></div>
	  </div>
		 <div id="TL1">
		  <table width="750" border="0" align="center" cellpadding="2" cellspacing="0">
		    <tr>
              <td colspan="2"><div align="left"><font size="2"><em>Titulo del trabajo libre:</em></font>
                  <input name="titulo_TL" type="text" class="camposTL" id="titulo_TL"  style="width:750px;">
              </div></td>
	        </tr>
		    <tr>
		      <td height="22" colspan="2" valign="top">
			  	   <div align="left"><font size="2"><em>Autores e instituciones</em></font></div>
				    <div id="divCoautores">
          <?
				for($i=1;$i<=$cantidadAutores;$i++){

					if ($colorfila == 0){
						//$color= "#9DD0B8";
						$colorfila=1;
						echo "<script> var colorfila=1; </script>\n";
						
					}else{
					//	$color="#D9ECE2";
						$colorfila=0;
						echo "<script> var colorfila = 0; </script>\n";
					}
					$_SESSION["id"] = $_GET["id"]
				?>
				
				
					
          <table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="bordePunteadoAbajo" style="margin:2px;">
            <tr>
              <td>
			  <table width="740" border="0" align="center" cellpadding="2" cellspacing="0">
                  <tr valign="top">
                    <td width="100" height="15" valign="top">
					<font size="2">
				<font size="1" color="#9900FF">[<?=$i?>]</font>
				<?
				if($soloUnAutor!=1){
					echo "Autor:";
					$soloUnAutor=1;
				}else{
					echo "Co - Autor:";
				}
				?>					</font></td>
                    <td width="533" height="15" valign="top"  nowrap="nowrap">

					 <div>
						 <div id="txt_persona_<?=($i-1)?>" style=" position:relative; margin-bottom:4px; overflow:hidden; width:450px; display:none; float:left;"></div>
						
						 <input name="persona[]" type="hidden" />

						 <input name="persona_<?=($i-1)?>" type="text" class="camposTL" id="persona_<?=($i-1)?>"   style="width:250; color:#999999;" onKeyUp="buscando_personas('persona<?=($i-1)?>', this.value, <?=($i-1)?>, 'persona_<?=($i-1)?>')" onClick="this.value=''" value="Buscar autor por su apellido, en la base de datos...">
						 <a href="javascript:agregar('altaPersonasTL.php', '300' , <? echo ($i-1); ?>)" class="linkAgregar" style="font-size:11px; font-weight:normal;">Agregar una nueva persona en la base de datos</a></div>
						 <div id='persona<?=($i-1)?>'></div>						 </td>
                    <td width="95" valign="top"><font size="2">
                      <input name="lee_[]" type="checkbox" id="lee_[]" value="1" />
                    presentador                    </font></td>
                  </tr>
                </table>              </td>
            </tr>
          </table>
	      <input name="lee[]" type="hidden" />
		  
  <?
 }
?>
        </div>
					<div align="right" style="margin-top:5px;"><font size="2"> <a name="fin"></a><a href="#fin" class="linkAgregar" style="font-weight:normal;" onClick="agregarCoAutores()">[+] Agregar m&aacute;s Co-autores </a></font></div></td>
	        </tr>
		    <tr>
              <td height="22" colspan="2" valign="top"><font size="2">Resumen:</font>
                <?
			if($_GET["id"]!=""){
			$lista = $trabajos->selectTL_ID($_GET["id"]);
			while ($row1 = mysql_fetch_object($lista)){
				$textoResume= $row1->resumen;
				}
			}
			?>
                <textarea name="resumenTL" rows="5" wrap="physical" class="camposTL" id="resumenTL"style="width:100%;"><?=$textoResume?></textarea></td>
	        </tr>
		    <tr>
              <td width="97" height="22"><font size="2">Palabras Clave :</font></td>
		      <td width="651"><input name="palabrasClave_TL" type="text" class="camposTL" id="palabrasClave_TL"  style="width:450;" />
                  <font color="#990000" size="1">(Separe las palabras con una coma)</font></td>
		      </tr>
          </table>
		  </div>
	    </div>
		
			<div style="background-color:#FFCBCA; border:solid 1px #666666; padding:5px; margin:5px;">
 <div>
	    <div align="right"><font color="#ABD1F8"><em><strong><font color="#FF9693" size="3" face="Georgia, Times New Roman, Times, serif">Archivo</font></strong></em><font size="3">&nbsp; </font></font><a href="javascript:abrir_cerrar_div('TL2')" class="linkAgregar" style="font-weight:normal;">mostrar/ocultar</a></div>
	  </div>
	<div id="TL2">
		<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="750" border="0" cellspacing="0" cellpadding="5">
         
		 <?
		 if($_GET["id"]!=""){
		 	 $lista = $trabajos->selectTL_ID($_GET["id"]);
			 while ($row1 = mysql_fetch_object($lista)){
			 	//$existeTrabajo = $row1->archivo_tl;
				$existeTrabajo = $row1->archivo_trabajo_comleto;
				$viejoActualizacion = $row1->ultima_actualizacion;
				
				$NombreContacto = $row1->nombreContacto;
				$ApellidoContacto = $row1->apellidoContacto;
				$InstContacto = $row1->institucionContacto;
				$paisContacto = $row1->paisContacto;
				$ciudadContacto = $row1->ciudadContacto;
				$will_sendContacto = $row1->will_sendContacto;
			
				
			 }
		 }
		if($existeTrabajo!=""){	
		 ?>
		  <tr>
            <td height="24" colspan="2" valign="top" class="textos"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0" class="textos">
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
            <td valign="top"><input name="archivo_TL" type="file" class="camposTL" id="archivo_TL"  style="width:590;" size="80"></td>
          </tr>
        </table></td>
      </tr>
    </table>
	</div>
		</div>
		
		<div>
		  <div align="right">
		    <input name="Submit22" type="button" class="menuPrincipales" style="width:150px" onClick="validar()" value="GUARDAR">
&nbsp;	        </div>
		</div>
		
		 <input name="viejoArchivo" type="hidden" value="<?=$existeTrabajo?>">
		 
		  <input name="NombreContacto" type="hidden" value="<?=$NombreContacto?>">
		   <input name="ApellidoContacto" type="hidden" value="<?=$ApellidoContacto?>">
		    <input name="InstContacto" type="hidden" value="<?=$InstContacto?>">
			 <input name="paisContacto" type="hidden" value="<?=$paisContacto?>">
			  <input name="ciudadContacto" type="hidden" value="<?=$ciudadContacto?>">
		 		<input name="will_sendContacto" type="hidden" value="<?=$will_sendContacto?>">
		 
		 <input name="viejoActualizacion" type="hidden" value="<?=$viejoActualizacion?>">
		 
		 
		 
		 
		 
 <input name="idEliminar" type="hidden" value="<?=$_GET["id"]?>">
  <input name="clave" type="hidden">
  <input name="archivo_trabajo_comleto" type="hidden">
    </form>    </td>
  </tr>
</table>
<select name="idioma" class="camposTL" id="idioma" style="display:none">
  <?
				
				?>
  <option value=""></option>
  <option value="Español">Espa&ntilde;ol</option>
  <option value="Portugués">Portugu&eacute;s</option>
  <option value="Inglés">Ingl&eacute;s</option>
  <option value="Francés">Franc&eacute;s</option>
  <option value="Italiano">Italiano</option>
</select>
<script>

	llenarHoras();
	/*llenarPersonas();*/

	llenarTipoTL();
	//llenarAreas();
	
	SinHoras();
</script>

<?
if($_GET["id"]!=""){
	
	 $lista = $trabajos->selectTL_ID($_GET["id"]);
	 while ($row1 = mysql_fetch_object($lista)){
		
		echo "<script>document.form1.estado_de_TL[" . $row1->estado . "].selected = true;</script>\n";
		echo "<script>seleccionarTipoTL('" . $row1->tipo_tl  . "');</script>\n";
	 	echo "<script>document.form1.numero_TL.value = '".$row1->numero_tl ."';</script>\n";
		
		/*switch($row1->idioma){

			case "" :
			echo "<script>document.form1.idioma[0].selected = true;</script>\n";
			break;
			
			case "Español" :
			echo "<script>document.form1.idioma[1].selected = true;</script>\n";
			break;
			
			case "Portugués" :
			echo "<script>document.form1.idioma[2].selected = true;</script>\n";
			break;
			
			case "Inglés" :
			echo "<script>document.form1.idioma[3].selected = true;</script>\n";
			break;
			
			case "Francés" :
			echo "<script>document.form1.idioma[4].selected = true;</script>\n";
			break;
			
			case "Italiano" :
			echo "<script>document.form1.idioma[5].selected = true;</script>\n";
			break;

		}*/

		echo "<script>seleccionarAreas('" . trim($row1->area_tl)  . "');</script>\n";
		
		if($row1->premio == "Si"){
			/*echo "<script>seleccionarPremio('" . $row1->quePremio  . "');</script>\n";*/
		}
		
	
		
		echo "<script>seleccionarCasillero('" . $row1->ID_casillero  . "');</script>\n";
		
		echo "<script>seleccionarHorasInicio('" .   $row1->Hora_inicio . "');</script>\n";
		echo "<script>seleccionarHorasFin('" .   $row1->Hora_fin . "');</script>\n";
		
		if($row1->Hora_inicio == "00:00:00" && $row1->Hora_fin == "00:00:00"){
			echo "<script>\n";
			echo "form1.chkSinHora.checked = true\n;";
			echo "SinHoras()\n;";
			echo "</script>";
		}

		echo "<script>document.form1.nombreContacto_tl.value = '".$row1->nombreContacto ."';</script>\n";
		echo "<script>document.form1.apellidoContacto_tl.value = '".$row1->apellidoContacto ."';</script>\n";
		echo "<script>document.form1.institucionContacto_tl.value = '".$row1->institucionContacto ."';</script>\n";
		echo "<script>document.form1.mailContacto_TL.value = '".$row1->mailContacto_tl ."';</script>\n";
		echo "<script>document.form1.telContacto_TL.value = '".$row1->telefono ."';</script>\n";
		
		echo "<script>document.form1.clave.value = '".$row1->clave ."';</script>\n";
		echo "<script>document.form1.archivo_trabajo_comleto.value = '".$row1->archivo_trabajo_comleto ."';</script>\n";
		

		echo "<script>document.form1.titulo_TL.value = '".$row1->titulo_tl ."';</script>\n";
		echo "<script>document.form1.palabrasClave_TL.value = '".$row1->palabrasClave ."';</script>\n";
		
		echo "<script>arraySeleccion = new Array();</script>\n";
		
		/*if($row1->premio == "Si"){
			echo "<script>document.form1.premio[1].checked=true;</script>\n";
			echo "<script>mostrarDiv('quePremio');</script>\n";
		}else{
			echo "<script>document.form1.premio[0].checked=true;</script>\n";
			echo "<script>document.form1.quePremio.disabled = true;</script>\n";
		}*/

		$enLinea = 0;	
		
		
		$sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $_GET["id"] ." ORDER BY ID ASC;";
        $rs2 = mysql_query($sql2,$con);
        while ($row2 = mysql_fetch_array($rs2)){
		
			
				$sql ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas = " . $row2["ID_participante"] ." LIMIT 1;";
				$rs = mysql_query($sql,$con);
				while ($row = mysql_fetch_array($rs)){
				
					if($row["inscripto"]==1){

						$ins ="<img src=img/puntoVerde.png />";
					
					}else{
					
						$ins ="";
						
					}

					$persona = $ins . "  <font size=2><strong>" . $row["Apellidos"] . ", " . $row["Nombre"] . "</strong> (" . $row["Pais"] . ") - " . $row["Institucion"] . "</font>"; 

					echo "<script>cargar_persona_buscada($enLinea ," .  $row["ID_Personas"] . ", '$persona');</script>\n";
		
				}
		
			echo "<script>arraySeleccion.push('". $row2["ID_participante"] ."');</script>\n";
				
			if($row2["lee"]==1){

				echo "<script>document.form1.elements['lee_[]'][$enLinea].checked = true;</script>\n";
	
		    }
			
			$enLinea = $enLinea + 1;
		}
	 }
	 
	 echo "<script>SinHoras();</script>\n";
/*
	echo "<script>seleccionarPersonas();SinHoras();</script>\n";
	*/
}else{
	 
	 echo "<script>\n";
	echo "form1.chkSinHora.checked = true;\n";
	echo "</script>";
	 }
?>