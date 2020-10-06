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
	"estilos/custom.css"=>"css",
	"estilos/farbtastic.css"=>"css",
	"js/farbtastic.js"=>"js",	
);
$tpl->SetVar('headers',$headers);

$colores = array("#FFFFFF","#FFEAEA","#FFBFBF","#FF9595","#FF6A6A","#FF4040","#FFEED5","#FFDDAA","#FFCC80","#FFBB55","#FFAA2B","#FFE700","#E9E9E9","#FFFFD5","#FFFFAA","#FFFF80","#FFFF55","#FFFF2B","#E4F1E2","#CAE3C6","#B0D5AA","#96C78D","#7BB971","#8DC641","#CCCCCC","#EAFFFE","#BFFFFC","#95FFFA","#6AFFF8","#00E1D6","#D5E4FF","#AAC8FF","#80ACFF","#5591FF","#2B75FF","#0094DA","#999999","#ECD5FF","#D9AAFF","#C680FF","#B355FF","#9F2BFF","#FFD5F0","#FFAAE1","#FF80D2","#FF55C4","#FF2BB5","#E91D26","#666666","#F1EAE2","#E3D6C6","#D5C1AA","#C7AB8D","#B99771","#F0F2E1","#E1E6C4","#D1D9A6","#C1CC88","#B3BF6A","#879149");

if(!empty($_GET["key"])){
	$sql = $core->query("SELECT * FROM tipo_de_actividad WHERE id_tipo_actividad='".$_GET["key"]."'");
	$row = $sql[0];
}

if(!empty($_POST["key"]) && $core->canEdit())
{
	$core->bind("nombre",$_POST["nombre"]);
	$core->bind("color",$_POST["hex"]);
	$core->bind("key",$_POST["key"]);
	$sql = $core->query("UPDATE tipo_de_actividad SET tipo_actividad=:nombre, color_actividad=:color WHERE id_tipo_actividad=:key");
}else if(!empty($_POST["nombre"]) && !empty($_POST["hex"]) && $core->canEdit()){
	$core->bind("nombre",$_POST["nombre"]);
	$core->bind("color",$_POST["hex"]);
	$sql = $core->query("INSERT INTO tipo_de_actividad (tipo_actividad, color_actividad) VALUES (:nombre,:color)");	
	if(count($sql) > 0)
	{
		if(!empty($_GET["p"]))
		{
			
			echo "<script type='text/javascript'>";
				echo 'var x = window.opener.document.getElementById("tipo_actividad_crono");';				
				echo 'var option = document.createElement("option");';
				echo 'option.value = "'.$core->getLastID().'";';
				echo 'option.text = "'.$_POST["nombre"].'";';
				echo 'option.style.backgroundColor = "'.$_POST["hex"].'";';
				echo 'var sel = x.options[x.selectedIndex];';
				echo 'x.add(option, sel);';
				echo 'window.close();';
			echo "</script>";
		}
	}
	
}else if($_GET["del"]){
	$core->bind("key",$_GET["del"]);
	$sql = $core->query("DELETE FROM tipo_de_actividad WHERE id_tipo_actividad=:key");
	//sql_query($sql);
}
?><br>
<h3>Tipos de Actividad</h3>
<div class="row">
	<div class="col-md-6">
    	<form action="<?=$config["url_opc"]?>?page=tipoActividadesManager&p=<?=$_GET["p"]?>" method="post" onSubmit="return validar()">
        	<table width="100%" border="0" cellpadding="8" cellspacing="0">
              <tr>
                <td colspan="2">
                	<label>Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" style="background-color:<?=$row["color_actividad"]?>" value="<?=$row["tipo_actividad"]?>"><br></td>
              </tr>
              <tr>
                <td width="480">
					<?php
						foreach($colores as $color)
							echo '<input name="" class="btn btn-color" type="button" style="border-color:#000000;background-color:'.$color.'; width:35px; height:35px; margin:2px;" data-color="'.$color.'"/>';
					?>	
                </td>
                <td><div id="colorpicker"></div></td>
              </tr>
            </table><br>
            <input type="hidden" name="hex" id="hex" value="<?=$row["color_actividad"]?>">
            <input type="hidden" id="key" name="key" value="<?=$row["id_tipo_actividad"]?>">
            <div class="col-md-8">
            	<input type="submit" class="btn btn-primary form-control" value="Guardar Tipo de Actividad">
            </div>
            <div class="col-md-4">
            	<input type="button" id="reset-form" class="btn btn-default form-control" value="Vaciar campos">
            </div>
        </form>
    </div>
<?php
if(empty($_GET["p"]))
{
?>    
    <div class="col-md-6" style="max-height:400px; overflow:auto;">
    	<table width="100%" border="0" cellpadding="8" cellspacing="0">
			<?php
                $act = $core->query("SELECT * FROM tipo_de_actividad ORDER BY tipo_actividad");
                foreach($act as $a)
                {
                 echo '<tr>';
				 	echo '	<td width="1">';
						if($core->canDel())
							echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&del='.$a["id_tipo_actividad"].'" onclick="return confirm(\'Desea eliminar '.$a["tipo_actividad"].'?\')"><i class="fa fa-trash" style="font-size:16px"></i></a>';
					echo '</td>';
				 	echo '	<td style="background-color:'.$a["color_actividad"].'">';
							echo '<a href="'.$config["url_opc"].'?page='.$_GET["page"].'&key='.$a["id_tipo_actividad"].'" style="font-weight:bold;">'.($a["tipo_actividad"]!=" "?$a["tipo_actividad"]:"sin nombre").'</a>';
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
  $(document).ready(function() {
    $('#colorpicker').farbtastic('#nombre');
  });
<?php
	if(!empty($row["color"])){
?>
		colorS = '<?=$row["color"]?>';
<?
	}else{
?>
		colorS = "#000000";
<?
	}
?>
</script>

