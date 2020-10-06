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

if(!empty($_POST["key"]) && $core->canEdit())
{
	$core->bind("nombre",$_POST["nombre"]);
	$core->bind("key",$_POST["key"]);
	$sql = $core->query("UPDATE tematicas SET Tematica=:nombre WHERE ID_Tematicas=:key");
}else if(!empty($_POST["nombre"]) && $core->canEdit()){
	$core->bind("nombre",$_POST["nombre"]);
	$sql = $core->query("INSERT INTO tematicas (Tematica) VALUES (:nombre)");	
	if(count($sql) > 0)
	{
		if(!empty($_GET["p"]))
		{
			echo "<script type='text/javascript'>";
				echo 'var x = window.opener.document.getElementById("tematica_crono");';				
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
	$sql = $core->query("DELETE FROM tematicas WHERE ID_Tematicas=:key");
}

if(!empty($_GET["key"])){
	$sql = $core->query("SELECT * FROM tematicas WHERE ID_Tematicas='".$_GET["key"]."'");
	$row = $sql[0];
}
?>
<h3>Tematicas</h3>
<div class="row">
	<div class="col-md-6">
    	<form action="<?=$config["url_opc"]?>?page=tematicasCasilleroManager<?php if($_GET["p"]){echo "&p=1";}?>" method="post" onSubmit="return validar()">
        	<label>Nombre</label>
			<div class="input-group">
              <input type="text" id="nombre" name="nombre" class="form-control" value="<?=$row["Tematica"]?>">
              <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" value="Guardar">
              </span>
            </div>                    
            <input type="hidden" id="key" name="key" value="<?=$row["ID_Tematicas"]?>">
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
                $sql = $core->query("SELECT * FROM tematicas ORDER BY Tematica");
                foreach($sql as $a)
                {
                 echo '<tr>';
				 	echo '	<td width="20" bgcolor="#FFFFFF">';
						if($core->canDel())
							echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&del='.$a["ID_Tematicas"].'" onclick="return confirm(\'Desea eliminar '.$a["Tematica"].'?\')"><i class="fa fa-trash" style="font-size:16px"></i></a>';
					echo '</td>';
				 	echo '<td bgcolor="#FFFFFF">';
						echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&key='.$a["ID_Tematicas"].'" style="font-weight:bold;">'.$a["Tematica"].'</a>';
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

