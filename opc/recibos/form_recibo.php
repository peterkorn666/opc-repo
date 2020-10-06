<?php
if(!isset($_GET["key"]) || $_GET["key"]==''){
	header("Location: login.php");
	die;
}
require("../init.php");
require("clases/Config.class.php");
require("clases/DB.class.php");
require("clases/lang.php");
require("clases/inscripcion.class.php");
$inscripcion = new Inscripcion();
$lang = new Language("es");
$config = $inscripcion->getConfig();
$db = \DB::getInstance();
$inscripto = $db->query("SELECT * FROM inscriptos WHERE MD5(CONCAT(id, email)) = ?", [$_GET["key"]])->first();
if(count($inscripto) == 0){
	header("Location: login.php?error=2");
	die;
}
$inscripto_recibos = $inscripcion->getRecibos($inscripto["id"]);
$costo_inscripcion = $lang->getValue($lang->set["COSTOS_INSCRIPCION"]["array"][$inscripto["costos_inscripcion"]], 1);
$recibo = array();
if($_GET["r"]){
	$recibo = $inscripcion->getRecibo($_GET["r"]);
}

if(count($_POST) > 0) {
	$key_recibo = $_POST["key_recibo"];
	$importe_post = str_replace(",",".",$_POST["importe"]);
	$descuento_post = str_replace(",",".",$_POST["descuento"]);
	$datos = array(
		"id_inscripto" => (int)$inscripto["id"],
		"numero_recibo" => $_POST["numero_recibo"],
		"recibo_a" => $_POST["recibo_a"],
		"documento" => $_POST["documento"],
		"email" => $_POST["email"],
		"numero_autorizacion" => $_POST["numero_autorizacion"],
		"importe" => (float)$importe_post,
		"descuento" => (float)$descuento_post,
		//"comprobante" => $_POST["comprobante"],
		"forma_pago" => (int)$_POST["forma_pago"],
		"comentarios" => $_POST["comentarios"],
		"fecha" => date("Y-m-d", strtotime($_POST["fecha_recibo"]))
	);
	if($key_recibo!=""){
		$sql = $db->update("inscriptos_recibo", "id=".$key_recibo, $datos);
		//$recibos_inscripto = $db->query("SELECT GROUP_CONCAT(numero_recibo SEPARATOR ', ') as numero_recibo FROM inscriptos_recibo WHERE id_inscripto=". $inscripto["id"])->first();
	}else{
		if(empty(trim($datos["numero_recibo"]))){
			$last_recibo = $db->query("SELECT MAX(numero_recibo)+1 as numero_recibo FROM inscriptos_recibo LIMIT 1")->first();
			if($last_recibo["numero_recibo"] === NULL)
				$datos["numero_recibo"] = 1;
			else
				$datos["numero_recibo"] = $last_recibo["numero_recibo"];
		}
		
		$sql = $db->insert("inscriptos_recibo", $datos);
		//$recibos_inscripto = $db->query("SELECT GROUP_CONCAT(numero_recibo SEPARATOR ', ') as numero_recibo FROM inscriptos_recibo WHERE id_inscripto=". $inscripto["id"])->first();
	}
	if($sql)
	{
		header('Location: form_recibo.php?success=1&key='.$_GET["key"]);
		return false;
	}else {
		header('Location: form_recibo.php?error=1&key='.$_GET["key"]);
		return false;
	}
}

if ($_GET["error"] == 1) {
	echo "<div class='row'>
			<div class='col-xs-6 col-lg-offset-2 col-md-6 col-lg-7 text-center alert alert-danger'>
				No se ha podido realizar el recibo
			</div>
		  </div>";
}
if ($_GET["success"] == 1) {
	echo "<div class='row'>
			<div class='col-xs-6 col-lg-offset-2 col-md-6 col-lg-7 text-center alert alert-success'>
				El recibo fue guardado
			</div>
		  </div>";
}

