<?
include('inc/sesion.inc.php');
require('conexion.php');
$bts = "bootstrap.min.css";
?>

<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilo_fondo.css" rel="stylesheet" type="text/css">
<link href="bootstrap/css/<?=$bts?>" rel="stylesheet" type="text/css">
<link type="text/css" href="editor/estilosInstantEdit.css" rel="stylesheet">
<link type="text/css" href="font_awesome/css/font-awesome.min.css" rel="stylesheet">
<link type="text/css" href="css/build.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $( "#sortable" ).sortable({
		placeholder: "ui-state-highlight"
	});
	$( "#sortable" ).disableSelection();
});
</script>
<?
$cantidadTrabajos =2;

$titulo = "Alta";
$inputs = "text";
if($_GET["id_casillero"]!=""){
	$casilleroViejo=$_GET["id_casillero"];
	
	$sqlModificacion = "select * from congreso where Casillero='$casilleroViejo' order by Casillero, Orden_aparicion asc";
	$rsModificacion = mysql_query($sqlModificacion, $con);
	$rs = mysql_query($sqlModificacion, $con);
	$titulo = "Modificar";

	while($row = mysql_fetch_array($rs)){
		if($row["sala_agrupada"]!=0){
			$casilleroViejo=$row["sala_agrupada"];
		}
	}
	$rsModificacion = mysql_query($sqlModificacion, $con);
	$rs = mysql_query($sqlModificacion, $con);
	$cantConfs = mysql_num_rows($rs);
	$rows = mysql_fetch_array($rs);
	
	$sqlConf = "select * from congreso where Casillero='$casilleroViejo' AND Nombre<>'' order by Casillero, Orden_aparicion asc";
	$rsConf = mysql_query($sqlConf, $con);
	if(mysql_num_rows($rsConf)>0){
		$cantidadTrabajos = mysql_num_rows($rsConf);
	}
	
}

?>


<script type="text/javascript">
cantTrab = <?=$cantidadTrabajos?>;
function agregarItem(cual_, txt, valor, param3){
	var oOption = document.createElement("OPTION");

	oOption.text = txt;

	oOption.value = valor;

	if(param3!=undefined){
		if(param3.substring(0,1) == "#"){
			oOption.style.background = param3;
		}else{
			oOption.style.background = "url('img/patrones/"+param3+"')";
		}
	}

	cual_.options.add(oOption);
}
</script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/casillero.js"></script>
<script src="js/ajax.js"></script>
<script src="js/horas.js"></script>
<script src="js/dias.js"></script>
<script src="js/salas.js"></script>
<script src="js/areas.js"></script>
<script src="js/tematicas.js"></script>
<script src="js/tipo_de_actividad.js"></script>
<script src="js/en_calidades.js"></script>
<script src="js/personas.js"></script>

<?

require("clases/arraysCasillero.php");


