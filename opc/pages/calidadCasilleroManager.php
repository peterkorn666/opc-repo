<?php
global $tpl;
$util = $tpl->getVar('util');
$util->isLogged();
$core = $tpl->getVar('core');
$templates = $tpl->getVar('templates');
$debug = $tpl->getVar('debug');
$core->Debug($debug);
if(!$core->isAdmin()){
	header("Location: /");
	die();
}
//DEFINE HEADERS
$headers = array(
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/custom.css"=>"css",
);
$tpl->SetVar('headers',$headers);

if(!empty($_POST["key"]))
{
	$core->bind("nombre",$_POST["nombre"]);
	$core->bind("nombre_solo",$_POST["nombre_solo"]);
	if(array_key_exists("plural", $_POST))
		$plural = 1;
	else
		$plural = 0;
	$core->bind("key",$_POST["key"]);
	$sql = $core->query("UPDATE calidades_conferencistas SET calidad=:nombre, calidad_solo=:nombre_solo, plural=".$plural." WHERE ID_calidad=:key");
}else if(!empty($_POST["nombre"])){
	$core->bind("nombre",$_POST["nombre"]);
	if(empty($_POST["nombre_solo"]) || $_POST["nombre_solo"] == "")
		$post_nombre_solo = $_POST["nombre"];
	else
		$post_nombre_solo = $_POST["nombre_solo"];
	$core->bind("nombre_solo",$post_nombre_solo);
	if(array_key_exists("plural", $_POST))
		$plural = 1;
	else
		$plural = 0;
	$sql = $core->query("INSERT INTO calidades_conferencistas (calidad, calidad_solo, plural) VALUES (:nombre, :nombre_solo, ".$plural.")");
	if(count($sql) > 0)
	{
		if(!empty($_GET["p"]))
		{
			$key = $core->getLastID();
			$nombre = $_POST["nombre"];
	?>			
			<script type='text/javascript'>
				window.opener.arrayCalidades.push({
						id:<?=$key?>,
						calidad:'<?=$nombre?>',
				});
				setTimeout(function()
				{
					window.opener.LoaderCalidades();
					window.close();
				},500)
			</script>
	<?php
		}
	}
	
}else if($_GET["del"]){
	$core->bind("key",$_GET["del"]);
	$sql = $core->query("DELETE FROM calidades_conferencistas WHERE ID_calidad=:key");
}

if(!empty($_GET["key"])){
	$sql = $core->query("SELECT * FROM calidades_conferencistas WHERE ID_calidad='".$_GET["key"]."'");
	$row = $sql[0];
}
?>
<a href="?page=calidadCasilleroManager">Nuevo</a>
<h3>Rol/Participación en calidad de</h3>
<div class="row">
	<div class="col-md-6">
    	<form action="<?=$config["url_opc"]?>?page=calidadCasilleroManager" method="post" onSubmit="return validar()">	
        	<div class="col-md-12">
            	<label>Nombre</label>
            	<input type="text" id="nombre" name="nombre" class="form-control" value="<?=$row["calidad"]?>"><br>               
            </div>
            <div class="col-md-12">
            	<label>Nombre singular</label>
            	<input type="text" id="nombre_solo" name="nombre_solo" class="form-control" value="<?=$row["calidad_solo"]?>"> <br>
            </div>
            <?php
			$chk = "";
			if($row["plural"] == 1)
				$chk = "checked";
			?>
            <div class="col-md-12 form-check" align="right" style="font-size: 14px;">
           		<label class="form-check-label" for="plural">Plural</label>
				<input type="checkbox" class="form-check-input" id="plural" name="plural" <?=$chk?> value="1">
			</div>
            <div class="col-md-12">
            	<input type="submit" class="btn btn-primary" value="Guardar">
            </div>
			<!--<div class="input-group">
              <input type="text" id="nombre" name="nombre" class="form-control" value="<?=$row["calidad"]?>">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="Guardar">
              </span>
            </div>-->                   
            <input type="hidden" id="key" name="key" value="<?=$row["ID_calidad"]?>">
        </form>
    </div>
<?php
if(empty($_GET["p"]))
{
?>    
    <div class="col-md-6" style="max-height:400px; overflow:auto;">
    	<table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#000000">
			<?php
                $sql = $core->query("SELECT * FROM calidades_conferencistas ORDER BY calidad");
                foreach($sql as $a)
                {
                 echo '<tr>';
				 	echo '	<td width="20" bgcolor="#FFFFFF">';
						if($core->canDel())
							echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&del='.$a["ID_calidad"].'" onclick="return confirm(\'Desea eliminar '.$a["calidad"].'?\')"><i class="fa fa-trash" style="font-size:16px"></i></a>';
					echo '</td>';
				 	echo '<td bgcolor="#FFFFFF">';
						if($core->canEdit())
							echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&key='.$a["ID_calidad"].'" style="font-weight:bold;">'.$a["calidad"].'</a>';
					echo '</td>';
				 echo '</tr>';
                }
            ?>
        </table>

    </div>
<?php
}
?>    
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("input[name='nombre_solo']").focus(function(){
		var nombre = $("input[name='nombre']").val();
		if(nombre && !this.value)
			this.value = nombre;
	});
});
function validar()
{
	if($("input[name='nombre']").val()=="")
	{
		alert("Escriba un nombre");
		return false;
	}
	if($("input[name='nombre_solo']").val()=="")
	{
		alert("Escriba el nombre en singular del rol");
		return false;
	}
}
</script>

