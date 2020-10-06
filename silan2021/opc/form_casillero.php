<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="estilos/editor_cronograma.css" rel="stylesheet" type="text/css">
<form id="subm">
<div id="form_casillero" style="position:absolute;z-index:10500; width:700px; padding:20px; top:0px;">

    <div class="row">
        <div class="col-xs-8 text-right" style="margin-top:5px;margin-bottom:5px;">
                <input name="Submit2" type="button" onClick="save_form()" class="btn btn-default btn-sm form-control" style="padding-bottom:33px;" value="GUARDAR" >
                <input type="hidden" name="id_crono" id="id_crono" value="">
        </div>
        <div class="col-xs-4 text-right" style="margin-top:5px;margin-bottom:5px;">
                <a class="btn btn-default form-control" style="padding-top:8px; padding-bottom:5px" href="javascript:close_form()">Volver</a>
        </div>
    </div>    
    <!-- Datos de Actividad -->
    <div id="editor_datos_actividad">
        <div class="row">
            <div class="col-xs-3">
                <label>Tipo de actividad</label>
            </div>
            <div class="col-xs-9">
                <select name="tipo_actividad_crono"  id="tipo_actividad_crono">
                    <option value=""></option>
                    <?php
                        $getTipoActividad = $cargarArray->tipoDeActividades();
                        while($row = $getTipoActividad->fetch()){
                            if($row["tipo_actividad"]==$rows["tipo_actividad"]){
                                $chkTa = "selected";
                            }
                            $bg = "";
                            if(strpos($row["color_actividad"],"#") === false){
                                $bg = "style='background:url(img/patrones/".$row["color_actividad"].")'";
                            }else{
                                $bg = "style='background-color:".$row["color_actividad"]."'";
                            }
                            echo '<option value="'.$row["id_tipo_actividad"].'" '.$chkTa.' '.$bg.'>'.$row["tipo_actividad"].'</option>';
                            $chkTa = "";
                        }
                    ?>
                </select>
                <a href="javascript:popup('index.php?page=tipoActividadesManager',700,490)"><img src="imagenes/plus.jpg" width="28" valgin='middle'  alt=""/></a>
             </div>
       </div>
       <div class="row">
       		<div class="col-xs-2">
	            <label>&Aacute;rea</label>
            </div>
            <div class="col-xs-10">
                <select name="area_crono" id="area_crono" style="width:435px">
                    <option value=""></option>
                    <?php
                        $getAreas = $cargarArray->areas();
                        while($row = $getAreas->fetch()){
                            if($row["Area"]==$rows["Area"]){
                                $chkA = "selected";
                            }
                            echo '<option value="'.$row["ID_Areas"].'" '.$chkA.'>'.$row["Area"].'</option>';
                            $chkA = "";
                        }
                    ?>
                </select>
                <a href="javascript:popup('index.php?page=areasCasilleroManager',700,150)" class="linkAgregar"><img src="imagenes/plus.jpg" width="28" valgin='middle'  alt=""/></a>
             </div>
        </div>
        <div class="row">
        	<div class="col-xs-2">
	            <label>Tem&aacute;tica</label>
            </div>
            <div class="col-xs-10">
                <select name="tematica_crono" id="tematica_crono" style="width:435px">
                    <option value=""></option>
                    <?php
                        $getTematicas = $cargarArray->tematicas();
                        while($row = $getTematicas->fetch()){
                            if($row["Tematica"]==$rows["Tematica"]){
                                $chkT = "selected";
                            }
                            echo '<option value="'.$row["ID_Tematicas"].'" '.$chkT.'>'.$row["Tematica"].'</option>';
                            $chkT = "";
                        }
                    ?>
                </select>
                <a href="javascript:popup('index.php?page=tematicasCasilleroManager',700,150)" class="linkAgregar"><img src="imagenes/plus.jpg" width="28" valgin='middle'  alt=""/></a>
             </div>
        </div>
        
        <div class="row">
        	<div class="col-xs-2">
	            <label>T&iacute;tulo</label>
            </div>
            <div class="col-xs-10">
	            <textarea name="titulo_actividad_crono" id="titulo_actividad_crono" style="width:435px; max-width:435px; min-width:435px;height:50px;"></textarea>
            </div>
       	</div>
        <div class="row" style="display:none">
        	<div class="col-xs-12">
            	<label>Resumen de la actividad:</label>
            	<textarea id="resumen_crono" name="resumen_crono"></textarea>
            </div>
        </div>
    </div>
    
    <!-- Conferencistas -->
    <div>
    	<label>Participan en esta actividad</label>
        <div id="nuevas_ponencias"></div>
        <a id="txt_nueva_persona" href="javascript:popup('index.php?page=conferencistasManager&new=1', 750,450)"  class="linkAgregar"><img src="imagenes/plus.jpg" width="28" valgin='middle'  alt=""/></a>
        <input name="search_conf" type="text" onKeyUp="buscando_personasCongreso(this.value)" placeholder="Buscar participante por su apellido, en la base de datos..." autocomplete="off">
          
         
        <div id="txt_persona_search" class="col-xs-12"></div>
    </div>
    
    <div style="margin-top:20px;">
    <label>Escriba aquí el texto que irá al pie de este horario</label>
    <input type="text" name="casillero_pie" id="casillero_pie">
    </div>
    
    <!-- Trabajos libres -->
    <div class="div_edit_tl">
        <label>Busque los trabajos libres por N&uacute;mero o T&iacute;tulo.</label>
        <div class="input-group" style="width:600px">
          <input type="text" autocomplete="off" id="search_tl" name="tl_trabajo" class="form-control" style="width:100%">
          <span class="input-group-btn">
            <button id="btn_search_tl" class="btn btn-default" type="button">Buscar</button>
          </span>
        </div><!-- /input-group -->
        
        <div id="resultTlajax"></div>
        
        <div class="alert alert-danger div_drop_tl tl_sortable">
            Arrastre aqu&iacute; los trabajos que desea asignar a este casillero.
        </div>
     </div>
 
</div>    
</form>