<?php
require('inc/sesion.inc.php');
require('conexion.php');
require("clases/trabajosLibres.php");
header('Content-Type: text/html; charset=UTF-8');
?>
<script src="js/jquery.1.4.2.js" type="text/javascript"></script>
<?php
include "inc/vinculos.inc.php";

$trabajos = new trabajosLibre;

$rowTL = new stdClass();

$cmtEvaluador = array();

if($_GET["id"]!=""){
	 $id_trabajo = $_GET["id"];
	 $lista = $trabajos->selectTL_ID($_GET["id"]);
	 $rowTL = mysql_fetch_object($lista);

		
	//Cartas	
	$cartEnviadas = explode("[",$rowTL->cartasEnviadas);
	$cartEnviadas = str_replace("]","",$cartEnviadas);
	$cartasEnviadas = "<font size='-3'>$cartEnviadas[2]</font>";
	//Cartas--
	
		$sqlEval = "SELECT t.*,e.*,e.comentarios as ecomentarios,ev.* FROM trabajos_libres as t JOIN evaluaciones as e ON t.numero_tl=e.numero_tl JOIN  evaluadores as ev ON e.IdEvaluador=ev.id WHERE t.ID='$id_trabajo'";
		$queryEval = mysql_query($sqlEval,$con) or die(mysql_error());
		//echo $sqlEval;
		$evl = "";
		
	
		
		echo "<script>arraySeleccion = new Array();</script>\n";

		$enLinea = 0;	
		
}
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="css/tipsy.css" rel="stylesheet" type="text/css">
<?php



if($_GET["id"]!=""){
	 	
	$sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = " . $_GET["id"]." ORDER BY ID ASC;";
    $rs2 = mysql_query($sql2,$con);

	
	$cantidadAutores = mysql_num_rows($rs2);
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
function validar(){
	//cargarLee();
	H_inicio = document.form1.hora_inicio_.value.replace(":","")
	H_inicio = H_inicio.replace(":","")
	
	H_fin = document.form1.hora_fin_.value.replace(":","")
	H_fin = H_fin.replace(":","")


if(document.form1.chkSinHora.checked==false){
	if(H_fin < H_inicio){ 
		alert("La hora inicio no puede ser mayor a la hora de fin");
		return;
	}else if (H_fin == H_inicio){
		alert("La hora inicio no puede igual a la hora de fin");
		return;
	}
	
}

	
	
	document.form1.submit();
}

</script>
<script src="js/tipsy.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $('.tipsy').tipsy({gravity: 's',fade: true,live:true});
	$('.tipsy_focus').tipsy({trigger: 'focus', gravity: 's'});
	
	$(".popup").live("click",function(e){
		e.preventDefault();

	    $("#iframeajax").attr("src",$(this).attr("href"));
		$("#boxajax").fadeIn("slow");
		$("#capa").fadeIn("slow");
		
		$("#iframeajax").load(function (){
			$("#iframeajax").contents().find("body").css("background","none");
			var widthI = $("#iframeajax").contents().width();
			var heightI = $("#iframeajax").contents().height();
	
			$("#boxajax").css("width",widthI+10 + 'px');
			$("#iframeajax").css("width",widthI+10 + 'px');
			
			$("#boxajax").css("height",heightI + 'px');
			$("#iframeajax").css("height",heightI+ 'px');
			
			$('#boxajax').css({
               left: ($(window).width() - $('#boxajax').outerWidth())/2,
               top: ($(window).height() - $('#boxajax').outerHeight())/2,
         });
			
		})

	})
	
	$(".close_popup").live("click",function(){
		$("#iframeajax").attr("src","");
		$("#capa").fadeOut("slow");
		$("#boxajax").fadeOut("slow");
		$("#boxajax2").fadeOut("slow");
	})
	
	function closePopup(){
		$("#iframeajax").attr("src","");
		$("#capa").fadeOut("slow");
		$("#boxajax").fadeOut("slow");
		$("#boxajax2").fadeOut("slow");
	}
	
	$(".cmt_evaluador").click(function(){
		var alto = $(this).css("max-height");
		if(alto=="50px"){
			$(this).css("max-height","100%");
		}else{
			$(this).css("max-height","50px");
		}
	}).hover(function(){
		$(".cmt_evaluador").css("cursor","pointer");
	})
	
	$("#link_evaluadores").click(function(e){
		e.preventDefault();
		$("#tabla_evaluadores").slideToggle();
	})
	
	$(".evl_mail").click(function(e){
		e.preventDefault();
		if($("[name='estado_trabajo_libre']").val()=="2"){
			if(confirm("Desea enviar la carta de aceptacion al contacto del trabajo")){
				document.location.href = "envioMail_contacto_tl_evaluacion.php?id="+$(this).attr("id");
			}
		}else{
			alert("El trabajo debe estar aprobado.");
		}
	})
	
});
</script>
<script src="js/ajax.js"></script>
<script src="js/personasTL.js"></script>
<script src="js/autoresTL.js"></script>

