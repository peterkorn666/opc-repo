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
	"bootstrap/css/bootstrap.min.css"=>"css",
	"estilos/font-awesome.min.css"=>"css",
	"estilos/custom.css"=>"css",
);
$tpl->SetVar('headers',$headers);

if(!empty($_POST["key"]))
{
	$core->bind("nombre",$_POST["nombre"]);
	$core->bind("key",$_POST["key"]);
	$sql = $core->query("UPDATE areas SET Area=:nombre WHERE ID_Areas=:key");
}else if(!empty($_POST["nombre"])){
	$core->bind("nombre",$_POST["nombre"]);
	$sql = $core->query("INSERT INTO areas (Area) VALUES (:nombre)");	
	if(count($sql) > 0)
	{
		if(!empty($_GET["p"]))
		{
			echo "<script type='text/javascript'>";
				echo 'var x = window.opener.document.getElementById("area_crono");';				
				echo 'var option = document.createElement("option");';
				echo 'option.text = "'.$_POST["nombre"].'";';
				echo 'var sel = x.options[x.selectedIndex];';
				echo 'x.add(option, sel);';
				echo 'window.close();';
			echo "</script>";
		}
	}
	
}else if($_GET["del"]){
	$core->bind("key",$_GET["del"]);
	$sql = $core->query("DELETE FROM areas WHERE ID_Areas=:key");
}

if(!empty($_GET["key"])){
	$sql = $core->query("SELECT * FROM areas WHERE ID_Areas='".$_GET["key"]."'");
	$row = $sql[0];
}
?>
<h3>Areas</h3>
<div class="row">
	<div class="col-md-6">
    	<form action="<?=$config["url_opc"]?>?page=areasCasilleroManager&p=1" method="post" onSubmit="return validar()">			<label>Nombre</label>
			<div class="input-group">
              <input type="text" id="nombre" name="nombre" class="form-control" value="<?=$row["Area"]?>">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="Guardar">
              </span>
            </div>                    
            <input type="hidden" id="key" name="key" value="<?=$row["ID_Areas"]?>">
            <input type="hidden" id="p" name="p" value="<?=$_GET["p"]?>">
        </form>
    </div>
<?php
if(empty($_GET["p"]))
{
?>    
    <div class="col-md-6" style="max-height:400px; overflow:auto;">
    	<table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#000000">
			<?php
                $sql = $core->query("SELECT * FROM areas ORDER BY Area");
                foreach($sql as $a)
                {
                 echo '<tr>';
				 	echo '	<td width="20" bgcolor="#FFFFFF">';
						if($core->canDel())
							echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&del='.$a["ID_Areas"].'" onclick="return confirm(\'Desea eliminar '.$a["Area"].'?\')"><i class="fa fa-trash" style="font-size:16px"></i></a>';
				echo '</td>';
				 	echo '<td bgcolor="#FFFFFF">';
						if($core->canEdit())
							echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&key='.$a["ID_Areas"].'" style="font-weight:bold;">'.$a["Area"].'</a>';
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
function validar()
{
	if($("input[name='nombre']").val()=="")
	{
		alert("Escriba un nombre");
		return false;
	}
}
</script>

