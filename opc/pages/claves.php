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
	header("Location: /");
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
	$core->bind("id",$_POST["key"]);
	$core->bind("usuario",$_POST["usuario"]);
	$core->bind("clave",$_POST["clave"]);
	$core->bind("administrador",($_POST["administrador"]?1:0));
	$core->bind("editar",($_POST["editar"]?1:0));
	$core->bind("eliminar",($_POST["eliminar"]?1:0));
	$update = $core->query("UPDATE claves SET 
										usuario=:usuario,
										clave=:clave,
										tipoUsuario=:administrador,
										edit=:editar,
										del=:eliminar
							WHERE ID_clave=:id
								 ");
}else if($_POST["usuario"]!="" && $_POST["clave"]!="" && $core->canEdit()){
	$core->bind("usuario",$_POST["usuario"]);
	$core->bind("clave",$_POST["clave"]);
	$core->bind("administrador",($_POST["administrador"]?1:"0"));
	$core->bind("editar",($_POST["editar"]?1:"0"));
	$core->bind("eliminar",($_POST["eliminar"]?1:"0"));
	$insert = $core->query("INSERT INTO claves (usuario, clave, tipoUsuario, edit, del) VALUES (:usuario, :clave, :administrador, :editar, :eliminar)");
	var_dump($insert);
}

if($_GET["key"]){
	$core->bind("id",$_GET["key"]);
	$usuario = $core->row("SELECT * FROM claves WHERE ID_clave=:id");
}
if($_GET["del"]){
	$core->bind("id",$_GET["del"]);
	$core->row("DELETE FROM claves WHERE ID_clave=:id");
}
?>
<h3>Usuarios OPC</h3>
<form action="index.php?page=claves" method="post">
<div class="row">
	<div class="col-xs-6">
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

	<div class="col-xs-6">
    	<table class="table">
        	<thead>
              <tr>
                <th>Usuario</th>
                <th>Clave</th>
                <th>Navegar</th>
                <th>Crear/Editar</th>
                <th>Eliminar</th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
    	<?php
			foreach($core->getClaves() as $claves){
				echo '
				  <tr>
					<td>'.$claves["usuario"].'</td>
					<td>'.$claves["clave"].'</td>
					<td>'.$claves["tipoUsuario"].'</td>
					<td>'.$claves["edit"].'</td>
					<td>'.$claves["del"].'</td>
					<td nowrap>';
						if($core->canEdit())
							echo '<a href="'.$config['opc_url'].'?page=claves&key='.$claves['ID_clave'].'"><i class="fa fa-pencil"></i></a> &nbsp;';
						if($core->canDel())
							echo '<a href="'.$config['opc_url'].'?page=claves&del='.$claves['ID_clave'].'"><i class="fa fa-trash"></i></a>';
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