$cargarArray = new casillero();
$cargarArray->personas();
//$cargarArray->actividades();
?>
<? include "inc/vinculos.inc.php";?>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<ul id="sortable">
<li class="ui-state-default">Item 1</li>
<li class="ui-state-default">Item 2</li>
<li class="ui-state-default">Item 3</li>
<li class="ui-state-default">Item 4</li>
<li class="ui-state-default">Item 5</li>
<li class="ui-state-default">Item 6</li>
<li class="ui-state-default">Item 7</li>
</ul><br>
<br>
<form action="altaCasilleroEnviar.php" name="form1" method="post">
<input name="casilleroViejo" type="hidden" value="<?=$casilleroViejo?>">
<div class="container panel-group" id="accordion">
	<div class="panel panel-warning">
                      <div class="panel-heading accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="cursor:pointer">
                      	<div class="row">
                        	<div class="col-xs-12">
                                <div class="pull-left">
                                    <h3 class="panel-title"><a href="#">Ubicaci&oacute;n</a></h3>
                                </div>
                                <div class="pull-right text-right" style="margin-right:10px;margin-top:5px;">
                                    <input name="Submit2" type="button" class="btn btn-primary btn-sm" value="GUARDAR" onClick="validar();" >
                                </div>
                             </div>
                        </div>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse in">
                          <div class="panel-body">
                            <div class="row body-ubicacion">
                                <div class="col-xs-3">
                                    <label>Dia</label>
                                    <select name="dia_" id="dia_" class="form-control" size="5">
                                    	<?php
											$getDias = $cargarArray->dias();
											while($row = mysql_fetch_array($getDias)){
												if($row["Dia_orden"]==$rows["Dia_orden"]){
													$chkD = "selected";													
												}
												echo '<option value="'.$row["Dia"].'" '.$chkD.'>'.$row["Dia_orden"].' - '.$row["Dia"].'</option>';
												$chkD = "";	
											}
										?>
                                    </select>
                                    <a href="javascript:agregar('altaDiaNuevo.php', '153')"  class="linkAgregar">Agregar d&iacute;a</a>
                                </div>
                                <div class="col-xs-4">
                                    <label>Sala</label>
                                    <select name="sala_[]" size="5" multiple id="sala_[]" class="form-control" onChange="activarAgruparSalas();">
                                    	<?php
											$getSalas = $cargarArray->salas();										
											while($row = mysql_fetch_array($getSalas)){
												$ID_SalaAgrupada = 0;
												if($rows["sala_agrupada"]!=0){
													$ID_SalaAgrupada = $rows["sala_agrupada"];
												}
												$SalaSQL = "SELECT Dia_orden,Sala,Sala_orden,Hora_inicio,sala_agrupada FROM congreso WHERE Dia_orden='".$rows["Dia_orden"]."' and Hora_inicio = '".$rows["Hora_inicio"]."' AND Sala_orden='".$row["Sala_orden"]."' and sala_agrupada='$ID_SalaAgrupada';";
												$rsSalas = mysql_query($SalaSQL, $con);
												while($rowS = mysql_fetch_array($rsSalas)){
													if($row["Sala_orden"]==$rowS["Sala_orden"]){
														$chkS = "selected";													
													}
												}
												echo '<option value="'.$row["Sala"].'" '.$chkS.'>'.$row["Sala_orden"].' - '.$row["Sala"].'</option>';
												$chkS = "";
											}
										?>
                                    </select>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="pull-left" id="divAgruparDala">
                                             <div class="checkbox checkbox-primary">
                                                <input name="agruparSalas" type="checkbox" id="agruparSalas" value="1" <? if($rows["sala_agrupada"]!=0){echo "checked";} ?>>
                                                <label for="agruparSalas">
                                                    Agrupar salas
                                                </label>
                                             </div>
                                            </div>
                                            <div class="pull-right text-right">
                                             <a href="javascript:agregar('altaSalaNuevo.php', '187')"  class="linkAgregar">Agregar sala</a>		
                                         </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-2">
                                        <label>Hora inicio</label>
                                        <select name="hora_inicio_" id="hora_inicio_" class="form-control" size="5">
                                        	<?php
												$getHoraInicio = $cargarArray->horas();
												while($row = mysql_fetch_array($getHoraInicio)){
												if($row["Hora"]==$rows["Hora_inicio"]){
													$chkHI = "selected";													
												}	
													echo '<option value="'.$row["Hora"].'" '.$chkHI.'>'.substr($row["Hora"],0,-3).'</option>';
													$chkHI = "";
												}
											?>
                                        </select>
                                    </div>
                                    <div class="col-xs-2">
                                        <label>Hora fin</label>
                                        <select name="hora_fin_" id="hora_fin_" class="form-control" size="5">
                                        	<?php
												$getHoraFin = $cargarArray->horas();
												while($row = mysql_fetch_array($getHoraFin)){
												if($row["Hora"]==$rows["Hora_fin"]){
													$chkHF = "selected";													
												}	
													echo '<option value="'.$row["Hora"].'" '.$chkHF.'>'.substr($row["Hora"],0,-3).'</option>';
													$chkHF = "";
												}
											?>

                                        </select>
                                      <div class="text-right">
                                        <a href="javascript:agregar('altaHoraNuevo.php', '50')"  class="linkAgregar">Agregar horario</a>
                                        </div>
                                    </div>
                                  </div>
                              </div>    
                              
                              
                              <div class="row">
                                <div class="col-xs-11">
                                    <div class="text-right">
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" id="trabajo_libre_" name="trabajo_libre_" value="1" <? if($rows["Trabajo_libre"]){echo "checked";} ?>>
                                            <label for="trabajo_libre_">Este Casillero tendr&aacute; trabajos libres?</label>
                                        </div>    
                                    </div>
                                </div>
                             </div>
                                                  
                           </div>
                        </div>   
                    </div>
    
    
    <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Datos de la Actividad</a></h3>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <label>Seleccione un Tipo de actividad</label>
                                <select name="tipo_de_actividad_"  id="tipo_de_actividad_" class="form-control">
                                	<option value=""></option>
                                	<?php
										$getTipoActividad = $cargarArray->tipoDeActividades();
										while($row = mysql_fetch_array($getTipoActividad)){
											if($row["Tipo_de_actividad"]==$rows["Tipo_de_actividad"]){
												$chkTa = "selected";
											}
											$bg = "";
											if(strpos($row["Color_de_actividad"],"#") === false){
												$bg = "style='background:url(img/patrones/".$row["Color_de_actividad"].")'";
											}else{
												$bg = "style='background-color:".$row["Color_de_actividad"]."'";
											}
											echo '<option value="'.$row["Tipo_de_actividad"].'" '.$chkTa.' '.$bg.'>'.$row["Tipo_de_actividad"].'</option>';
											$chkTa = "";
										}
									?>
                                </select>
                                <a href="javascript:agregar('altaActividadNuevo.php', '490')" class="linkAgregar">Agregar un nuevo tipo de actividad</a>
                            </div>
                            <div class="col-xs-4">
                                <label>&Aacute;rea</label>
                                <select name="area_" id="area_" class="form-control">
                                	<option value=""></option>
                                	<?php
										$getAreas = $cargarArray->areas();
										while($row = mysql_fetch_array($getAreas)){
											if($row["Area"]==$rows["Area"]){
												$chkA = "selected";
											}
											echo '<option value="'.$row["Area"].'" '.$chkA.'>'.$row["Area"].'</option>';
											$chkA = "";
										}
									?>
                                </select>
                                <a href="javascript:agregar('altaAreaNuevo.php', '155')" class="linkAgregar">Agregar &aacute;rea</a>
                            </div>
                            <div class="col-xs-4">
                                <label>Tem&aacute;tica</label>
                                <select name="tematica_" id="tematica_" class="form-control">
                                	<option value=""></option>
                                	<?php
										$getTematicas = $cargarArray->tematicas();
										while($row = mysql_fetch_array($getTematicas)){
											if($row["Tematica"]==$rows["Tematica"]){
												$chkT = "selected";
											}
											echo '<option value="'.$row["Tematica"].'" '.$chkT.'>'.$row["Tematica"].'</option>';
											$chkT = "";
										}
									?>
                                </select>
                                <a href="javascript:agregar('altaTematicaNuevo.php', '50')" class="linkAgregar">Agregar tem&aacute;tica</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12" style="margin-top:20px;">
                                <label>Ingrese el T&iacute;tulo de la Actividad</label>
                                <input name="titulo_de_actividad_" id="titulo_de_actividad_" type="<?=$inputs?>" class="form-control" value="<?=$rows["Titulo_de_actividad"]?>">
                            </div>
                            <div class="col-xs-12" style="margin-top:10px;">
                                <label>Ingrese el T&iacute;tulo de la Actividad en ingl&eacute;s</label>
                                <input name="titulo_de_actividad_ing" id="titulo_de_actividad_ing" type="<?=$inputs?>"  onClick="borrarTexto(this.id, this.value,'')" value="<?=$rows["Titulo_de_actividad_ing"]?>" class="form-control">
                            </div>
                        </div>
                      </div>
                   	</div>
                </div>
    
    	
        
        
        <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Conferencistas</a></h3>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                      <div class="panel-body" id="nuevas_ponencias">
                        
                              <?
                                for($i=1;$i<=$cantidadTrabajos;$i++){
									if($casilleroViejo!=""){
										$conf = mysql_fetch_array($rsConf);
									}
                                ?>
                              <!-- cargados en actividad -->
                              <input name="mostrarOPC[]" type="hidden" id="mostrarOPC[]" value="" />
                              <input name="participa[]" type="hidden" id="participa[]" value="" />
                              <input name="archivoPonencia[]" type="hidden" id="archivoPonencia[]" value="" />
                              <input name="confirmado[]" type="hidden" id="confirmado[]" value="" />
                              <input name="comentarios[]" type="hidden" id="comentarios[]" value="" />
                              <input name="desdeSistema[]" type="hidden" id="desdeSistema[]" value="" />
                              
                                          
                                <div class="divTrabajos" style="background-color:<?=$color?>; padding:20px; padding-bottom:0px; margin-bottom:12px;">
                                <div class="row">
                                    <div class="col-xs-12">
                                         <label>Ingrese el Título de la Ponencia</label>
                                         <input name="trabajo[]" id="trabajo[]" class="form-control" onClick="borrarTexto(this.id, this.value, '<?=$i-1?>')" value="<?=$rows["Titulo_de_trabajo"]?>">
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-top:12px;">
                                    <div class="col-xs-12">
                                         <label>Ingrese el Título de la Ponencia en ingl&eacute;s</label>
                                         <input name="trabajo_ing[]" id="trabajo_ing[]" class="form-control input-sm"  value="<?=$rows["Titulo_de_trabajo_ing"]?>">
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-top:12px;">
                                    <div class="col-xs-4">
                                        <label>Seleccione la Calidad/rol</label>
                                        <select name="en_calidad[]" id="en_calidad[]" class="form-control input-sm en_calidad">
                                        	<option value=""></option>
                                        	<?php
											$getEnCalidades = $cargarArray->enCalidades();
											while($row = mysql_fetch_array($getEnCalidades)){
												if($row["En_calidad"]==$rows["En_calidad"]){
													$chkEC = "selected";
												}
												echo '<option value="'.$row["En_calidad"].'" '.$chkEC.'>'.$row["En_calidad"].'</option>';
												$chkEC = "";
											}
											?>
                                        </select>
                                        <a href="javascript:agregar('altaCalidadNuevo.php', '150', <?=$i-1?>)"  class="linkAgregar">Agregar calidad/rol</a>
                                    </div>
                                    
                                    <?
										if($conf["Apellidos"]!=""){
                                    		$conferencista = "<strong>".$conf["Apellidos"].", ".$conf["Nombre"]."</strong>";										
										}
										if($conf["Pais"]!=""){
											$conferencista .= "(".$conf["Pais"].")";
										}
										if($conf["Pais"]!=""){
											$conferencista .= " - ".$conf["Institucion"];
										}
									?>
                                    
                                    <div class="col-xs-8">
                                        <label>Buscar conferencista</label>
                                        	<div id="txt_persona_<?=$i-1?>" class="col-xs-12" style="font-size:11px;"><?=$conferencista?></div>
                                            <input name="persona_<?=$i-1?>" type="text" id="persona_<?=($i-1)?>" class="form-control input-sm" onKeyUp="buscando_personasCongreso('persona<?=$i-1?>', this.value, <?=$i-1?>, 'persona_<?=$i-1?>')" onClick="this.value=''" value="Buscar participante por su apellido, en la base de datos...">
                                              <input name="persona[]" id="persona[]" type="hidden" value="<?=$conf["ID_persona"]?>"> 
                                            <a href="javascript:agregar('altaPersonas.php', '350' , <?=$i-1?>)"  class="linkAgregar">Agregar persona</a> 
                                            <div id='persona<?=$i-1?>'></div>
                                                   
                                        
                                    </div>
                                </div>
                                                            
                                <div class="row" style="margin-top:12px;">
                                    <div class="col-xs-12">
                                        <label>Resumen de la ponencia</label>
                                         <textarea type="text" name="observaciones[]" id="observaciones[]" class="form-control input-sm"><?=$conf["observaciones"]?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-right">
                                         <div class="checkbox checkbox-primary">
                                            <input name="crono[]" type="checkbox" id="crono<?=$i?>" value="1" <? if($conf["en_crono"]){echo "checked";} ?> />
                                            <label for="crono<?=$i?>">
                                                En cronograma
                                            </label>
                                         </div>
                                    </div>
                                </div>
                              
                            <input name="en_crono[]" type="hidden">
                             <div style="border-bottom:4px solid;"></div>
                            </div>
                           
                              <?
                 }
                ?>
                
                      </div>
                  
                      <div class="panel-footer">
                        <div class="text-right">
                            <button type="button" class="btn btn-default" onClick="agregarTrabajo()">Agregar m&aacute;s conferencistas</button>
                        </div>
                      </div>
                    </div>  
                </div>
