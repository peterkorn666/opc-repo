<?php
global $tpl;
$util = $tpl->getVar('util');
$util->isLogged();
$core = $tpl->getVar('core');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
/*if(!$core->isAdmin()){
	header("Location: /");
	die();
}*/
//DEFINE HEADERS
$headers = array(
	"estilos/custom.css"=>"css",
	"estilos/filters.css"=>"css",
	"estilos/datatables.min.css"=>"css",
    "estilos/conferencistas_manager.css"=>"css",
	"js/filters.js"=>"js",
    "js/conferencistas_manager.js"=>"js",
	"js/datatables.min.js"=>"js",
	"js/conferencistasDataTable.js"=>"js"
);
$tpl->SetVar('headers',$headers);

$conferencistas_tipos = $core->getConferencistasTipos();

if((!empty($_POST["key"])) || (!empty($_POST["nombre"])))
{
	
	if(isset($_POST["observaciones_conf"]))
	{
		foreach($_POST["observaciones_conf"] as $key => $observacion_conf){
			$core->bind('observacion_conf',$observacion_conf);
			$core->bind('id_cc',base64_decode($_POST["id_cc"][$key]));
			$core->query("UPDATE crono_conferencistas SET observaciones_conf=:observacion_conf WHERE id=:id_cc");
		}
	}
	
	if(isset($_POST["titulo_conf"]))
	{
		foreach($_POST["titulo_conf"] as $keyTitle => $titulo_conf){
			$core->bind('titulo_conf',$titulo_conf);
			$core->bind('id_cc',base64_decode($_POST["id_cc"][$keyTitle]));
			$core->query("UPDATE crono_conferencistas SET titulo_conf=:titulo_conf WHERE id=:id_cc");
		}
	}
	
    $archivo_presentacion = $_FILES["presentacion"];
    $archivo_nombre_presentacion = "";
    if($archivo_presentacion["tmp_name"]!="")
        $archivo_nombre_presentacion = $core->guardarArchivo($archivo_presentacion,"cv/");
    else
        $archivo_nombre_presentacion = $_POST["presentacion_viejo"];

    $archivo_foto = $_FILES["foto_conferencista"];
	$explode_foto = explode(".", $_FILES["foto_conferencista"]["name"]);
	if (strpos(end($explode_foto), "doc") !== false || strpos(end($explode_foto), "docx") !== false){
		header("Location: /?page=".$_GET["page"]."&key=".$_GET["key"]."&errorFormato=1");die();
	}
    $archivo_nombre_foto = "";
    if($archivo_foto["tmp_name"]!="")
        $archivo_nombre_foto = $core->guardarArchivo($archivo_foto,"conf_fotos/");
    else
        $archivo_nombre_foto = $_POST["foto_viejo"];
		
	$institucion = $core->insertInstitution($_POST["institucion"]);
	$core->bind('profesion',$_POST["profesion"]);
	$core->bind('email',$_POST["email"]);
	$core->bind('nombre',$_POST["nombre"]);
	$core->bind('apellido',$_POST["apellido"]);
	$core->bind('genero',$_POST["genero"]);
	$core->bind('institucion',$institucion);
	$core->bind('cargo',$_POST["cargo"]);
	$core->bind('documento',$_POST["documento"]);
	$core->bind('telefono',$_POST["telefono"]);
	$core->bind('ciudad',$_POST["ciudad"]);
	$core->bind('pais',$_POST["pais"]);
	$core->bind('comentarios',$_POST["comentarios"]);
	$core->bind('redes_sociales',$_POST["redes_sociales"]);
	$core->bind('cv_abreviado',$_POST["cv_abreviado"]);
	$core->bind('cv_extendido',$_POST["cv_extendido"]);
	$core->bind('hotel',$_POST["hotel"]);
	$core->bind('hotel_in',$_POST["hotel_in"]);
	$core->bind('hotel_out',$_POST["hotel_out"]);
	$core->bind('hotel_compania_in',$_POST["hotel_compania_in"]);
	$core->bind('hotel_vuelo_in',$_POST["hotel_vuelo_in"]);
	$core->bind('hotel_fecha_in',$_POST["hotel_fecha_in"]);
	$core->bind('hotel_hora_in',$_POST["hotel_hora_in"]);
	$core->bind('hotel_compania_out',$_POST["hotel_compania_out"]);
	$core->bind('hotel_vuelo_out',$_POST["hotel_vuelo_out"]);
	$core->bind('hotel_fecha_out',$_POST["hotel_fecha_out"]);
	$core->bind('hotel_hora_out',$_POST["hotel_hora_out"]);
	$core->bind('archivo_presentacion',$archivo_nombre_presentacion);
	$core->bind('archivo_foto',$archivo_nombre_foto);
	
	//admin
	$core->bind('tipo',$_POST["tipo"]);
	$core->bind('admin_comentarios',$_POST["admin_comentarios"]);
	$core->bind('admin_comentarios2',$_POST["admin_comentarios2"]);
	$core->bind('admin_participa',$_POST["admin_participa"]);
}