<?php
function porcentaje($porcentaje,$de){
	$tanto_porciento=$de*$porcentaje/100;
	return $tanto_porciento;
}


//$cargarArray = new trabajosLibre();
//$cargarArray->arrayAreas();
//$cargarArray->arrayTipoTL();
//$cargarArray->personas();
//$cargarArray->horas();
?>

<body background="fondo_2.jpg" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<? include "menu.php";?>
<table width="770" height="100%" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#999999" bgcolor="#CFC2D6">
  <tr>
    <td height="10" valign="top" bgcolor="#666666">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><div align="center">
      <table width="100%" border="1" cellspacing="0" cellpadding="2">
        <tr>
          <td width="19%" height="30" align="center" valign="middle" bordercolor="#FF0000" bgcolor="#FFCACA" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("0");?>] </b><a href="estadoTL.php?estado=0">Recibidos</a></td>
          <td width="21%" height="30" align="center" valign="middle" bordercolor="#0099CC" bgcolor="#79DEFF" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("1");?>]</b> <a href="estadoTL.php?estado=1">En revisi&oacute;n</a></td>
          <td width="18%" height="30" align="center" valign="middle" bordercolor="#006600" bgcolor="#82E180" class="menu_sel"><b>[<b><?=$trabajos->cantidadInscriptoTL_estado("2");?></b>]</b> <a href="estadoTL.php?estado=2">Aprobados</a></td>
          <td width="22%" align="center" valign="middle" bordercolor="#333333" bgcolor="#E074DD" class="menu_sel"><b>[<b>
          <?=$trabajos->cantidadInscriptoTL_estado("4");?>
        </b>]</b> <a href="estadoTL.php?estado=4">Notificados</a></td>
          <td width="20%" height="30" align="center" valign="middle" bordercolor="#333333" bgcolor="#999999" class="menu_sel"><b>[<?=$trabajos->cantidadInscriptoTL_estado("3");?>] </b><a href="estadoTL.php?estado=3">Rechazados</a></td>
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
	    <div align="right"><div style="float:left; font-size:12px"><strong><?=$rowTL->fecha_creado?></strong></div><em><strong><font color="#B7B7B7" size="3" face="Georgia, Times New Roman, Times, serif">Comite - Secretar&iacute;a </font></strong></em>&nbsp;<a href="javascript:abrir_cerrar_div('TL0')" class="linkAgregar" style="font-weight:normal;">mostrar/ocultar</a></div>
	  </div>
	   <div id="TL0">
	    <table width="750" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td width="125" bgcolor="#D8E9DD"><div align="right"><font size="2" style="font-size:11px">Modalidad</font></div></td>
            <td width="182" bgcolor="#D8E9DD"><select name="tipo_tl">
              <option value=""></option>
              <option value="Oral" <?php if($rowTL->tipo_tl=="Oral"){echo "selected";} ?>>Oral</option>
              <option value="Poster" <?php if($rowTL->tipo_tl=="Poster"){echo "selected";} ?>>Póster</option>
            </select></td>
            <td width="142" bgcolor="#D8E9DD">&nbsp;</td>
            <td width="285" bgcolor="#D8E9DD"><!--<font size="2" style="font-size:11px"><a href="javascript:agregar('altaTipoTL.php', '80')" class="linkAgregar">Agregar tipo de trabajo</a></font>--></td>
          </tr>
          <tr>
            <td width="125" bgcolor="#D8E9DD"><font size="2" style="font-size:11px">Codigo  del trabajo:</font></td>
            <td bgcolor="#D8E9DD"><font color="#333333" size="2">
              <input name="numero_TL" type="text" class="camposTL" id="numero_TL" value="<?=$rowTL->numero_tl?>"  style="width:100; font-size:14px">
              </font></td>
            <td bgcolor="#D8E9DD"><div align="right"><font size="2" style="font-size:11px">Tel&eacute;fono</font></div></td>
            <td bgcolor="#D8E9DD"><input name="contacto_telefono" type="text" class="camposTL" id="apellidoContacto_TL6"  style="width:180px; font-size:14px" value="<?=$rowTL->contacto_telefono?>"></td>
          </tr>
          <tr>
            <td bgcolor="#D8E9DD"><font size="2" style="font-size:11px">Nombre contacto</font></td>
            <td bgcolor="#D8E9DD"><input name="contacto_nombre" value="<?=$rowTL->contacto_nombre?>" type="text" class="camposTL" id="nombreContacto_TL"  style="width:180px; font-size:14px"></td>
            <td align="right" bgcolor="#D8E9DD"><font size="2" style="font-size:11px">Apellido contacto</font></td>
            <td bgcolor="#D8E9DD"><input name="contacto_apellido" type="text" class="camposTL" id="apellidoContacto_TL"  style="width:180px; font-size:14px" value="<?=$rowTL->contacto_apellido?>"></td>
          </tr>
          <tr>
            <td bgcolor="#D8E9DD"><font size="2" style="font-size:11px">Email</font></td>
            <td bgcolor="#D8E9DD"><input name="contacto_mail" type="text" class="camposTL" id="apellidoContacto_TL2"  style="width:180px; font-size:14px" value="<?=$rowTL->contacto_mail?>"></td>
            <td align="right" bgcolor="#D8E9DD"><font size="2" style="font-size:11px">Instituci&oacute;n</font></td>
            <td bgcolor="#D8E9DD"><input name="contacto_institucion" type="text" class="camposTL" id="contacto_institucion"  style="width:180px; font-size:14px" value="<?=$rowTL->contacto_institucion?>"></td>
          </tr>
          <tr>
            <td><font size="2" style="font-size:11px">Pais</font></td>
            <td>
            	<select name="contacto_pais">
                	<option value=""></option>
                    <?php
						$getPaises = $trabajos->getPaises();
						while($rowPais = mysql_fetch_array($getPaises))
						{
							if($rowPais["ID_Paises"]==$rowTL->contacto_pais)
								$chkp = "selected";
							echo "<option value='".$rowPais["ID_Paises"]."' $chkp>".$rowPais["Pais"]."</option>";
							$chkp = "";
						}
					?>
                </select></td>
            <td align="right"><font size="2" style="font-size:11px">Ciudad</font></td>
            <td><input name="contacto_ciudad" type="text" class="camposTL" id="contacto_ciudad"  style="width:180px; font-size:14px" value="<?=$rowTL->contacto_ciudad?>"></td>
          </tr>
          <tr>
            <td width="125"><font size="2" style="font-size:11px">Area:</font></td>
            <td colspan="3">
          
		   <select name="area_" class="camposTL" id="area_" style="width:400;">
           		<option value=""></option>
           		<?php
					$areas = $trabajos->areas();
					while($row = mysql_fetch_object($areas)){
						if($rowTL->area_tl==$row->id){
							$chkA = "selected";
						}
						echo "<option value='$row->id' $chkA>$row->Area</option>";
						$chkA = "";
					}
				?>
		   </select>
           <a href="javascript:agregar('altaAreaTL.php', '80')" class="linkAgregar">Agregar &aacute;rea</a></td>
          </tr>
          <tr>
            <td width="125"><font size="2" style="font-size:11px">Ubicarlo en la actividad: </font></td>
            <td colspan="3"><font color="#333333" size="2">
              <select name="ID_casillero" class="camposTL" id="select2"  style="width:400;">
                <option value=""  style="background-color:#999999; color:#FF0000;" selected>Sin Ubicaci&oacute;n</option>
                <?php
				    $sql ="SELECT * FROM congreso WHERE Trabajo_libre = 1 ORDER BY Casillero ASC;";
					$rs = mysql_query($sql,$con);
					while ($row = mysql_fetch_array($rs)){

				  ?>
                <option value="<?=$row["Casillero"]?>" <?=($rowTL->ID_casillero==$row["Casillero"]?"selected":"")?>>
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
              <font color="#333333" size="2"><font color="#990000"><a href="#"></a></font></font></font></td>
          </tr>
          <tr>
            <td><font size="2" style="font-size:11px">Hora inicio a Hora fin </font></td>
            <td colspan="3"><font size="2" style="font-size:11px">
              <select name="hora_inicio_" class="camposTL" id="hora_inicio_" <?=($rowTL->Hora_inicio=="00:00:00" or $id_trabajo=="")?"disabled":""?>>
              	<?php
					$horas = $trabajos->horas();
					while($row = mysql_fetch_object($horas)){
						if($rowTL->Hora_inicio==$row->Hora){
							$chkH = "selected";
						}
						echo "<option value='$row->Hora' $chkH>$row->Hora</option>";
						$chkH = "";
					}
				?>
                </select>
              a 
              <select name="hora_fin_" class="camposTL" id="hora_fin_" <?=($rowTL->Hora_fin=="00:00:00" or $id_trabajo=="")?"disabled":""?>>
              <?php
					$horas2 = $trabajos->horas();
					while($row = mysql_fetch_object($horas2)){
						if($rowTL->Hora_fin==$row->Hora){
							$chkH2 = "selected";
						}
						echo "<option value='$row->Hora' $chkH2>$row->Hora</option>";
						$chkH2 = "";
					}
				?>
                </select>
              </font> <font size="2">&nbsp;<a href="altaHora.php?sola=1" class="linkAgregar popup">Agregar horario</a></font><font size="2">
                <label for="chkSinHora" style="cursor:pointer">
                  <input name="chkSinHora" type="checkbox" onClick="SinHoras()" id="chkSinHora" <?=($rowTL->Hora_inicio=="00:00:00" or $id_trabajo=="")?"checked":""?>>
                  Sin horario</label>
                </font></td>
          </tr>
          <tr>
            <td colspan="4" valign="top" id="comentariosEvaluador"><textarea style="width:350px; height:50px; display:none" name="comentarios_admin"></textarea></td>
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
              <td colspan="2"><div align="left"><font size="2"><em>Title abstract</em></font>
                  <input name="titulo_TL" type="text" class="camposTL" id="titulo_TL"  style="width:750px;" value="<?=$rowTL->titulo_tl?>">
              </div></td>
	        </tr>
		    <tr>
		      <td height="22" colspan="2" valign="top">
			  	   <div align="left"><font size="2"><em>Autores e instituciones</em></font></div>
				    <div id="divCoautores">
          <?


					
					$_SESSION["id"] = $_GET["id"]
				?>
				
<?php

if($id_trabajo!=""){
		$sql2 ="SELECT * FROM trabajos_libres_participantes WHERE ID_trabajos_libres = $id_trabajo ORDER BY ID ASC;";
        $rs2 = mysql_query($sql2,$con);
		$cants2 = mysql_num_rows($rs2);
		while ($row2[] = mysql_fetch_array($rs2));
		$nuevo_tl = "0";
}else{
	$cants2 = 3;
}
if($cants2==0){
	$nuevo_tl = "1";
	$cants2 = 3;
}



    /*    echo "<pre>";
					var_dump($row2);
					echo "</pre>";*/

		for($i=1;$i<=$cants2;$i++){
				if($id_trabajo!="" and $nuevo_tl=="0"){
					
					$sql ="SELECT * FROM personas_trabajos_libres WHERE ID_Personas = " . $row2[$i-1]["ID_participante"] ." LIMIT 1;";
				//	echo $sql;
					$rs = mysql_query($sql,$con);
					$rowPers = mysql_fetch_array($rs);
					
					if($rowPers["inscripto"]==1){

						$ins ="<img src=img/puntoVerde.png />";
					
					}else{
					
						$ins ="";
						
					}
					$ciclo = $i-1;
					
					if(!empty($rowPers["Pais"]))
					{
						$getPais = mysql_query("SELECT * FROM paises WHERE ID_Paises='".$rowPers["Pais"]."'",$con);
						$rowPais = mysql_fetch_array($getPais);
					}
					
					if(!empty($rowPers["Institucion"]))
					{
						$getInstitucion = mysql_query("SELECT * FROM instituciones WHERE ID_Instituciones='".$rowPers["Institucion"]."'",$con);
						$rowInstitucion = mysql_fetch_array($getInstitucion);
					}
					
					$persona = "  <font size=2><strong>" . $rowPers["Apellidos"] . ", " . $rowPers["Nombre"] . "</strong> (" . $rowPais["Pais"] . ") - " . $rowInstitucion["Institucion"] . "</font> <a href=\"javascript:cargar_persona_buscada('$ciclo', '', '')\" class='tipsy' title='Quitar esta persona'><img src='imagenes/quitar.png' width='10'></a>"; 
					
				}else{
					$rowPers = array();
				}
				
					

		if ($colorfila == 0){
			//$color= "#9DD0B8";
			$colorfila=1;
			echo "<script> var colorfila=1; </script>\n";
			
		}else{
		//	$color="#D9ECE2";
			$colorfila=0;
			echo "<script> var colorfila = 0; </script>\n";
		}	
		
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
						 <div id="txt_persona_<?=($i-1)?>" style=" margin-bottom:4px; "><?=$persona?></div>
						
						 <input name="persona[]" type="hidden" value="<?=$row2[$i-1]["ID_participante"]?>" />

						 <input name="persona_<?=($i-1)?>" type="text" class="camposTL personasTLInput" id="persona_<?=($i-1)?>"   style="width:250; color:#999999;"  onKeyUp="buscando_personas('persona<?=($i-1)?>', this.value, <?=($i-1)?>, 'persona_<?=($i-1)?>')" placeholder="Buscar autor por su apellido en la base de datos">
						 <a href="altaPersonasTL.php?combo=<?=($i-1)?>&sola=1" data-rel="<? echo ($i-1); ?>" class="linkAgregar tipsy popup" style="font-size:11px; font-weight:normal;" title="Agregar una nueva persona en la base de datos"><img src='imagenes/add_person.png' width="20" border="0" align="absbottom"></a></div>
						 <div id='persona<?=($i-1)?>'></div>						 </td>
                    <td width="95" valign="top"><font size="2">
                      <input name="lee_[<?=($i-1)?>]" type="checkbox" id="lee_[]" <?=($row2[$i-1]["lee"]==1)?"checked":""?> value="1" />
                    presentador                    </font></td>
                  </tr>
                </table>              </td>
            </tr>
          </table>
	      <input name="lee[]" type="hidden" value="<?=$row2[$i-1]["lee"]?>" />
          
		  
  <?

 }
?>
        </div>
					<div align="right" style="margin-top:5px;"><font size="2"> <a name="fin"></a><a href="#fin" class="linkAgregar" style="font-weight:normal;" onClick="agregarCoAutores()">[+] Agregar m&aacute;s Co-autores </a></font></div></td>
	        </tr>
		    <tr>
              <td height="22" colspan="2" valign="top"><font size="2"><strong>Resumen</strong>:</font>
                <textarea name="resumen" rows="5"  class="camposTL" id="resumen" style="width:100%;"><?php
                $resumen = $rowTL->resumen;
				$resumen = preg_replace ("/\r?\n|\r/"," ",$resumen);
				$resumen = preg_replace('/(\s)+/', ' ', $resumen);
				echo $resumen;
				?></textarea></td>
	        </tr>
		    <tr>
		      <td height="22" colspan="2" id="cantWords3" align="right">&nbsp;</td>
		      </tr>
		    <tr>
		      <td height="22" colspan="2" id="cantWords2" align="left"><font size="2"><strong>Abstract</strong>:</font>
                <textarea name="resumen_en" rows="5"  class="camposTL" id="resumen_en" style="width:100%;"><?php
                $resumen_en = $rowTL->resumen_en;
				$resumen_en = preg_replace ("/\r?\n|\r/"," ",$resumen_en);
				$resumen_en = preg_replace('/(\s)+/', ' ', $resumen_en);
				echo $resumen_en;
				?>
                </textarea></td>
		      </tr>
		    <tr>
		      <td height="22" colspan="2" id="cantWords" align="right">&nbsp;</td>
		      </tr> 
		    <tr>
		      <td width="97" height="22"><font size="2">Palabras Clave :</font></td>
		      <td width="651"><input name="palabrasClave_TL" type="text" class="camposTL" id="palabrasClave_TL" value="<?=$rowTL->palabrasClave?>"  style="width:450;" />
		        <font color="#990000" size="1">(Separe las palabras con una coma)</font></td>
		      </tr>
          </table>
		  </div>
	    </div>
<div style="background-color:#EDD2A8; border:solid 1px #666666; padding:5px; margin:5px;" align="right">
<div>&nbsp;<font color="#DB9B34"><em><strong><font size="3" face="Georgia, Times New Roman, Times, serif">Evaluadores</font></strong></em><font size="3"> </font></font>&nbsp;<a href="#" id="link_evaluadores" style="font-weight:normal;">mostrar/oculta</a></div>
<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size:12px" id="tabla_evaluadores">
<tr>
				       <td bgcolor="#EDD2A8">Nombre evaluador</td>
				       <td bgcolor="#EDD2A8">Originalidad</td>
				       <td bgcolor="#EDD2A8">Pertinencia<br>
			           Relevancia</td>
				       <td bgcolor="#EDD2A8">Claridad, <br>
			           Prec y
rig</td>
				       <td bgcolor="#EDD2A8">Bibliog.</td>
				       <td bgcolor="#EDD2A8">Total</td>
				       <td bgcolor="#EDD2A8">Fecha del Fallo</td>
				       <td bgcolor="#EDD2A8"><p>Aceptado<br>
				         Recahzado
				       </p></td>
	        </tr>
<?php
	$bgI = "#FFEAC9";
			$cantidad_eval = 0;
			while($rowEval = @mysql_fetch_object($queryEval)){
				if($bgI=="#FFEAC9"){
					$bgI = "#FFF3E0";
				}else{
					$bgI = "#FFEAC9";
				}
				$comments = preg_replace('[\n|\r|\n\r]', '', trim($rowEval->ecomentarios));
				
					if($rowEval->nivel==2){
						$total += ($rowEval->nota1+$rowEval->nota2+$rowEval->nota3+$rowEval->nota4);
?>						
				     
				     <tr bgcolor="<?=$bgI?>">
				       <td nowrap><?=$rowEval->nombre?></td>
				       <td><?=$rowEval->nota1?></td>
				       <td><?=$rowEval->nota2?></td>
				       <td><?=$rowEval->nota3?></td>
				       <td><?=$rowEval->nota4?></td>
				       <td><?=($rowEval->nota1+$rowEval->nota2+$rowEval->nota3+$rowEval->nota4)?></td>
				       <td><?=$rowEval->fecha?></td>
				       <td><?=$rowEval->estadoEvaluacion?></td>
	        </tr>
				     <tr bgcolor="<?=$bgI?>">
				       <td colspan="8"><div style="max-height:50px;overflow:hidden" class="cmt_evaluador"><?=$comments?></div>
                       </td>
			         </tr>
					
<?               $cantidad_eval++;
				}
				$evl = $rowEval->nombre;
			}
		?>
<tr>
  <td colspan="4" bgcolor="#EDD2A8"><font size="2" style="font-size:11px">Estado del  trabajo y fallo final:</font> &nbsp;<font color="#333333" size="2">
    <select name="estado_de_TL" class="camposTL" id="estado_de_TL"  style="width:180px;">
      <option value="0" selected style="background-color:#FFCACA;">Recibidos</option>
      <option value="1" style="background-color:#79DEFF;" <?=($rowTL->estado==1?"selected":"")?>>En revisi&oacute;n</option>
      <option value="2" style="background-color:#82E180;" <?=($rowTL->estado==2?"selected":"")?>>Aprobados</option>
      <option value="4" style="background-color:#E074DD;" <?=($rowTL->estado==4?"selected":"")?>>Notificados</option>
      <option value="3" style="background-color:#999999;" <?=($rowTL->estado==3?"selected":"")?>>Rechazados</option>
      </select>
  </font></td>
  <td colspan="2" bgcolor="#EDD2A8">Promedio<strong style="font-size:14px;">&nbsp;&nbsp;
    <? if($total>0)echo($total*100)/($cantidad_eval*100) ?> 
    %</strong></td>
  <td colspan="2" align="center" bgcolor="#EDD2A8"><a href="#" id="<?=$id_trabajo?>" class="evl_mail">Enviar aceptaci&oacute;n</a></td>
  </tr>
</table>
</div>		
<div style="background-color:#FFCBCA; border:solid 1px #666666; padding:5px; margin:5px;">
<div>
  <div align="right"><font color="#ABD1F8"><em><strong><font color="#FF9693" size="3" face="Georgia, Times New Roman, Times, serif">Fecha de envios de emails</font></strong></em><font size="3">&nbsp; </font></font>
    <!--<a href="javascript:abrir_cerrar_div('TL2')" class="linkAgregar" style="font-weight:normal;">mostrar/ocultar</a>-->
  </div>
</div>
<?php
	$sqlCartas = "SELECT * FROM trabajos_libres WHERE numero_tl='$row1->numero_tl'";
		$queryCartas = mysql_query($sqlCartas,$con);
		$rowCartas = mysql_fetch_object($queryCartas);
		$cartEnviadas = explode("[",$rowCartas->cartasEnviadas);
		$cartEnviadas = str_replace("]","",$cartEnviadas);
		echo "<font size=-3>$rowCartas->cartasEnviadas</font>";
?>
</div>
<div style="background-color:#FFCBCA; border:solid 1px #666666; padding:5px; margin:5px;">
  <div>
    <div align="right"><font color="#ABD1F8"><em><strong><font color="#FF9693" size="3" face="Georgia, Times New Roman, Times, serif">Fecha del envio de la aceptaci&oacute;n</font></strong></em><font size="3">&nbsp; </font></font>
      <!--<a href="javascript:abrir_cerrar_div('TL2')" class="linkAgregar" style="font-weight:normal;">mostrar/ocultar</a>-->
    </div>
  </div>
<?php
		$sqlCartas = "SELECT * FROM trabajos_libres WHERE numero_tl='$row1->numero_tl'";
		$queryCartas = mysql_query($sqlCartas,$con) or die(mysql_error());
		$rowCartas = mysql_fetch_object($queryCartas);
		$cartEnviadas = explode("[",$rowCartas->cartas_aceptacion);
		$cartEnviadas = str_replace("]","",$cartEnviadas);
		echo "<font size=-3>$rowCartas->cartas_aceptacion</font>";
?>
</div>
		<div style="background-color:#FFCBCA; border:solid 1px #666666; padding:5px; margin:5px;">
 <div>
	    <div align="right"><font color="#ABD1F8"><em><strong><font color="#FF9693" size="3" face="Georgia, Times New Roman, Times, serif">Archivo</font></strong></em><font size="3">&nbsp; </font></font><!--<a href="javascript:abrir_cerrar_div('TL2')" class="linkAgregar" style="font-weight:normal;">mostrar/ocultar</a>--></div>
	  </div>
      <?
	  	if($_GET["id"]!=""){
		 	 $lista = $trabajos->selectTL_ID($_GET["id"]);
			 while ($row1 = mysql_fetch_object($lista)){
			 	//$existeTrabajo = $row1->archivo_tl;
				$tabla_trabajo_comleto = $row1->archivo_tl;
				$resumen_ampliado  = $row1->archivo_tl_ampliado;
				
				$oral_tl = $row1->oral_tl;
				$poster_tl = $row1->poster_tl;
			
				
			 }
		 }
	  ?>
      <div id="tabla" style="font-size:13px"><!--Resumen ampliado<?php
	  ?>
        <input type="file" name="archivo_tl_ampliado">
      <?
	  	if($resumen_ampliado!=""){
			echo " <strong>- Ya existe un resumen ampliado para este trabajo <a href='tl_ampliado/$resumen_ampliado' target='_blank'>(ver resumen ampliado)</a></strong>";
		}
	  ?>
        <br>
        <br>-->
        Trabajo completo
        <?php
	  ?>
        <input type="file" name="archivo_tl">
      <?
	  	if($tabla_trabajo_comleto!=""){
	  		echo " <strong>- Ya existe un trabajo completo <a href='tl/$tabla_trabajo_comleto' target='_blank'>(ver trabajo completo)</a></strong>";
	  	}
	  ?>
      </div>
	<div id="TL2" style="display:none">
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
				
				$estado_tl = $row1->estado;
			
				
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
				 
		 <input name="viejoActualizacion" type="hidden" value="<?=$viejoActualizacion?>">
         <input name="estado_trabajo_libre" type="hidden" value="<?=$estado_tl?>">
		 
		 
		 
		 
		 
 <input name="id_trabajo" type="hidden" value="<?=$_GET["id"]?>">
 <input name="archivo_tl_ampliado_viejo" type="hidden" value="<?=$resumen_ampliado?>">
 <input name="archivo_tl_viejo" type="hidden" value="<?=$tabla_trabajo_comleto ?>">
    </form>    </td>
  </tr>
</table>
<script>

	/*llenarHoras();
	llenarPersonas();

	llenarTipoTL();
	llenarAreas();*/
	
	SinHoras();
</script>


<script language="javascript">
function SinHoras(){
if(form1.chkSinHora.checked == true)
	{	
	form1.hora_inicio_.disabled = true;
	form1.hora_fin_.disabled = true;
	}
else{	
	form1.hora_inicio_.disabled = false;
	form1.hora_fin_.disabled = false;
	}
}
function calcWords(){ 
	var sTx = document.form1["resumen"].value;
		sTx += " "+document.form1["resumen2"].value;
		sTx += " "+document.form1["resumen3"].value;
		sTx += " "+document.form1["resumen4"].value;
	//	sTx += " "+document.form1["referencias_resumen"].value;
		
		sTxt = sTx.split("<br />").join(" ");
	var sTx2 = ""; 
	var sSep = " "; 
	var iRes = 0; 
	var bPalabra = false; 
	for (var j = 0; j < sTxt.length; j++){ 
	 if (sSep.indexOf(sTxt.charAt(j)) != -1){ 
	  if (bPalabra) sTx2 += " "; 
	  bPalabra = false; 
	 } else { 
	  bPalabra = true; 
	  sTx2 += sTxt.charAt(j); 
	 } 
	} 
	if (sTx2.charAt(sTx2.length - 1) != " ") sTx2 += " "; 
	for (var j = 0; j < sTx2.length; j++) 
	 if (sTx2.charAt(j) == " ") iRes++; 
	if (sTx2.length == 1) iRes = 0; 
	document.getElementById("cantWords").innerHTML = "Palabras: <strong>" + String(iRes)+"</strong>"; 
} 
//calcWords();
</script>