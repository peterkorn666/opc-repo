<?
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_SESSION["registrado"])){
	$_SESSION["registrado"]=false;
}
$_SESSION["finalizo"]=0;
include('conexion.php');
include("inc/validarVistas.inc.php");
include("inc/sesion.inc.php");
require "clases/class.Cartas.php";
$cartas = new cartas();
//$_POST["tl"] = ($_POST["id_trabajos"]?$_POST["id_trabajos"]:$_POST["tl"]);
//$_POST["inscriptos"] = ($_POST["ids_inscriptos"]?$_POST["ids_inscriptos"]:$_POST["inscriptos"]);

require ("../inscripcion/clases/lang.php");
$lang = new Language("es");

$tipo_carta = "Inscriptos";
$contenidos_carta = "inscriptos";
?>

<!--<script src="js/jquery.js"></script>-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/envioMail.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">

<!--
.personas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color: #F0F0F0;
	width: 70%;
	margin: 1px;
	padding: 4px;
	border: 1px solid #999999;
	position:relative;
	left: 100;
}
.personasTL {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-color:#E8DBE8;
	width: 100%;
	margin: 1px;
	padding: 4px;
	border: 1px solid #999999;
	position:relative;
}
#Guardando{
	background-color: #FFBFBF;
	margin: 5px;
	padding: 5px;
	height: 20px;
	width: 150px;
	border: 1px solid #FF0000;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	text-align: center;
	position:absolute;
	left:0px;
	
	visibility:hidden;
top: expression( ( 0 + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );


}
body > #Guardando { position: fixed; left: 0px; top: 0px; }

#msn1{
	background-color: #FFFFCC;
	margin: 2px;
	padding: 2px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	text-align: center;
	font-weight: bold;
}
#abc {
	background-color: #FFFFFF;
	padding: 2px;
	border: 1px solid #333333;
	margin: 2px;
}
#abcTL {
	background-color: #F7F4F7;
	padding: 2px;
	border: 1px solid #333333;
	margin: 2px;
}
.Estilo4 {
	color: #333333;
	font-size: 11px;
}
.campos {	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	width: 200px;
}
.paginas {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	border: 1px solid #000000;
	background-color:#F3F5F8;
	text-align: center;
	text-decoration: none;
}
.paginasSel {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #000000;
	border: 2px solid #003300;
	background-color:#00CCFF;
	text-align: center;
	text-decoration: none;
}
.paginas:hover {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: bold;
	color: #ffffff;
	border: 1px solid #000000;
	background-color:#003366;
	text-align: center;
	text-decoration: none;
}
-->
</style>

<body background="fondo_2.jpg" leftmargin="0" topmargin="0" bgproperties="fixed" marginwidth="0" marginheight="0">
<? include "inc/vinculos.inc.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td height="10" valign="top" bgcolor="#666666"><? include "menu.php"; ?></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F0E6F0" align="center"><div align="center" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:16px"><strong><br>
      Envio de e-mails</strong><br>
      Trabajos</div>
      <form action="envioMail_inscriptos_send.php" enctype="multipart/form-data" method="post" name="form1">
	<iframe id="guardarInscripcion" name="guardarInscripcion" style="display:none"></iframe>
        <table width="90%" border="0" cellspacing="5" cellpadding="2">
          <tr>
            <td align="center">
            	<div style="width:85%; background-color:#FEFFEA; border:1px solid #333;">
                <table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
                	<tr>
                      <td width="14%"><strong>Asunto:</strong></td>
                      <td width="86%"><span>
						<input name="asunto0" type="text" id="asunto0"  style="width:30%; font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"></span>
						<span><strong><font color="#666666"> [Nº INSC] [Apellido Nombre] </font></strong></span><span>
							<input name="asunto1" type="text" id="asunto1"  style="width:25%; font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif" />
						</span></td>
					</tr>
                    <tr>
                      <td colspan="2"><strong>Adjuntar un archivo:
                        <input name="archivo" type="file" class="campos" id="archivo" 
                        	style="width:50%; font-size:13x; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif"/>
                        </strong>
                          <input name="archivoTMP" type="hidden" id="archivoTMP"></td>
                    </tr>
                    <tr>
                    	<td colspan="2">
                  		<label  for="rbCartaManual" style="cursor:pointer">
                    	<input name="rbCarta" id="rbCartaManual" checked="checked" type="radio" value="Manual" />
                    <strong>Carta Manual </strong></label><br>