if(!empty($_POST["key"]))
{
	$core->bind("key",$_POST["key"]);
	$sql = $core->query("UPDATE conferencistas SET 
							profesion=:profesion,
							email=:email,
							nombre=:nombre,
							apellido=:apellido,
							genero=:genero,
							institucion=:institucion,
							cargo=:cargo,
							documento=:documento,
							telefono=:telefono,
							ciudad=:ciudad,
							pais=:pais,
							comentarios=:comentarios,
							redes_sociales=:redes_sociales,
							cv_abreviado=:cv_abreviado,
							cv_extendido=:cv_extendido,
							hotel=:hotel,
							hotel_in=:hotel_in,
							hotel_out=:hotel_out,
							hotel_compania_in=:hotel_compania_in,
							hotel_vuelo_in=:hotel_vuelo_in,
							hotel_fecha_in=:hotel_fecha_in,
							hotel_hora_in=:hotel_hora_in,
							hotel_compania_out=:hotel_compania_out,
							hotel_vuelo_out=:hotel_vuelo_out,
							hotel_fecha_out=:hotel_fecha_out,
							hotel_hora_out=:hotel_hora_out,
							archivo_presentacion=:archivo_presentacion,
							archivo_foto=:archivo_foto,
							
							tipo=:tipo,
							admin_comentarios=:admin_comentarios,
							admin_comentarios2=:admin_comentarios2,
							admin_participa=:admin_participa
							WHERE id_conf=:key");
}else if(empty($_POST["key"]) && isset($_POST["key"])){
	$sql = $core->query("INSERT INTO conferencistas (
							profesion,
							email,
							nombre,
							apellido,
							genero,
							institucion,
							cargo,
							documento,
							telefono,
							ciudad,
							pais,
							comentarios,
							redes_sociales,
							cv_abreviado,
							cv_extendido,
							hotel,
							hotel_in,
							hotel_out,
							hotel_compania_in,
							hotel_vuelo_in,
							hotel_fecha_in,
							hotel_hora_in,
							hotel_compania_out,
							hotel_vuelo_out,
							hotel_fecha_out,
							hotel_hora_out,
							archivo_presentacion,
							archivo_foto,
							
							tipo,
							admin_comentarios,
							admin_comentarios2,
							admin_participa
							
							) VALUES (
								:profesion,
								:email,
								:nombre,
								:apellido,
								:genero,
								:institucion,
								:cargo,
								:documento,
								:telefono,
								:ciudad,
								:pais,
								:comentarios,
								:redes_sociales,
								:cv_abreviado,
								:cv_extendido,
								:hotel,
								:hotel_in,
								:hotel_out,
								:hotel_compania_in,
								:hotel_vuelo_in,
								:hotel_fecha_in,
								:hotel_hora_in,
								:hotel_compania_out,
								:hotel_vuelo_out,
								:hotel_fecha_out,
								:hotel_hora_out,
								:archivo_presentacion,
								:archivo_foto,
								
								:tipo,
								:admin_comentarios,
								:admin_comentarios2,
								:admin_participa
							)");
	
}else if($_GET["del"]){
	$core->bind("key",$_GET["del"]);
	$sql = $core->query("DELETE FROM conferencistas WHERE id_conf=:key");
}

if(!empty($_GET["key"])){// && $core->canEdit()
	$row = $core->row("SELECT * FROM conferencistas WHERE id_conf='".base64_decode($_GET["key"])."'");
}
if($_POST['p']){
	echo '<script type="text/javascript">';
		echo 'window.close();';
	echo '</script>';

}
?>
<h3>Conferencistas</h3>
<?php
if(empty($_GET['p'])) {
?>
	<!-- FORM Busqueda -->
	<form action="?page=conferencistasManager" method="post">
		<div class='filter' style="display: none;">
			<div class="search-input">
				<div class="input-group">
					<input type="text" name="buscar" class="form-control" value="<?php echo $_POST['buscar']; ?>">
	            <span class="input-group-btn">
	                <button class="btn btn-default" type="submit">Buscar</button>
	            </span>
				</div><!-- /input-group -->
			</div>
			<p class='title filter_opt'>opciones</p>
			<p class='title_items' data-item='filter_area'>Areas</p>
			<p class='title_items' data-item='filter_roles'>Roles</p>
			<div style="clear:both"></div>
			<ul id="filter_area">
				<?php
				$getAreas = $core->getAreas();
				foreach ($getAreas as $areas) {
					$chk = '';
					if ($_POST['filtro_areas']) {
						if (in_array($areas['ID_Areas'], $_POST['filtro_areas']))
							$chk = 'checked';
					}
					echo "
				<li>
					<input id='" . $areas['ID_Areas'] . "' name='filtro_areas[]' type='checkbox' value='" . $areas['ID_Areas'] . "' $chk>
	                <label for='" . $areas['ID_Areas'] . "' class='checkbox'>" . $areas['Area'] . "</label>
				</li>";
				}
				?>
			</ul>

			<ul id="filter_roles">
				<?php
				$getRoles = $core->getRoles();
				foreach ($getRoles as $roles) {
					echo "
				<li>
					<input id='" . $roles['ID_calidad'] . "' name='filtro_areas' type='checkbox' value='" . $roles['ID_calidad'] . "'>
	                <label for='" . $roles['ID_calidad'] . "' class='checkbox'>" . $roles['calidad'] . "</label>
				</li>";
				}
				?>
			</ul>
		</div>
	</form>
	<?php
}
?>
<!-- FORM Conferencistas -->
<?php
	$action_form = "";
	if($_GET["key"]){
		$action_form = "&key=".$_GET["key"];
	}
?>
<div id="div-conferencista" style="<?php if(!isset($_GET["key"]) && !isset($_GET["new"])){ echo 'display:none'; }?>">
<form id="confs" action="<?=$config["url_opc"]?>?page=conferencistasManager<?=$action_form?>" method="post" enctype="multipart/form-data" onSubmit="return validar()">

<?php if($core->canEdit()){ ?>
	<?php
	if(count($row) > 0){
		?>
        <div class="row">
            <div class="col-md-12" style="font-size: 16px;">
                <a href="?page=conferencistasCertificado&key=<?=md5($row["id_conf"])?>" target="_blank">Certificados</a>
            </div>
        </div>
        <?php	
	}
	?>
    <div class="row" style="margin-bottom:0px !important;<?php if(isset($_GET["new"])){ echo 'display:none'; }?>">
        <div class="col-md-4" style="background-color:#FFBE5E; padding:10px">
            Comentarios internos administrador
        </div>
        <div class="col-md-8" style="background-color:#FFBE5E; padding:10px">
            Información:
        </div>    
    </div>

    <div class="row" style="margin-top:0px !important;<?php if(isset($_GET["new"])){ echo 'display:none'; }?>">
        <div class="col-md-4" style="background-color:#FFD08A; padding:10px"><br>
            <textarea class="form-control" rows="8" style="resize:none" name="admin_comentarios"><?=$row["admin_comentarios"]?></textarea>
        </div>
        <div class="col-md-8" style="background-color:#FFD08A; padding:10px 10px 20px"><br>
        	Tipo:<br>
            <?php
            foreach($conferencistas_tipos as $conferencista_tipo){
				$checked = "";
				if($conferencista_tipo['id'] == $row["tipo"])
					$checked = 'checked';
			?>
            	<input type="radio" name="tipo" value="<?=$conferencista_tipo['id']?>" <?=$checked?>> <?=$conferencista_tipo['nombre']?>&nbsp;&nbsp;&nbsp;
            <?php
			}
			?><br><br>
            Aceptó participar?<br>
            <input type="radio" name="admin_participa" value="Se le informó" <?php if($row["admin_participa"]=="Se le informó"){ echo "checked";} ?>> se le informó &nbsp;&nbsp;&nbsp;
            <input type="radio" name="admin_participa" value="Esperando repuesta" <?php if($row["admin_participa"]=="Esperando repuesta"){ echo "checked";} ?>> Esperando respuesta &nbsp;&nbsp;&nbsp;
            <input type="radio" name="admin_participa" value="No" <?php if($row["admin_participa"]=="No"){ echo "checked";} ?>> No<br><br>
            <textarea class="form-control" rows="5" style="resize:none" name="admin_comentarios2"><?=$row["admin_comentarios2"]?></textarea>
        </div>
    </div>
<?php } ?>

<?php
	if($_GET["errorFormato"]){
?>
		<div class="col-md-12 alert alert-danger" align="center">
        	El formato de la foto no es válido.
        </div>
<?php
	}
?>
<div class="row">
	<?php
    /*if($_SESSION["admin"]){
    ?>
    	<div class="col-md-12">
        	<div class="row">
            	<div class="col-xs-6 col-xs-offset-3" style="font-size: 16px;">
                
                	<input type="button" value="Descargar constancia de asistencia" class="descargar_certificado_asistencia form-control btn btn-info" data-conf="<?=$row["id_conf"]?>">
                	<!--<a href="certificados/conferencista/asistente.php?conf=<?=base64_encode($row["id_conf"])?>" target="_blank">Descargar constancia de asistencia</a>-->
                </div>
            </div>
        </div>
    <?php
    }*/
    ?>
	<div class="col-md-12">    	
    	<div class="row">
            <div class="col-xs-6">
                <label>Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control input-sm" value="<?=$row["nombre"]?>">
            </div>
            <div class="col-xs-6">
                <label>Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control input-sm" value="<?=$row["apellido"]?>">
            </div>
        </div>
        
        <div class="row">
        	<div class="col-xs-3">
            	<label>Género</label><br>
                <input type="radio" name="genero" value="Masculino" <?php if($row["genero"]=="Masculino"){echo "checked";} ?>> Masculino&nbsp;&nbsp;&nbsp;
                <input type="radio" name="genero" value="Femenino" <?php if($row["genero"]=="Femenino"){echo "checked";} ?>> Femenino
            </div>
            <div class="col-xs-3">
                <label>Profesi&oacute;n / Título Académico</label>
                <input type="text" id="nombre" name="profesion" class="form-control input-sm" value="<?=$row["profesion"]?>">
            </div>
            
            <div class="col-xs-3">
                <label>Institución</label>
                <input type="text" id="institucion" name="institucion" class="form-control input-sm" value="<?=$core->getInstitution($row["institucion"])["Institucion"]?>">
            </div>
            <div class="col-xs-3">
                <label>Cargo / Ocupación</label>
                <input type="text" id="cargo" name="cargo" class="form-control input-sm" value="<?=$row["cargo"]?>">
            </div>
        </div>
    
        <div class="row">
            <div class="col-xs-3">
                <label>Documento / Pasaporte</label>
                <input type="text" id="documento" name="documento" class="form-control input-sm" value="<?=$row["documento"]?>">
            </div>
            
            <div class="col-xs-3">
                <label>Teléfono fijo o Móvil</label>
                <input type="text" id="telefono" name="telefono" class="form-control input-sm" value="<?=$row["telefono"]?>">
            </div>
            
            <div class="col-xs-6">
                <label>Correo Electrónico</label>
                <input type="text" id="apellido" name="email" class="form-control input-sm" value="<?=$row["email"]?>">
            </div>
            
        </div>
        
        
        
        <div class="row">
            
            <div class="col-xs-6">
                <label>Ciudad / Provincia / Estado</label>
                <input type="text" id="ciudad" name="ciudad" class="form-control input-sm" value="<?=$row["ciudad"]?>">
            </div>
            <div class="col-xs-6">
                <label>País</label>
                <select name="pais" class="form-control">
                    <?php
                        foreach($core->getPaises() as $paises) {
                            $chkp = "";
                            if($paises["ID_Paises"]==$row["pais"])
                                $chkp = "selected";
                    ?>
                            <option value="<?=$paises["ID_Paises"]?>" <?=$chkp?>><?=$paises["Pais"]?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>  
        
        <div class="row">
        	<div class="col-xs-6">
                <label>Comentarios</label>
                <input type="text" class="form-control input-sm" name="comentarios" value="<?=$row["comentarios"]?>">
            </div>
            <div class="col-xs-6">
                <label>Redes Sociales / Blog / Web</label>
                <input type="text" class="form-control input-sm" name="redes_sociales" value="<?=$row["redes_sociales"]?>">
            </div>
        </div> 
        
        <!-- EXTRAS FUERA DE POPUP -->
        <?php
		if(empty($_GET["p"]))
		{
		?>
        <div class="row">
            <div class="col-md-12 text-center">
                <?php
                if($row["archivo_presentacion"])
                    echo "<a href='cv/".$row["archivo_presentacion"]."' target='_blank'><i>Ya tiene una conferencia cargada.</i></a> <a href='#' class='eliminar_cv'>(Eliminar)</a><br>";
                ?>
                <a href="#" class="uploadFile btn btn-warning input-sm" data-target="presentacion"> Cuando tenga su presentaci&oacute;n podrá cargarla haciendo click aqu&iacute;</a>
                <input type="file" name="presentacion" style="display: none;">
                <input type="hidden" name="presentacion_viejo" value="<?=$row["archivo_presentacion"]?>">
            </div>
        </div><br>
        <!-- CVs -->
            <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <?php
                        $foto_conf = "nophoto.jpg";
                        if($row["archivo_foto"])
                            $foto_conf = $row["archivo_foto"];
                        ?>
                        <div id="confPhoto" class="col-md-12 well text-center"><img src="conf_fotos/<?=$foto_conf?>" style="max-height: 118px; max-width: 165px"></div>
                    </div>
                    <div class="row text-center">
                        <a href="#" class="uploadFile" data-target="foto_conferencista"> Haga click aquí para<br>cargar su foto</a>
                        <input type="file" name="foto_conferencista" style="display: none;">
                        <input type="hidden" name="foto_viejo" value="<?=$row["archivo_foto"]?>">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12" style="margin-bottom: 10px">
                        <label><strong>Curriculum abreviado</strong> <em>que se leerá en el momento de su disertación (hasta 100 palabras)</em></label>
                        <textarea name="cv_abreviado" class="form-control"><?=$row["cv_abreviado"]?></textarea>
                    </div>
                    <div class="col-md-12">
                        <label><strong>Curriculum extendido</strong> <em>(hasta 600 palabras)</em></label>
                        <textarea name="cv_extendido" class="form-control"><?=$row["cv_extendido"]?></textarea>
                    </div>
                </div>
            </div><br>
        
        <!-- Hotel -->
        <?php 
		if($core->canEdit()){
		?>
            <p><strong>Alojamiento y traslados</strong></p>
            <div class="row">
                <div class="col-xs-6">
                    <label>HOTEL</label>
                    <input type="text" class="form-control input-sm" name="hotel" value="<?=$row["hotel"]?>">
                </div>
                <div class="col-xs-3">
                    <label>IN</label>
                    <input type="text" class="form-control input-sm" name="hotel_in" value="<?=$row["hotel_in"]?>">
                </div>
                <div class="col-xs-3">
                    <label>OUT</label>
                    <input type="text" class="form-control input-sm" name="hotel_out" value="<?=$row["hotel_out"]?>">
                </div>
            </div>
            <p><strong>Arribo</strong></p>
            <div class="row">
                <div class="col-xs-3">
                    <label>Compañia</label>
                    <input type="text" class="form-control input-sm" name="hotel_compania_in" value="<?=$row["hotel_compania_in"]?>">
                </div>
                <div class="col-xs-3">
                    <label>Vuelo</label>
                    <input type="text" class="form-control input-sm" name="hotel_vuelo_in" value="<?=$row["hotel_vuelo_in"]?>">
                </div>
                <div class="col-xs-3">
                    <label>Fecha</label>
                    <input type="text" class="form-control input-sm" name="hotel_fecha_in" value="<?=$row["hotel_fecha_in"]?>">
                </div>
                <div class="col-xs-3">
                    <label>Hora</label>
                    <input type="text" class="form-control input-sm" name="hotel_hora_in" value="<?=$row["hotel_hora_in"]?>">
                </div>
            </div>
            
            <p><strong>Partida</strong></p>
            <div class="row">
                <div class="col-xs-3">
                    <label>Compañia</label>
                    <input type="text" class="form-control input-sm" name="hotel_compania_out" value="<?=$row["hotel_compania_out"]?>">
                </div>
                <div class="col-xs-3">
                    <label>Vuelo</label>
                    <input type="text" class="form-control input-sm" name="hotel_vuelo_out" value="<?=$row["hotel_vuelo_out"]?>">
                </div>
                <div class="col-xs-3">
                    <label>Fecha</label>
                    <input type="text" class="form-control input-sm" name="hotel_fecha_out" value="<?=$row["hotel_fecha_out"]?>">
                </div>
                <div class="col-xs-3">
                    <label>Hora</label>
                    <input type="text" class="form-control input-sm" name="hotel_hora_out" value="<?=$row["hotel_hora_out"]?>">
                </div>
            </div><br><br>

        <?php
		}//end can edit
		}//end if p - pop up
		?>       
    </div>   
</div>    
	<p align="center"><input type="submit" class="btn btn-primary" value="Guardar" style="width:400px"></p>
	<input type="hidden" id="key" name="key" value="<?=$row["id_conf"]?>">
	<input type="hidden" name="p" value="<?=$_GET['p']?>">
    
    
    <!-- ACTIVIDADES -->
    <?php
		echo $templates->actividadConferencista($row["id_conf"]);
	?>
    
</form>
</div>
<?php
if(empty($_GET["p"]) && $core->canEdit())
{
?>   
<div class="row">
    <div class="col-xs-6">
        <h3>Listado</h3>
        <a href="/excels/conferencistas.php">Descargar listado</a>
    </div>
    <div class="col-xs-6 text-right"><button class="btn btn-info" id="nuevo-conferencista">Nuevo</button></div>
</div>
<div class="row">
    <div class="col-md-12"><!-- style="max-height:400px; overflow:auto;"-->
    	<table id="conferencistas" class="table"><!-- width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#000000" -->
			<thead>
            <tr>
            	<td bgcolor="#FFFFFF">&nbsp;</td>
                <td bgcolor="#FFFFFF">ID</td>
                <td bgcolor="#FFFFFF">Nombre</td>
                <td bgcolor="#FFFFFF">Apellido</td>
                <td bgcolor="#FFFFFF">Nº Actividades</td>
                <td bgcolor="#FFFFFF">Email</td>
			</tr>
            </thead>
            <tbody>
				<?php
				$search = '';
				if($_POST['filtro_areas'] || $_POST['buscar']){
					$search = 'WHERE ';
					if($_POST['filtro_areas']){
						foreach($_POST['filtro_areas'] as $key => $areas){
							if($key!=0)
								$search .= ' OR ';
							$search .= ' area LIKE :area';
							$core->bind('area',$areas);
						}
					}
					if($_POST['buscar']) {
						if($search!='WHERE ')
							$search .= ' AND ';
						$search .= ' nombre LIKE :nombre OR apellido LIKE :apellido';
						$core->bind('nombre', "%".$_POST['buscar']."%");
						$core->bind('apellido', "%".$_POST['buscar']."%");
					}
				}
				//echo "SELECT * FROM conferencistas $search ORDER BY apellido";
				$sql = $core->query("SELECT * FROM conferencistas $search ORDER BY apellido");
				foreach($sql as $a)
				{
					//actividades 
					$core->bind("id_conf", $a["id_conf"]);
					$act = $core->query("SELECT id_conf FROM crono_conferencistas WHERE id_conf=:id_conf");
				?>
                 	<tr>
				 		<td width="20" bgcolor="#FFFFFF">
                        	<?php if($core->canDel()){ ?>
                        	<a href="<?=$config["url_opc"]?>?page=<?=$_GET["page"]?>&del=<?=$a["id_conf"]?>" onclick="return confirm('Desea eliminar <?=$a["nombre"]?>')"><i class="fa fa-trash" style="font-size:16px"></i></a>
                            <?php } ?>
                        </td>
                        <td bgcolor="#FFFFFF"><a href="<?=$config["url_opc"].'?page='.$_GET["page"].'&key='.base64_encode($a["id_conf"])?>" style="font-weight:bold;"><?=$a["id_conf"]?></a></td>
			 		  <td bgcolor="#FFFFFF">
                      <a href="<?=$config["url_opc"].'?page='.$_GET["page"].'&key='.base64_encode($a["id_conf"])?>" style="font-weight:bold;">
			 		    <?=$a["nombre"]?>
			 		  </a></td>
				 		<td bgcolor="#FFFFFF"><a href="<?=$config["url_opc"].'?page='.$_GET["page"].'&key='.base64_encode($a["id_conf"])?>" style="font-weight:bold;"><?=$a["apellido"]?></a></td>
                        <td bgcolor="#FFFFFF"> <a href="<?=$config["url_opc"].'?page='.$_GET["page"].'&key='.base64_encode($a["id_conf"])?>" style="font-weight:bold;"><?=count($act)?></a></td>
				 		<td bgcolor="#FFFFFF"> <a href="<?=$config["url_opc"].'?page='.$_GET["page"].'&key='.base64_encode($a["id_conf"])?>" style="font-weight:bold;"><?=$a["email"]?></a></td>
				 	</tr>
            <?php
                }
            ?>
            </tbody>
        </table>

   </div>
<?php
}
?>    
</div>
<script type="text/javascript">
function validar()
{
	if($("input[name='nombre']").val()=="")
	{
		alert("Escriba un nombre");
		return false;
	}
}
</script>