if ($_GET["e"] == 1) {
	echo "<div class='row'>
			<div class='col-xs-6 col-lg-offset-2 col-md-6 col-lg-7 text-center alert alert-success'>
				Se envio el email correctamente.
			</div>
		  </div>";
}
if ($_GET["pago"] == 1) {
	echo "<div class='row'>
			<div class='col-xs-6 col-lg-offset-2 col-md-6 col-lg-7 text-center alert alert-success'>
				Se aprobó el pago correctamente.
			</div>
		  </div>";
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Recibo</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link type="text/css" href="css/boostrap.css" rel="stylesheet">
<link type="text/css" href="css/custom.css" rel="stylesheet">
<link type="text/css" href="css/beta-alert.css" rel="stylesheet">
</head>

<form action="form_recibo.php?key=<?php echo $_GET["key"]?>" id="form_recibo" method="post">
<div align="center"><img src="../imagenes/banner.jpg" style="width:580px;height:110px"></div>
<div class="container">
	<div class="col-xs-12 col-md-4 col-lg-4">
        <div class="row">
            <div class="col-md-12">
                <label>Nombre: </label>
                <strong><?php echo $inscripto["nombre"] . " " . $inscripto["apellido"] ?></strong>
            </div>
            <br>
            <div class="col-md-12">
                <label>Email: </label>
                <strong><?php echo $inscripto["email"] ?></strong>
            </div>
            <!--<br>
            <div class="col-md-12">
                <label>Nombre del Recibo: </label><br>
                <strong><?php //echo $inscripto["nombre_recibo"] ?></strong>
            </div>-->
            <div class="col-md-12">
                <label>Forma de pago: </label>
                <strong>
				<?php
					$forma_pago = $inscripcion->getOpcionFormaPagoByID($inscripto["forma_pago"]);
					echo $forma_pago["nombre"];
					//echo $lang->getValue($lang->set["FORMA_PAGO"]["array"][$inscripto["forma_pago"]]);
				?></strong>
            </div>
       </div>
       
        <div class="row">
        	<div class="col-xs-12">
            	Recibos:<br>
                <?php 
					foreach($inscripto_recibos as $r){
						if($r["pago"]==0){
							$estado = 1;
							$circle = 'red';
						}else{
							$estado = 0;
							$circle = 'green';
						}
						echo "<a href='?key=".$_GET["key"]."&r=".$r["id"]."'>";
						echo "N&deg;: ";
						if ($r["numero_recibo"]!=''){
							echo  $r["numero_recibo"] . " ";
						} else {
							echo $r["id"] . " ";
						}
						echo " - USD ".($r["importe"]-$r["descuento"]);
						echo "</a> &nbsp;";
						
						$estado_recibo = $r["pago"];
						echo "<a href='aprobar_recibo.php?key=".$_GET["key"]."&rec=".base64_encode($r["id"])."&estado=".$estado_recibo."' style='color:red'>";
						if($estado_recibo === '1')
							echo "[desaprobar recibo]";
						else if($estado_recibo === '0')
							echo "[aprobar recibo]";
						echo "</a> &nbsp;&nbsp;&nbsp;";
						
						/*echo "<a href='recibo/recibo.php?k=".base64_encode($r["id"])."' target='blank' style='color:red'>";
						echo "[ver recibo pdf]";
						echo "</a> &nbsp;&nbsp;&nbsp;";
						echo '<a href="recibo/recibo.php?k='.base64_encode($r["id"]).'&enviar=1" target="blank" style="color:red">';
						echo "[enviar email]";*/
						echo "</a> &nbsp;&nbsp;&nbsp;<br>";
						
					}
					echo "<br>";
					echo "<br>";
					/*$btn_pago = '<a href="aprobar_pago.php?key='.$_GET["key"].'&id='.$r["id"].'&estado='.$estado.'" class="btn btn-danger">Aprobar pago</a>';*/
					$btn_pago = "";
					$pago_estado = $db->get("inscriptos_recibos_pagos", array("id_inscripto", "=", (int)base64_decode($inscripto["id"])))->count();
					if($pago_estado){
						//$btn_pago = '<a href="http://alas2017.easyplanners.info/crear_etiqueta.php?id='.$inscripto["id"].'" class="btn btn-info" target="_blank">Imprimir etiqueta</a> ' . ($inscripto["material"] ? '<b>Ya entregado</b>' : '') . ' <br><br>';

						$btn_pago .= '<a href="javascript:void(0)" class="btn btn-success disabled">Pago ya aprobado</a>';
					}
					echo $btn_pago;
					echo "<br>";
					
				?>
            </div>
        </div>
   </div>
   <div class="col-xs-12 col-md-6 col-lg-6">
        <div class="row">
        	<!--<div class="col-md-2">
                <label>N&deg;: </label> <input type="text" name="numero_recibo" class="form-control" value="<?php /*echo $recibo["numero_recibo"];*/ ?>">
            </div>-->
        	<div class="col-md-4">
            	
                <label>Recibo a: </label> <input type="text" name="recibo_a" class="form-control" value="<?php
				/*echo ($recibo["recibo_a"] ? $recibo["recibo_a"] : sprintf('%s %s', $inscripto["nombre"], $inscripto["apellido"]));*/
				if ($recibo["recibo_a"]){
					echo $recibo["recibo_a"];
				} else if ($inscripto["nombre_recibo"]) {
					echo $inscripto["nombre_recibo"];
				} else {
					echo sprintf('%s %s', $inscripto["nombre"], $inscripto["apellido"]);
				}
				 ?>">
            </div>
            <div class="col-md-3">
                <label>Documento: </label> <input type="text" name="documento" class="form-control" value="<?php echo ($recibo["documento"] ? $recibo["documento"] : $inscripto["numero_pasaporte"]); ?>">
            </div>
            <div class="col-md-3">
                <label>N&deg; recibo: </label> <input type="text" name="numero_recibo" class="form-control" value="<?php echo $recibo["numero_recibo"] ?>">
            </div>
            
       </div>
        <div class="row">  
            <div class="col-md-3">
                <label>Importe: </label> <input type="text" name="importe" class="form-control" value="<?php echo (isset($recibo["importe"]) ? $recibo["importe"] : $costo_inscripcion) ?>">
            </div>
            <div class="col-md-3">
                <label>Descuento: </label> <input type="text" name="descuento" class="form-control" value="<?php echo $recibo["descuento"]; ?>">
            </div>
            <div class="col-md-4">
                <label>Fecha: </label> <input type="text" name="fecha_recibo" class="form-control" value="<?php 
				if ($recibo["fecha"])
					if ($recibo["fecha"] != "0000-00-00")
						echo date("d-m-Y", strtotime($recibo["fecha"]));
					else
						echo "";
				else
					echo "";
				?>">
            </div>
        </div>
        <div class="row">
            <!--<div class="col-md-7">
                <label>Dirección: </label> <input type="text" name="direccion" class="form-control" value="<?php
				if($recibo["direccion"])
					echo $recibo["direccion"];
				else
					echo "";
				?>">
            </div>-->
            <div class="col-md-3">
                <label>N&deg; autorizaci&oacute;n: </label> <input type="text" name="numero_autorizacion" class="form-control" value="<?php echo ($recibo["numero_autorizacion"] ? $recibo["numero_autorizacion"] : $inscripto["numero_autorizacion"]); ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <label>Forma de Pago: </label><br>
                <?php
				foreach($lang->set["FORMA_PAGO"]["array"] as $key => $value)
				{
					$habilitado = $lang->getValue($value, 1);
					$values = $lang->getValue($value);
					if($recibo["forma_pago"]==$key)
						$chk = "checked";
					if($habilitado=="habilitado" || $habilitado=="oculto"){
						echo "<input type='radio' name='forma_pago' $chk value='$key'> $values<br>";
					}
					$chk = "";
				}
				?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <label>Comentarios</label>
                <textarea name="comentarios" class="form-control"><?php echo $recibo["comentarios"] ?></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <label>SubTotal</label>
             </div>
             <div class="col-md-9">
                <strong id="txt_subtotal"></strong>
             </div>
         </div>
         <div class="row">
             <div class="col-md-3">
                <label>Descuento</label>
             </div>
             <div class="col-md-9">
             	<strong id="txt_descuento"></strong>
             </div>
         </div>
         <div class="row">    
             <div class="col-md-3">
                <label>Total</label>
             </div>
             <div class="col-md-9">
                <strong id="txt_total"></strong>
             </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="submit" value="Guardar Recibo" class="btn btn-primary"> &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="?key=<?php echo $_GET["key"]?>">Nuevo Recibo</a>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="subtotal" value="0">
<input type="hidden" name="total" value="0">
<input type="hidden" name="key_recibo" value="<?php echo $recibo["id"];?>">
<input type="hidden" name="email" value="<?php echo $inscripto["email"];?>">
</form>


</body>
</html>
<script type="text/jscript" src="js/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function(e) {
	$("input[name='fecha_recibo']").datepicker({dateFormat: "dd-mm-yy"});
    calc();
	if ($("input[name='descuento']").val() == "") {
		$("input[name='descuento']").val("0");
	}
	$("input[name='importe'], input[name='descuento']").keyup(function(){
		calc();
	})
	$("#form_recibo").submit(function(){
		/*if ($("input[name='numero_recibo']").val() == "") {
			alert("Debe completar el campo del número de recibo.");
			return false;
		}*/
		if ($("input[name='recibo_a']").val() == "") {
			alert("Debe completar a nombre de quien está el recibo.");
			return false;
		}
		if ($("input[name='documento']").val() == "") {
			alert("Debe completar el documento del recibo.");
			return false;
		}
		if ($("input[name='numero_autorizacion']").val() == "") {
			alert("Debe completar el número de autorización del recibo.");
			return false;
		}
		if ($("input[name='importe']").val() == "") {
			alert("Debe completar el importe del recibo.");
			return false;
		}
		if ($("input[name='descuento']").val() == "") {
			$("input[name='descuento']").val("0");
		}
		if ($("input[name='fecha_recibo']").val() == "") {
			alert("Debe completar la fecha del recibo.");
			return false;
		}
		if ($("input[name='forma_pago']:checked").val() === "" || $("input[name='forma_pago']:checked").val() === undefined) {
			alert("Debe completar la forma de pago del recibo.");
			return false;
		}
	})
});

function calc(){
	var importe = $("input[name='importe']").val().replace(",", ".") || 0;
	var descuento = $("input[name='descuento']").val().replace(",", ".") || 0;

	var subtotal = importe;
	var total = importe-descuento;
	
	$("#txt_descuento").html('U$S ' + descuento);
	$("#txt_subtotal").html('U$S ' + subtotal);
	$("#txt_total").html('U$S ' + total);
	
	$("input[name='subtotal']").val(subtotal);
	$("input[name='total']").val(total);
	
	
}


</script>
<?php
function guardar() {
	//
}
?>