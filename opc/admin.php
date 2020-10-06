<?php
session_start();
require("codebase/config.php");
require("class/arraysCasillero.php");
require("class/util.class.php");
$util = new Util();
$util->isLogged();
$cargarArray = new casillero();
?>
<!doctype html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Cronograma</title>

	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>
	<script src="codebase/ext/dhtmlxscheduler_limit.js" type="text/javascript" charset="utf-8"></script>
	<script src="codebase/ext/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
    <script src="codebase/locale/locale_es.js" type="text/javascript" charset="utf-8"></script>
    <script src="codebase/ext/dhtmlxscheduler_url.js" type="text/javascript" charset="utf-8"></script>
    <!--<script src="codebase/ext/dhtmlxscheduler_quick_info.js"></script>-->
    <script src="js/trabajos.js"></script>
    <script src="js/personas.js"></script>
    <script src="js/tl_casillero.js"></script>
    <script src="js/calendario.js"></script>
    <script src="js/base64.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
		$( "#nuevas_ponencias" ).sortable({
			placeholder: "ui-state-highlight"
		});
		
		$( ".div_drop_tl" ).sortable({
			items: ".sortable_tl",
			revert: true,
			sort: function() {
				// gets added unintentionally by droppable interacting with sortable
				// using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
				$(this).removeClass( "ui-state-default" );
			}
		})
		arrayCalidades = [];
		
		<?php
		$getEnCalidades = $cargarArray->enCalidades();
		while($row = $getEnCalidades->fetch()){
		?>		
			arrayCalidades.push({
				id:<?=$row["ID_calidad"]?>,
				calidad:'<?=$row["calidad"]?>'
			})
		<?php
		}
		?>
		
		//arrayTitulosConferencista = [];
		<?php
		/*$getTitulosConferencista = $cargarArray->titulosConferencista();
		while($row = $getTitulosConferencista->fetch()){*/
		?>		
			//arrayTitulosConferencista.push({
			//	id:<?=$row["ID_titulo"]?>,
			//	titulo:'<?=$row["titulo"]?>'
			//})
		<?php
		//}
		?>
		
	})
    </script>
    <script id="confsClone" type="text/template">
		<!-- cargados en actividad -->
		<input name="mostrarOPC[]" type="hidden" id="mostrarOPC[]" value="" />
		<input name="participa[]" type="hidden" id="participa[]" value="" />
		<input name="archivoPonencia[]" type="hidden" id="archivoPonencia[]" value="" />
		<input name="confirmado[]" type="hidden" id="confirmado[]" value="" />
		<input name="comentarios[]" type="hidden" id="comentarios[]" value="" />
		<input name="desdeSistema[]" type="hidden" id="desdeSistema[]" value="" />
		
			
				  
<div class="divTrabajos divTrabajos_tempalte" style="padding:0px 20px; padding-bottom:0px;">
		
		<div class="row">
			<div class="col-xs-10">
				<span class='persona_txt'></span>
				<!-- <a href="javascript:agregar('altaCalidadNuevo.php', '150', @@@@)"  class="linkAgregar">Agregar calidad/rol</a> -->
				<input name="persona[]" id="id_persona_@@@@" type="hidden">
			</div>
            <div class="col-xs-2">
              <img src="imagenes/move.png" width="18" alt="move">&nbsp;&nbsp;
              <img src="imagenes/delete.png" class="deleteConf" data-pos="@@@@" width="24" alt="delete">
             </div>
		</div>	
		
        <div class="conf_options" style="display:none">
            <div class="row">
                <div class="col-xs-11 col-xs-offset-1">
                     <div class="row">
                     <div class="col-xs-3">
                        <label>Calidad/rol</label>				
                        <!--<a href="javascript:popup('index.php?page=calidadCasilleroManager&pos=@@@@',700,150)" class="linkAgregar"><img src="imagenes/plus.jpg" width="28" valgin='middle'  alt=""/></a>-->
	                    <select name="en_calidad_conf[]" id="en_calidad_conf_@@@@" class="en_calidad en_calidad_template">
                          <option value=""></option>
                        </select>
                     </div>
                     <div class="col-xs-9">
                        <label>Título de la Ponencia</label>
						<!--<select name="titulo_conferencista_conf[]" id="titulo_conferencista_conf[]" class="titulo_conferencista">-->
							<!--<option value=""></option>-->
						<!--</select>-->
                        <input name="titulo_conferencista_conf[]" id="titulo_conferencista_conf[]" class="titulo_conferencista" onClick="borrarTexto(this.id, this.value, '@@@@')">
                     </div>
                     
                    </div> 
                </div>
            </div>
            <div class="row" style="margin-top:12px;">
                <div class="col-xs-10 col-xs-offset-1">
                    <label>Resumen de la ponencia</label>
                     <textarea type="text" name="observaciones_conf[]" id="observaciones_conf[]" class="form-control input-sm observaciones_conf"></textarea>
                </div>
            </div>
            <div class="row">
				<div class="col-xs-6 col-xs-offset-1">
                     No mostrar ponencia: <input type="checkbox" name="mostrar_ponencia[]" class="mostrar_ponencia" value="1">
                </div>
                <div class="col-xs-4 text-right">
                     <div class="checkbox checkbox-primary" style="margin-right: 44px;margin-top:4px">
                        <input name="crono[]" class="en_crono" data-pos="@@@@" type="checkbox" id="crono@@@@" value="1" />
                        <label for="crono@@@@" style="padding:0px">
                            En cronograma
                        </label>
                     </div>
                </div>
            </div>
			<input name="en_crono[]" id="en_crono_@@@@" type="hidden" value="0">
        </div>