</div>
</form>
<script src="js/trabajos.js"></script>
<script id="confsClone" type="text/template">
<!-- cargados en actividad -->
<input name="mostrarOPC[]" type="hidden" id="mostrarOPC[]" value="" />
<input name="participa[]" type="hidden" id="participa[]" value="" />
<input name="archivoPonencia[]" type="hidden" id="archivoPonencia[]" value="" />
<input name="confirmado[]" type="hidden" id="confirmado[]" value="" />
<input name="comentarios[]" type="hidden" id="comentarios[]" value="" />
<input name="desdeSistema[]" type="hidden" id="desdeSistema[]" value="" />

		  
<div class="divTrabajos divTrabajos_tempalte" style="padding:20px; padding-bottom:0px; margin-bottom:12px;">
<div class="row">
	<div class="col-xs-12">
		 <label>Ingrese el Título de la Ponencia</label>
		 <input name="trabajo[]" id="trabajo[]" class="form-control" onClick="borrarTexto(this.id, this.value, '@@@@')">
	</div>
</div>

<div class="row" style="margin-top:12px;">
	<div class="col-xs-12">
		 <label>Ingrese el Título de la Ponencia en ingl&eacute;s</label>
		 <input name="trabajo_ing[]" id="trabajo_ing[]" class="form-control input-sm">
	</div>
