<?php
error_reporting(E_ALL ^ E_NOTICE);
global $tpl;
$util = $tpl->getVar('util');
$util->isLogged();
$core = $tpl->getVar('core');
$config = $tpl->getVar('config');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
//DEFINE HEADERS
$headers = array(
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/programaExtendido.css"=>"css",
	"estilos/custom.css"=>"css",
	"js/programaTL.js"=>"js",
);
$tpl->SetVar('headers',$headers);

?>
<h3>Búsqueda de trabajos libres</h3>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
    	<?php
			echo $templates->tablaEstadosTL();
		?>
    	<form action="<?=$config["url_opc"]?>?page=buscarTL" method="get">
        	<table border="0" class="table table-condensed">
              <tr>
                <td width="140">Palabra/s</td>
                <td><input type="text" name="filtro_palabra_clave" class="form-control input-sm" value="<?=$_GET['filtro_palabra_clave'];?>" /></td>
                <td width="26">&nbsp;</td>
                <td>Email autor</td>
                <td><input type="text" name="filtro_email_autor" class="form-control input-sm" value="<?=$_GET["filtro_email_autor"]?>"></td>
              </tr>
              <tr>
                <td>Estado</td>
                <td width="306">
                	<select name="filtro_estado" class="form-control input-sm">
                    	<option value=""></option>
                        <option value="cualquier"  <?php if($_GET['filtro_estado']=='cualquier'){echo 'selected';} ?>>Cualquier estado</option>
                        <option style="background-color:#FFCACA;" value="0" <?php if($_GET['filtro_estado']=='0'){echo 'selected';} ?>>Recibidos</option>
                        <option style="background-color:#79DEFF;" value="1" <?php if($_GET['filtro_estado']=='1'){echo 'selected';} ?>>En revisión</option>
                        <option style="background-color:#82E180;" value="2" <?php if($_GET['filtro_estado']=='2'){echo 'selected';} ?>>Aprobados</option>
                        <option style="background-color:#E074DD;" value="4" <?php if($_GET['filtro_estado']=='4'){echo 'selected';} ?>>Notificados</option>
                        <option style="background-color:#999999;" value="3" <?php if($_GET['filtro_estado']=='3'){echo 'selected';} ?>>Rechazados</option>
                    </select>
                </td>
                <td width="26">&nbsp;</td>
                <td width="133">Ubicados en</td>
                <td width="246">
                <select name="filtro_ubicado" class="form-control input-sm">
                  <option value=""></option>
                  <option value="0">Ningun lado</option>
                  <?php
				  	$ubicados_tl = $core->query('SELECT t.id_trabajo, t.id_crono, c.start_date, c.end_date, c.id_crono as idcrono, c.section_id, c.tipo_actividad FROM trabajos_libres as t JOIN cronograma as c ON t.id_crono=c.id_crono JOIN salas as s ON c.section_id=s.salaid WHERE t.id_crono<>0 GROUP BY t.id_crono ORDER BY SUBSTRING(c.start_date,1,10), s.orden, SUBSTRING(c.start_date,12,16) ASC');
					foreach($ubicados_tl as $ubicado){
						//$tematica = $core->getTematicaID($ubicado["tematica"])["Tematica"];
						$tipo_actividad = $core->getNameTipoActividadID($ubicado["tipo_actividad"])["tipo_actividad"];
						if($ubicado['idcrono']==$_GET['filtro_ubicado'])
							$chktl = 'selected';
						echo '<option value="'.$ubicado['idcrono'].'" '.$chktl.'>'.$core->showUbicacion($ubicado["start_date"],$ubicado["end_date"],$ubicado["section_id"]).' - '.$tipo_actividad.'</option>';//$tematica
						$chktl = '';
					}
				  ?>
                </select></td>
              </tr>
              <tr>
                <td>Inscripción:</td>
                <td><select name="filtro_presentador" class="form-control input-sm">
                  <option value=""></option>
                  <option value="1" <?php if($_GET['filtro_presentador']=='1'){echo 'selected';} ?>>Presentador Inscripto</option>
                  <option value="0" <?php if($_GET['filtro_presentador']=='0'){echo 'selected';} ?>>Presentador No Inscripto</option>
                  <option value="2" <?php if($_GET['filtro_presentador']=='2'){echo 'selected';} ?>>Al menos 1 Autor Inscripto</option>
                  <option value="todos">Todos</option>
                </select></td>
                <td>&nbsp;</td>
                <td>Con adjunto</td>
                <td><select name="filtro_adjunto" class="form-control input-sm">
                  <option value=""></option>
                  <option value="Si" <?php if($_GET['filtro_adjunto']=='Si'){echo 'selected';} ?>>Si</option>
                  <option value="No" <?php if($_GET['filtro_adjunto']=='No'){echo 'selected';} ?>>No</option>
                  <option value="Todos" <?php if($_GET['filtro_adjunto']=='Todos'){echo 'selected';} ?>>Todos</option>
                </select></td>
			   </tr>
               <tr>
                <td>Idioma</td>
                <td><select name="filtro_idioma" class="form-control input-sm">
                  <option value=""></option>
                  <option value="en" <?php if($_GET['filtro_idioma']=='en'){echo 'selected';} ?>>English</option>
                  <option value="es" <?php if($_GET['filtro_idioma']=='es'){echo 'selected';} ?>>Español</option>
                  <option value="pt" <?php if($_GET['filtro_idioma']=='pt'){echo 'selected';} ?>>Português</option> 
                </select></td>
				<td>&nbsp;</td>
	<!--filtro de Salas-->
				<td>Salas</td>
                <td>
				 <select name="filtro_salas" class="form-control input-sm">
                	<option value=""></option>
                  <option value="0"<?php if($_GET['filtro_salas']=='0'){echo 'selected';} ?>>Ningun lado</option>
                  <option value="2"<?php if($_GET['filtro_salas']=='2'){echo 'selected';} ?>>Sala 1</option>
                  <option value="1"<?php if($_GET['filtro_salas']=='1'){echo 'selected';} ?>>Sala 2</option>
                  <option value="3"<?php if($_GET['filtro_salas']=='3'){echo 'selected';} ?>>Sala 3</option>
                  <option value="4"<?php if($_GET['filtro_salas']=='4'){echo 'selected';} ?>>Conv. Culturalidades</option>
                  <option value="5"<?php if($_GET['filtro_salas']=='5'){echo 'selected';} ?>>Conv. Otredades</option>
                  <option value="6"<?php if($_GET['filtro_salas']=='6'){echo 'selected';} ?>>Conv. Subjetividades</option>
                  <option value="7"<?php if($_GET['filtro_salas']=='7'){echo 'selected';} ?>>Posters</option>			  
                </select>
				</td>
	<!--END filtro de Salas-->
              </tr>
			  <tr>
                <td>Modalidad:</td>
                <td>
                <select name="filtro_modalidad" class="form-control input-sm">
                	<option value=""></option>
					<?php
                    $modalidades = $core->query("SELECT * FROM trabajos_libres_modalidades");
                    foreach($modalidades as $modalidad){
                    ?>
                    	<option value="<?=$modalidad["id"]?>" 
						<?php 
						if($_GET['filtro_modalidad']==$modalidad["id"])
                    	{echo 'selected';}?>><?=$modalidad["modalidad_es"]?></option>
                    <?php
                    }
                    ?>
                </select></td>
                <td>&nbsp;</td>
                <td>Eje</td>
                <td>
                    <select name="filtro_eje_tematico" class="form-control input-sm">
                        <option value=""></option>
                        <?php
                        $getAreas = $core->getAreasTL();
                        foreach($getAreas as $row){
                            $chk = "";
                            if($_GET["filtro_eje_tematico"]==$row["id"])
                                $chk = "selected";
                            echo "<option value='{$row["id"]}' $chk>{$row["Area_es"]}</option>";
                        }
                        ?>
                    </select>
                </td>
              </tr>
              <tr>
                <td>Línea transversal</td>
                <td>
                    <select name="filtro_linea_transversal" class="form-control input-sm">
                        <option value=""></option>
                        <?php
                        $lineas_transversales = $core->query("SELECT * FROM trabajos_libres_lineas_transversales");
                        foreach($lineas_transversales as $row){
                            $chk = "";
                            if($_GET["filtro_linea_transversal"]==$row["id"])
                                $chk = "selected";
                            echo "<option value='{$row["id"]}' $chk>{$row["linea_transversal_es"]}</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>&nbsp;</td>
                <td>País</td>
                <td>
                <select name="filtro_pais" class="form-control input-sm">
                      <option value=""></option>
                      <?php
                      $paisesTL = $core->getPaisesTL();
                      foreach($paisesTL as $paisTL){
                          $chk = '';
                          if($paisTL['id_pais']==$_GET['filtro_pais'])
                              $chk = 'selected';
                          echo "<option value='{$paisTL['id_pais']}' $chk>{$paisTL['pais']}</option>";
                      }
                      ?>
                </select>
                </td>
              </tr>
			  <tr>
                <td>TC_Español</td>
                <td>
                    <select name="filtro_espanol" class="form-control input-sm">
                        <option value=""></option>
                        <option value="Si" <?php if($_GET['filtro_espanol']=='Si'){echo 'selected';} ?>>Si</option>
                        <option value="No" <?php if($_GET['filtro_espanol']=='No'){echo 'selected';} ?>>No</option>
                    </select>
                </td>
              <tr>
                <td>TC_Portugués</td>
                <td>
                    <select name="filtro_resumo" class="form-control input-sm">
                        <option value=""></option>
                        <option value="Si" <?php if($_GET['filtro_resumo']=='Si'){echo 'selected';} ?>>Si</option>
                        <option value="No" <?php if($_GET['filtro_resumo']=='No'){echo 'selected';} ?>>No</option>
                    </select>
                </td>
              </tr>
              <tr>
			                <tr>
                <td>Bibliografía</td>
                <td>
                    <select name="filtro_bibliografia" class="form-control input-sm">
                        <option value=""></option>
                        <option value="Si" <?php if($_GET['filtro_bibliografia']=='Si'){echo 'selected';} ?>>Si</option>
                        <option value="No" <?php if($_GET['filtro_bibliografia']=='No'){echo 'selected';} ?>>No</option>
                    </select>
                </td>
              </tr>
              <tr>
			    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="3"><input type="button" value="Limpiar" class="btn btn-default" id="reset_tl" /></td>
                <td align="right"><input type="submit" value="Buscar" class="btn btn-primary" /></td>
              </tr>
			    <!--<td>Tipo TL</td>
                <td>
                <select name="filtro_tipo_tl" class="form-control input-sm">
                	<option value=""></option>
					<?php
                    $tipos_tl = $core->query("SELECT * FROM tipo_de_trabajos_libres");
                    foreach($tipos_tl as $tipo_tl){
                    ?>
                        <option value="<?=$tipo_tl["id"]?>" <?php if($_GET['filtro_tipo_tl']==$tipo_tl["id"]){echo 'selected';}?>><?=$tipo_tl["tipoTL_es"]?></option>
                    <?php
                    }
                    ?>
                </select>
                </td>-->
            </table>
        </form>
    </div> 
</div>

<div class="row">
	<form action="envio_mail/trabajos/" method="post" id="form_actions_tl">
	<?php
	if(isset($_GET['filtro_palabra_clave'])){
		$tl = $core->busquedaTL($_GET);
		echo '<div class="col-md-12 col-md-offset-1">Trabajos encontrados: <b>'.count($tl).'</b></div>'.BR;
		foreach($tl as $row){
			echo $templates->templateTlTXT($row);
		}
		if(count($tl)>0 && $_SESSION["usuario"]){
			echo '<div class="col-md-11 col-md-offset-1">';
				echo $templates->tablaActionsTL();
			echo '</div>';
		}
	}
	?>
    </form>
</div>