</div>
		</script>
	
<link rel="stylesheet" href="codebase/dhtmlxscheduler_flat.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="estilos.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="tipo_actividades_css.php" type="text/css" charset="utf-8">
<style type="text/css" media="screen">
	html, body{
		margin:0px;
		padding:0px;
		height:100%;
		overflow:hidden;
	}
	label{
		font-size:12px;
	}
</style>

<script type="text/javascript" charset="utf-8">
	
	function init() {
		
		scheduler.locale.labels.week_unit_tab = "Completo";
		scheduler.locale.labels.single_unit_tab = "Día";
		scheduler.locale.labels.section_custom="Section";
		scheduler.config.details_on_create=true;
		scheduler.config.details_on_dblclick=true;
//		scheduler.config.readonly = true;
		//scheduler.config.touch = "force";
		scheduler.config.xml_date="%Y-%m-%d %H:%i";
		//scheduler.config.auto_end_date = true;
		scheduler.config.first_hour = 7;
		scheduler.config.hour_size_px = 150;
		//scheduler.config.limit_start = new Date(2016,02,09);
		//scheduler.config.limit_end   = new Date(2016,02,12);
		scheduler.templates.event_class=function(start, end, event){
			var css = "";
			if(event.tipo_actividad) // if event has subject property then special class should be assigned
				css += "tipo_actividad_"+event.tipo_actividad;

			if(event.id == scheduler.getState().select_id){
				css += " selected";
			}
			return css; // default return

			/*
				Note that it is possible to create more complex checks
				events with the same properties could have different CSS classes depending on the current view:

				var mode = scheduler.getState().mode;
				if(mode == "day"){
					// custom logic here
				}
				else {
					// custom logic here
				}
			*/
		};
		
		
		
		var salas = scheduler.serverList("salas");
		var	confs = scheduler.serverList("confs");
		var	conferencistas = scheduler.serverList("conferencistas");
		var trabajos_libres_list = scheduler.serverList("trabajos_libres_list");
		var tipos_actividades_list = scheduler.serverList("tipos_actividades_list");
		scheduler.attachEvent("onTemplatesReady", function(){
			
			scheduler.templates.event_header = function(start,end,event){
				//alert(event.toSource());
				if (event.tipo_actividad){
					tipo_actividad = "";
					$.each(tipos_actividades_list,function(index, value) {
                        if(value.id_crono==event.id)
							tipo_actividad = value.tipo_actividad;
                    });
					return (scheduler.templates.event_date(start)+" - "+scheduler.templates.event_date(end)+" - "+tipo_actividad);
				} else {
					return(scheduler.templates.event_date(start)+" - "+scheduler.templates.event_date(end))
				}
			};
			
			scheduler.templates.event_text = function(start, end, event) {
				var result = "";
				if(event.titulo_actividad)
					result += "<div class='titulo_actividad'>"+event.titulo_actividad+"</div>";
				result += '<div class="crono_conf">';
				//alert(event.id);
				
					if(confs)
					{
						$.each(confs,function(index,value){
							//alert(value.id+" // "+event.id);
							if (value.id_crono==event.id)
								result += formatConfsTxt(value)
						})
					}
				result += '</div>';
				
				if (trabajos_libres_list!=""){
					result += "<br>";
					$.each(trabajos_libres_list,function(index,value){
						if (value.id_crono==event.id)
							result += formatTlTxt(value)
					})
				}			
				return result;
			};
			
		});		
		
		

		scheduler.createUnitsView({
			name:"week_unit",
			property:"section_id",
			list:salas,
			days:3,
		});

		scheduler.createUnitsView({
			name:"single_unit",
			property:"section_id",
			list:salas
		});
 
		scheduler.init('scheduler_here',new Date("2020/09/21"),"single_unit");
		scheduler.load("data/events.php");
		var dp = new dataProcessor("data/events.php");
		dp.init(scheduler);
		dp.attachEvent("onAfterUpdate", function(sid, action, tid, tag)
		{   
			 /*alert(sid);
			 alert(action);
			 alert(tid); 
			 alert(tag);*/		
			 if(action=="inserted")	 
				 scheduler.changeEventId(sid, tid); //changes the event's id "ev15" -> "ev25"
			 //$("#event_id").val(tid);
			 //submit_lightbox();
			 scheduler.load("data/events.php", function(){
				 $(".loading").hide();
			 });
		   	 //document.location.reload()
			 return true;
		});
		dp.setAutoUpdate(5000);
		dp.attachEvent("onMouseOver",function(id,ind){
			//occurs when mouse moved over cell
			this.cells(id,ind).cell.title="any custom tooltip here";   //the text of tooltip may be taken from userdata or any other source
			return false; //block default tooltip
		})
	}
	
	var gets = function(id) { return document.getElementById(id); }; //just a helper.
	
	scheduler.attachEvent("onBeforeEventDelete", function (event_id, event_object) {
		var id = event_id;
		$.ajax({
			url: "data/deleteEvent.php",
			type: "POST",
			data: "eventID="+id,
			success: function(data){
				//alert(data);
			}
		});
		return true;
	});

	
	scheduler.showLightbox = function(id){
		var trabajos_libres_list = scheduler.serverList("trabajos_libres_list");
		var ev = scheduler.getEvent(id);
		start_date = new Date(Date.parse(ev.start_date));
		end_date = new Date(Date.parse(ev.end_date));
		
		scheduler.startLightbox(id, gets("form_casillero"));
		//alert(confs.toSource());
		$("#nuevas_ponencias").html("");
		cantTrab = -1;
		
		//limpiar inputs
		$(":input:not(:checkbox):not(:button)").each(function(){
			$(this).val("");
		})
		$(":input:checkbox").each(function(){
			$(this).prop("checked",false);
		})
		$(".div_drop_tl .sortable_tl").remove();
		//alert(ev.id_crono);
		
		if(!scheduler.getState().new_event)
		{			
			//Datos Actividad
			$("input[name='id_crono']").val(id);
			$("#tipo_actividad_crono").val(ev.tipo_actividad);
			$("#area_crono").val(ev.area);
			$("#tematica_crono").val(ev.tematica);
			$("#titulo_actividad_crono").val(ev.titulo_actividad);
			$("#resumen_crono").val(ev.resumen);
			$("#casillero_pie").val(ev.casillero_pie);
			
			//Conferencistas
			confs = getConfsEvent(id);
			if (confs!="not found" && confs){
				//alert(confs.length);
				var ir = 0;
				//alert(confs.toSource());
				$.each(confs,function(index){
					
					if(confs[index]["id_crono"]==id)
					{
						agregarTrabajo();
						cargarPersonaStatic(ir,confs[index]);
						ir++;
					}
				})
			}
			
			if(trabajos_libres_list)
			{
				$(".div_drop_tl .sortable_tl").remove();
				$.each(trabajos_libres_list, function(index,value){
					if(value.id_crono==id)
						$("<div class='sortable_tl'></div>").html( "<div class='row'><div class='col-xs-11'>"+value.numero_tl+" - "+value.titulo_tl+"<input type='hidden' value='"+value.id_trabajo+"' name='tl_id[]'></div><div class='col-xs-1'><img class='delete_tl' src='imagenes/delete.png' width='22'> <a href='abstract/login.php?id="+Base64.encode(value.id_trabajo)+"' target='_blank'><img src='imagenes/edit.png' width='17' style='margin-top:0px'></a></div></div>" ).appendTo(".div_drop_tl");
				})
			}
			
		}
	}
	
	//needs to be attached to the 'save' button
	function save_form() {
		$(".loading").show();
		$("#resultTlajax").html("");
		var confs = scheduler.serverList("confs").slice();
		var trabajos_libres_list = scheduler.serverList("trabajos_libres_list").slice();
		var ev = scheduler.getEvent(scheduler.getState().lightbox_id);
		//alert(confs.toSource());
		//Remove all confs from this event.
		confs = confs.filter(function( obj ) {
			return obj.id_crono !== ev.id;
		});
		if(scheduler.getState().new_event)
			id_crono = 0;
		else
			id_crono = ev.id;
		$("input[name='persona[]']").each(function(index) {	
			var id_conf = $(this).val();
			var calidad = $(".en_calidad").eq(index).val();
			var titulo = $(".titulo_conferencista").eq(index).val();
			var observaciones_conf = $(".observaciones_conf").eq(index).val();
			var en_crono = $(".en_crono").eq(index).is(':checked');
			if($(".mostrar_ponencia").eq(index).is(":checked"))
				mostrar_ponencia = $(".mostrar_ponencia").eq(index).val();
			else
				mostrar_ponencia = null;
			get_confs = geConfsID(id_conf);
			if(get_confs==null)
			{
				alert("Error #334");
				return false;
			}
			confs.push(
			{
				"id": ev.id,
				"id_conf": id_conf, 
				"id_crono": id_crono,
				"calidad": calidad,
				"titulo": titulo,
				"observaciones_conf": observaciones_conf,
				"mostrar_ponencia": mostrar_ponencia,
				"en_crono": en_crono,
				"nombre": get_confs.nombre,
				"apellido": get_confs.apellido,
				"pais": get_confs.pais,
				"institucion": get_confs.institucion,
			});

		});
		
		id_tls = [];
		$("input[name='tl_id[]']").each(function(index) {	
			id = $(this).val();	
			
			trabajos_temp = getTLEvent(id);
			trabajos_libres_list.push(
			{
				"id_crono": id_crono,
				"numero_tl": trabajos_temp[0].numero_tl,
				"titulo_tl": trabajos_temp[0].titulo_tl,
			});
			id_tls.push(id);
		});
		//trabajos = JSON.stringify(trabajos);
		
		ev.id_crono = id_crono;
		ev.titulo_actividad = gets('titulo_actividad_crono').value;
		ev.tipo_actividad = gets('tipo_actividad_crono').value;
		ev.area = gets('area_crono').value;
		ev.tematica = gets('tematica_crono').value;
		ev.casillero_pie = gets('casillero_pie').value;
		ev.id_trabajo = id_tls;
		//scheduler.updateCollection("confs", confs);		
		//scheduler.updateCollection("trabajos_libres_list", trabajos_libres_list);	
		confs = JSON.stringify(confs);
		ev.confs = confs;
		ev.lightbox = true;
		//alert(ev.toSource());
		scheduler.endLightbox(true, gets("form_casillero"));
	}
	
	
	  
	//needs to be attached to the 'cancel' button
	function close_form(argument) {
		scheduler.endLightbox(false, gets("form_casillero"));
	}
	
	$(document).ready(function(e) {
        $( ".div_drop_tl" ).sortable({
			items: ".sortable_tl",
			revert: true,
			sort: function() {
				$( this ).removeClass( "ui-state-default" );
			}
		});
    });
</script>
</head>
<body onload="init();">
	<div class="loading">Loading&#8230;</div>
	<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
		<div class="dhx_cal_navline">
			<div class="dhx_cal_prev_button">&nbsp;</div>
			<div class="dhx_cal_next_button">&nbsp;</div>
			<div class="dhx_cal_today_button"></div>
			<div class="dhx_cal_date"></div>
			<!--<div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
			<div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
            <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
            -->
			<div class="dhx_cal_tab" name="week_unit_tab" style="right:80px;"></div>
			<div class="dhx_cal_tab" name="single_unit_tab" style="right:80px;"></div>
		</div>
		<div class="dhx_cal_header">
		</div>
		<div class="dhx_cal_data">
		</div>		
	</div>
    
    <!-- Start Form -->
    <?php include("form_casillero.php") ?>
    <!-- End Form -->
    
    
</body>