</div>

<div class="row" style="margin-top:12px;">
	<div class="col-xs-4">
		<label>Seleccione la Calidad/rol</label>
		<select name="en_calidad[]" id="en_calidad[]" class="form-control input-sm en_calidad en_calidad_template">
			<option value=""></option>
			<?php
			$getEnCalidades = $cargarArray->enCalidades();
			while($row = mysql_fetch_array($getEnCalidades)){
				if($row["En_calidad"]==$rows["En_calidad"]){
					$chkEC = "selected";
				}
				echo '<option value="'.$row["En_calidad"].'" '.$chkEC.'>'.$row["En_calidad"].'</option>';
				$chkEC = "";
			}
			?>
		</select>
		<a href="javascript:agregar('altaCalidadNuevo.php', '150', @@@@)"  class="linkAgregar">Agregar calidad/rol</a>
	</div>
	
	<div class="col-xs-8">
		<label>Buscar conferencista</label>
			<div id="txt_persona_@@@@" class="col-xs-12" style="font-size:11px;"></div>
			<input name="persona_@@@@" type="text" id="persona_@@@@" class="form-control input-sm" onKeyUp="buscando_personasCongreso('persona@@@@', this.value, @@@@, 'persona_@@@@')" onClick="this.value=''" value="Buscar participante por su apellido, en la base de datos...">
			  <input name="persona[]" id="persona[]" type="hidden"> 
			<a href="javascript:agregar('altaPersonas.php', '350' , @@@@)"  class="linkAgregar">Agregar persona</a> 
			<div id='persona@@@@'></div>
				   
		
	</div>