<? 
				$listaPredefinidas = $cartas->cargarPredefinidas($tipo_carta);
				 while ($predefinida = $listaPredefinidas->fetch_array()){ ?>     
                         <label  for="rbCartaPredefinida<?=$predefinida["titulo"]?>" style="cursor:pointer">             		
				  		 <input name="rbCarta" id="rbCartaPredefinida<?=$predefinida["idCarta"]?>" type="radio" 
                         	value="<?=$predefinida["idCarta"]?>" 
							<? if($_SESSION["rbCarta"]==$predefinida["idCarta"]){echo 'checked="checked"';}?>
                         >
                         <strong><?=$predefinida["titulo"]?></strong> - <?=$predefinida["subtitulo"]?></label><br>
				<? } ?><br><br>
                
				<textarea id="carta" name="carta" rows="5" style="padding:2px; width:100%; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:11px"></textarea><br>
                  <a href="altaCartaPersonalizada.php?nueva=<?=base64_encode($tipo_carta);?>">Nueva predefinida</a> </td></tr>
              </table></div></td>
          </tr>
          <tr>
            <td align="center"><div style="border:1px solid #333; width:85%"><table width="100%" border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px" bgcolor="#ECF4F9">
              <tr>
                <td colspan="3"><label style="cursor:pointer"><input name="A_otro" type="checkbox" id="A_otro" value="1">
                  <span>Enviar  mail de  cada inscripto seleccionado a un solo destinatario, el cual es:</span></label></td>
              </tr>
              <tr>
                <td colspan="3" style="padding-left:100px"><input name="mailAotro" type="text" id="mailAotro" style="font-size:11px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; width:300px;"></td>
                </tr>
              <tr>
                <td colspan="3"><label style="cursor:pointer"><input name="A_contacto" type="checkbox" id="A_participante" value="1">
                  <span>Enviar el mail correspondiente al email del inscripto seleccionado</span></label></td>
              </tr>
             <!--<tr>
                <td width="35%"><strong>Datos del trabajo en el mail:</strong></td>
                <td width="31%">
                  <input name="chkMostrarUbicacion" type="checkbox" id="chkMostrarUbicacion" value="1">
                  <span> Mostrar Ubicación</span></td>
                <td width="34%">                  <label style="cursor:pointer"> 
                    <input name="chkMostrarTrabajo" type="checkbox" id="chkMostrarTrabajo" value="1">
                    <span>Mostrar Trabajo </span></label></td>
              </tr>-->
              <tr>
                <td colspan="3"><div align="right">
                  <input type="button" name="Submit" value="Enviar mails" onClick="enviarMailsInscriptos()" style="width:150px; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px">
                </div></td>
              </tr>


            </table>
            </div></td>
          </tr>
          <tr>
            <td width="50%" height="121" valign="top" align="center">
    <?
	
    /*if($_POST["inscriptos"]!=""){
		if(count($_POST["inscriptos"]) > 0){
			$txt_ids = "";
			foreach($_POST["inscriptos"] as $id_inscripto){
				$txt_ids .= $id_inscripto.", ";
			}
			$txt_ids = substr($txt_ids, 0, -2);
		}
		$inscriptos = $con->query("SELECT * FROM inscriptos WHERE id IN (".$txt_ids.") ORDER BY id");
		if(!$inscriptos){
		?>
		<script language="javascript" type="text/javascript">
			document.location.href="estadoTL.php?neg=true&estado=cualquier&vacio=true";
		</script>
		<?	
		}	
	}else{*/
		$inscriptos_cuenta = $con->query("SELECT id FROM inscriptos ORDER BY id");
	//}
	//$totalEncontrados = count($inscriptos_cuenta);	
	
	$costos_inscripcion = $lang->set["COSTOS_INSCRIPCION"]["array"];
	
	//agregado
	$cuantosPe = -1;
	$pagina = $_GET["inicio"];
	$TAMANO_PAGINA = 300; 
	
	if (!$pagina) { 
		$inicio = 1; 
		$pagina=1; 
	} 
	else { 
		$inicio = ($pagina - 1) * $TAMANO_PAGINA; 
		if($inicio==0){$inicio=1;}
	} 
		//echo $inicio . " - ". $TAMANO_PAGINA . "<br>";

	//agregado
	$limit = "";
	if($pagina == 1)
		$limit = "LIMIT 0,300";//fila de comienzo+1 (0)(comienza en 1), cantidad de filas que trae (300)
	else if($pagina == 2)
		$limit = "LIMIT 300,300";
	else if($pagina == 3)
		$limit = "LIMIT 600,300";
	else if($pagina == 4)
		$limit = "LIMIT 900,300";
		
	$filtro_tipo = $_GET["filtro_tipo_inscripcion"];
	$filtro = "WHERE 1=1";
	if($filtro_tipo){
		$tipo_url = "&filtro_tipo_inscripcion=".$_GET["filtro_tipo_inscripcion"];
		$filtro .= " AND tipo_inscripcion='".$filtro_tipo."'";
		
		if($filtro_tipo == '2'){
			$costos_inscripcion = $lang->set["COSTOS_INSCRIPCION_JORNADA_PADRES"]["array"];
		}
	}
		
	$filtro_costo = $_GET["filtro_costos_inscripcion"];
	if($filtro_costo){
		$costo_url = "&filtro_costos_inscripcion=".$_GET["filtro_costos_inscripcion"];
		$costos = $costos_inscripcion;
		foreach($costos as $index => $costo){
			if($filtro_costo == $index){
				$filtro .= " AND costos_inscripcion=".(int)$index;
			}
		}
	}
	
	$SQLinscriptos_contador = $con->query("SELECT COUNT(id) as contador FROM inscriptos ".$filtro." ORDER BY id");
	$inscriptos_contador = $SQLinscriptos_contador->fetch_array();
	$cantidadTotal = (int)$inscriptos_contador["contador"];
	
	$inscriptos = $con->query("SELECT * FROM inscriptos ".$filtro." ORDER BY id ".$limit);
	$cuantasPag = intdiv($cantidadTotal, $TAMANO_PAGINA);
	/*$modulo = $cantidadTotal % $TAMANO_PAGINA;var_dump($cuantasPag);
	if($modulo > 0){
		$cuantasPag = $cuantasPag + 1;
	}*/
	?>
    
	<div style="border:1px solid #333; width:85%">
    	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#E4EDE4" 
        	style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:13px"
		>
			<tr>
				<td height="25" colspan="2" valign="middle"><strong><span><?=$tipo_carta?></span></strong><br>
					<span class="Estilo4">Hay [<?=$cantidadTotal?>] <?=$contenidos_carta?> que tienen email</span>
				</td>
			</tr>
            <tr>
				<td height="25" colspan="6" valign="middle" bgcolor="#D0E1D1"><div align="center" style="margin-top:2px">
				<?
					for($i=1;$i<=($cuantasPag+1);$i++){
						if($i!=$pagina){
				?>
							&nbsp;<a href="envioMail_inscriptos.php?inicio=<?=$i?><?=$tipo_url?><?=$costo_url?>" target="_self" class="paginas">&nbsp;
							<?=$i?>
							&nbsp;</a>
				<?
						}else{
							echo "&nbsp;<span class='paginasSel'>&nbsp;". $i . "&nbsp;</span>";			  
						}
					}
              ?>
				</div></td>
			</tr>
            <tr>
				<td height="25" colspan="2" valign="middle" bgcolor="#D0E1D1">&nbsp;
                	<a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarTodos(true, 'inscriptos')">Marcar todos</a> 
                    <font size="1">/</font> 
                    <a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" onClick="marcarTodos(false, 'inscriptos')">Desmarcar todos</a>
				</td>
			</tr>
            <tr>
                <td height="25">
                    Tipo Inscripto: 
                    <select id="filtro_tipo_inscripcion" name="filtro_tipo_inscripcion" onChange="seleccionarTipo()">
                        <option value=""></option>
                        <option value="1" <?php if($_GET["filtro_tipo_inscripcion"] == '1') echo 'selected'; ?>>Congreso</option>
                        <option value="2" <?php if($_GET["filtro_tipo_inscripcion"] == '2') echo 'selected'; ?>>Jornada del Movimiento Asociativo de Padres</option>
                    </select>
                </td>
                <td height="25">
                    Costos inscripción: 
                    <select id="filtro_costos_inscripcion" name="filtro_costos_inscripcion" onChange="seleccionarCostoInscripcion()">
                        <option value=""></option>
                        <?php
                            foreach($costos_inscripcion as $index => $costo_inscripcion){
								if((int)$_GET["filtro_costos_inscripcion"] == $index)
									$slcted = "selected";
                        ?>
                                   <option value="<?=$index?>" <?=$slcted?>><?=$lang->getValue($costo_inscripcion)?> - <?=$lang->getValue($costo_inscripcion, 1)?></option>
                        <?php	
								$slcted = "";
                            }
                        ?>
                    </select>
                </td>
            </tr>

			<? 
            while ($row = $inscriptos->fetch_object()){
        	?>
				<script>CuantosI = CuantosI + 1;</script>
                <tr class="inscripto<?=$row->id?>">
                    <td width="513" bgcolor="#FFFFFF" colspan="2">
                    	<input name="inscriptos[]" type="checkbox" id="inscriptos[]" value="<?=$row->id?>">
                        <input name="tipo_inscripcion" type="hidden" value="<?=$row->tipo_inscripcion?>">
                        <input name="costo_inscripcion" type="hidden" value="<?=$row->costos_inscripcion?>">
                        <strong><?=$row->id?></strong> - <?=$row->nombre?> <?=$row->apellido?> [Email: <?=$row->email?>]
					</td>
                </tr>
			<? 
			}
			?>
			<tr>
				<td height="25" colspan="2" valign="middle" bgcolor="#D0E1D1">&nbsp;
                	<a href="javascript:void(0)" style="font-weight:normal; font-size:11px;" 
                    	onClick="marcarTodos(true, 'inscriptos')">Marcar todos</a> 
                    <font size="1">/</font> 
                    <a href="javascript:void(0)" style=" font-weight:normal; font-size:11px;" 
                    	onClick="marcarTodos(false, 'inscriptos')">Desmarcar todos</a>
				</td>
			</tr>
		</table>	
	</div>
    </td>
	</tr>
    </table>
	</form>
    </td>
  </tr>
</table>
