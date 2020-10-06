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
                <td colspan="4"><input type="text" name="filtro_palabra_clave" class="form-control input-sm" value="<?=$_GET['filtro_palabra_clave'];?>" /></td>
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
				  	$ubicados_tl = $core->query('SELECT t.id_trabajo, t.id_crono, c.start_date, c.end_date, c.id_crono as idcrono, c.section_id FROM trabajos_libres as t JOIN cronograma as c ON t.id_crono=c.id_crono JOIN salas as s ON c.section_id=s.salaid WHERE t.id_crono<>0 GROUP BY t.id_crono ORDER BY SUBSTRING(c.start_date,1,10), s.orden, SUBSTRING(c.start_date,12,16) ASC');
					foreach($ubicados_tl as $ubicado){
						if($ubicado['idcrono']==$_GET['filtro_ubicado'])
							$chktl = 'selected';
						echo '<option value="'.$ubicado['idcrono'].'" '.$chktl.'>'.$core->showUbicacion($ubicado["start_date"],$ubicado["end_date"],$ubicado["section_id"]).' - '.$core->getTematicaID($ubicado["tematica"])["Tematica"].'</option>';
						$chktl = '';
					}
				  ?>
                </select></td>
              </tr>
              <tr>
                <td>Trabajos con:</td>
                <td><select name="filtro_presentador" class="form-control input-sm">
                  <option value=""></option>
                  <option value="1" <?php if($_GET['filtro_presentador']=='1'){echo 'selected';} ?>>Presentador Inscripto</option>
                  <option value="0" <?php if($_GET['filtro_presentador']=='0'){echo 'selected';} ?>>Presentador No Inscripto</option>
                  <option value="todos">Todos</option>
                </select></td>
                <td>&nbsp;</td>
                <td>Email autor</td>
                <td><input type="text" name="filtro_email_autor" class="form-control input-sm" value="<?=$_GET["filtro_email_autor"]?>"></td>
                <!--<td>&nbsp;</td>
                <td>Idioma</td>
                <td><select name="filtro_idioma" class="form-control input-sm">
                  <option value=""></option>
                  <?php
				  $idiomas = $core->getIdiomas();
				  foreach($idiomas as $idioma){
				  ?>
                  <option value="<?=$idioma["id"]?>" <?php if($_GET['filtro_idioma']==$idioma["idioma"]){echo 'selected';} ?>><?=$idioma["idioma"]?></option>
                  <?php
				  }
				  ?> 
                </select></td>-->
              </tr>
              <tr>
                  <td>Áreas</td>
                  <td>
                      <select name="filtro_area_tl" class="form-control input-sm">
                          <option value=""></option>
                          <?php
                          $grupos = $core->getAreasTL();
                          foreach($grupos as $grupo){
                              $chk = '';
                              if($grupo['id']==$_GET['filtro_area_tl'])
                                  $chk = 'selected';
                              echo "<option value='{$grupo['id']}' $chk>{$grupo['Area_es']}</option>";
                          }
                          ?>
                      </select>
                  </td>
                <td>&nbsp;</td>
                <td>Tipo TL</td>
                  <td>
                      <select name="filtro_modalidad" class="form-control input-sm">
                          <option value=""></option>
                          <?php
                          $tipos_tl = $core->getTipoTL();
                          foreach($tipos_tl as $tipo_tl){
                              $chk = '';
                              if($tipo_tl['id']==$_GET['filtro_modalidad'])
                                  $chk = 'selected';
                              echo "<option value='{$tipo_tl['id']}' $chk>{$tipo_tl['tipoTL_es']}</option>";
                          }
                          ?>
                      </select>
				</td>
              </tr>
              <tr>
              	<td>Premio</td>
                <td><select name="filtro_premio" class="form-control input-sm">
                  <option value=""></option>
                  <option value="Si" <?php if($_GET['filtro_premio']=='Si'){echo 'selected';} ?>>Si</option>
                  <option value="No" <?php if($_GET['filtro_premio']=='No'){echo 'selected';} ?>>No</option>
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
                <td>&nbsp;</td>
                <td colspan="3"><input type="button" value="Limpiar" class="btn btn-default" id="reset_tl" /></td>
                <td align="right"><input type="submit" value="Buscar" class="btn btn-primary" /></td>
              </tr>
            </table>
        </form>
    </div> 
</div>

<div class="row">
	<form action="old/envioMail_trabajosLibres.php" method="post" id="form_actions_tl">
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

