<?php
/**
 * User: Hansz
 * Date: 1/4/2016
 * Time: 15:56
 */
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
/*$headers = array(
	"css"=>"estilos/cronograma.css"
);
$tpl->SetVar('headers',$headers);*/
if($_GET['key'] && $core->canEdit()){
	$sala = $core->getSalaID(base64_decode($_GET['key']));
}
$salas = $core->getSalas();
echo $core->messages($_GET['status']);
?><br><br>
<div class="row">
	<div class="col-xs-6">
		<form action="<?=$config["url_opc"]?>actions/?page=<?=$_GET["page"]?>" method="post">
			<div class="input-group">
            	<span class="input-group-btn">
                	<select class="form-control" name="orden" required style="width:60px">
                    	<option value=""></option>
                        <?php
						for($i=1;$i<=(count($salas)+3);$i++){
							if($sala["orden"]==$i)
								$chk = "selected";
							echo "<option value='$i' $chk>$i</option>";
							$chk = "";
						}
						?>
                    </select>
                </span>
				<input type="text" class="form-control" required name="name" value="<?php echo $sala['name']?>">
				<span class="input-group-btn">
					<input class="btn btn-default" type="submit" value="Guardar">
				</span>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<label>Hacer esta sala visible al público?</label> &nbsp;&nbsp;
					<input type="checkbox" name="sala_visible" value="1" <?php if($sala['visible']){echo 'checked';}?>>
				</div>
			</div>
			<input type="hidden" name="key" value="<?php echo base64_encode($sala['salaid'])?>">
		</form>
	</div>
	<div class="col-xs-6">
		<table class="table">
			<thead>
				<th>&nbsp;</th>
				<th>ID</th>
				<th>Nombre</th>
			</thead>
			<?php
				foreach($salas as $sala) {
			?>
					<tr>
						<td>
                        	<?php if($core->canDel()){ ?>
                        	<a href="<?=$config["url_opc"]?>actions/?page=<?=$_GET["page"]?>&del=<?=base64_encode($sala["salaid"])?>" title="eliminar" class="delete"><i class="fa fa-trash" style="font-size:16px"></i></a>
                            <?php } ?>
                        </td>
						<td><a href="<?=$config["url_opc"]?>?page=<?=$_GET["page"]?>&key=<?=base64_encode($sala["salaid"])?>" title="modificar"><?php echo $sala['salaid'] ?></a></td>
						<td><a href="<?=$config["url_opc"]?>?page=<?=$_GET["page"]?>&key=<?=base64_encode($sala["salaid"])?>" title="modificar"><?php echo $sala['name'] ?></a></td>
                        <td><a href="<?=$config["url_opc"]?>?page=<?=$_GET["page"]?>&key=<?=base64_encode($sala["salaid"])?>" title="modificar"><?php echo $sala['orden'] ?></a></td>
					</tr>
			<?php
				}
			?>
		</table>
	</div>
</div>