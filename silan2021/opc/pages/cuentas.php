<?php
global $tpl;
$util = $tpl->getVar('util');
$util->isLogged();
$core = $tpl->getVar('core');
$config = $tpl->getVar('config');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
if(!$core->isAdmin()){
	header("Location: /opc/");
	die();
}
//DEFINE HEADERS
$headers = array(
	"estilos/config.css"=>"css",
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/custom.css"=>"css"
);
$tpl->SetVar('headers',$headers);

if($_POST["key"]!="" && $core->canEdit())
{
}

if($_GET["key"]){
	//$core->bind("id",$_GET["key"]);
	//$usuario = $core->row("SELECT * FROM claves WHERE ID_clave=:id");
}
if($_GET["del"]){
	//$core->bind("id",$_GET["del"]);
	//$core->row("DELETE FROM claves WHERE ID_clave=:id");
}
?>
<h3>Cuentas <small> - <a href="<?php echo $config["url_base"] ?>cuenta" target="_blank"><?php echo $config["url_base"] ?>cuenta</a></h3></small>
<form action="index.php?page=cuentas" method="post">
<div class="row">
	<div class="col-xs-6" style="display: none;">
    	<div class="row">
            <div class="col-md-6">
                <label>Usuario</label>
                <input type="text" name="usuario" class="form-control" value="<?=$usuario["usuario"]?>">
            </div>
            <div class="col-md-6">
                <label>Clave</label>
                <input type="text" name="clave" class="form-control" value="<?=$usuario["clave"]?>">
            </div>
        </div>
        <div class="row">  
            <div class="col-md-12">
                <label>Navegar full</label>&nbsp;
                <input type="checkbox" name="administrador" value="1" <?php if($usuario["tipoUsuario"]){echo "checked";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
                <label>Editar</label>&nbsp;
                <input type="checkbox" name="editar" value="1"  <?php if($usuario["edit"]){echo "checked";}?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
                <label>Eliminar</label>&nbsp;
                <input type="checkbox" name="eliminar" value="1"  <?php if($usuario["del"]){echo "checked";}?>>
            </div>
        </div><br>
        <p align="center"><input type="button"  class="btn btn-default limpiar" value="Limpiar"> &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Guardar" class="btn btn-primary"></p>
    	<input type="hidden" name="key" value="<?=$usuario["ID_clave"]?>">
    </div>

	<div class="col-xs-12">
    	<table class="table">
        	<thead>
              <tr>
                <th>ID</th>
                <th>Trabajos</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Trabajos</th>
                <th>Clave</th>
                <th>Fecha</th>
                <th>Activo</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
    	<?php
			foreach($core->getCuentas() as $cuenta){
				$trabajos = $core->getTrabajos($cuenta['id']);
                $tls = '';
                foreach($trabajos as $tl)
                    $tls .= $tl['numero_tl'].', ';
				echo '
				  <tr>
					<td>'.$cuenta["id"].'</td>
					<td>'.trim($tls,', ').'</td>
					<td>'.$cuenta["nombre"].'</td>
					<td>'.$cuenta["apellido"].'</td>
					<td>'.$cuenta["email"].'</td>
					<td align="center">'.count($trabajos).'</td>
					<td>'.$cuenta["clave"].'</td>
					<td>'.$cuenta["fecha"].'</td>
					<td>'.($cuenta["eliminado"]?"No":"Si").'</td>
					<td nowrap>';
						if($core->canEdit())
							echo '<a href="'.$config['url_base'].'cuenta/actions/login.php?key='.base64_encode($cuenta['id']).'" target="_blank"><i class="fa fa-external-link"></i></a> &nbsp;';
					echo '</td>
				  </tr>
				';

			}
		?>
        	</tbody>
        </table>
    </div>
</div>
	<br>
    
</form>