</div>
							
<div class="row" style="margin-top:12px;">
	<div class="col-xs-12">
		<label>Resumen de la ponencia</label>
		 <textarea type="text" name="observaciones[]" id="observaciones[]" class="form-control input-sm"></textarea>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 text-right">
		 <div class="checkbox checkbox-primary">
			<input name="crono[]" type="checkbox" id="crono@@@@" value="1" />
			<label for="crono@@@@">
				En cronograma
			</label>
		 </div>
	</div>
</div>

<input name="en_crono[]" type="hidden">
<div style="border-bottom:4px solid;"></div>
</div>	
</script>
<script language="javascript">
function PostcargarEnCrono(){
for(u=0; u<=arrayCronos.length-1; u++){	
	if(arrayCronos[u] == "1"){		
		document.form1.elements['crono[]'][u].checked = true
		//document.form1.elements['en_crono[]'][u].value = "1";
	}else{			
		document.form1.elements['crono[]'][u].checked = false
		//document.form1.elements['en_crono[]'][u].value = "0";
	}
}
}
function cargarEnCrono(){
	for(u=0; u<=<?=$cantidadTrabajos?>; u++){	
		
			if($('input[name="crono[]"]:eq('+u+')').is(":checked")){			
				$('input[name="crono[]"]:eq('+u+')').val(1);
			}else{	
				$('input[name="crono[]"]:eq('+u+')').val(0);
			}
			
	}

}


function activarAgruparSalas(param){
	var cuantosSeleccionados = 0;
	
	for(i=0;i<document.form1.elements['sala_[]'].length; i++){
		if(document.form1.elements['sala_[]'][i].selected==true){
			cuantosSeleccionados = cuantosSeleccionados + 1;
		}
	}
	
	if(cuantosSeleccionados>=2){		
		document.getElementById('divAgruparDala').style.visibility = "visible";
		$("#agruparSalas").attr("checked",true);
	}else{
		document.getElementById('divAgruparDala').style.visibility = "hidden";
		$("#agruparSalas").attr("checked",false);
	}
}


function validar(){

	H_inicio = document.form1.hora_inicio_.value.replace(":","")
	H_inicio = H_inicio.replace(":","")
	
	H_fin = document.form1.hora_fin_.value.replace(":","")
	H_fin = H_fin.replace(":","")
	
	titulo = document.form1.titulo_de_actividad_.value;

	titulo_ing = document.form1.titulo_de_actividad_ing.value;

	if(H_fin < H_inicio){ 
		alert("La hora inicio no puede ser mayor a la hora de fin");
		return;
	}else if (H_fin == H_inicio){
		alert("La hora inicio no puede igual a la hora de fin");
		return;
	}else{
		cargarEnCrono();
		form1.submit();
	}

}
</script>
</body>
