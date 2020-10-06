<?php
session_start();
if (!$_SESSION["etiquetas"]["admin"]){
	header("Location: ../../login_etiquetas.php");
	die();
}
require("../../init.php");
require("../class/inscripcion.class.php");
require("../../inscripcion/clases/lang.php");
require("../class/util.class.php");
require("../class/estadisticas.class.php");
$util = new Util();
$inscripcion = new Inscripcion();
$estadisticas = new Estadisticas();
$lang = new Language("es");
//$listados = $inscripcion->litado();
$config = $inscripcion->getConfig();
$maximo_titulos = $lang->set["MAXIMO_TITULO"]["array"];
$tipos_documentos = $lang->set["TIPOS_DOCUMENTOS"]["array"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Etiquetas de inscriptos</title>
<link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/datatables.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/custom.css" rel="stylesheet">
<link type="text/css" href="estilos.css" rel="stylesheet">
</head>
<body>
<?php
if($_SERVER["SERVER_NAME"] == "beta-alas2017.easyplanners.info"):
?>
<div id="beta-alert"></div>
<?php
endif;
?>

<div class="container-fluid">
	<div class="row">
    	<div class="col-xs-12 text-center"><img src="../imagenes/logo.jpg" style="width:580px;height:110px"></div>
    </div>
    <div class="row">
    	<div class="col-xs-12">
        	<h3>Listado de inscriptos</h3>
            
            <!--<p align="right"><a id="cerrar_sesion" href="#">Cerrar sesión</a></p>
        	<br>-->
            <table class="table" id="etiquetas-inscriptos" style="font-size:18px; width:1527;">
                <thead>
                  <tr>
                  	<th>Estado</th>
                    <th>Cuenta</th>
                    <th>N&deg; Recibo</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Documento</th>
                    <th>Email</th>
                    <th>Trabajos</th>
                  </tr>
                </thead>
                <tfoot>
                    <tr>
                    	<th></th>
                        <th>Cuenta</th>
                        <th>N&deg; Recibo</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Documento</th>
                        <th>Email</th>
                        <th>Trabajos</th>
                    </tr>
                </tfoot>
                <tbody>
        <?php
		$h = 0;
		$listados = $inscripcion->litadoConTrabajos();
        foreach($listados as $listado){
        ?>      
                  <tr>
                  	<td class="td_inscripto">
						<?php
                        	if(!$listado["estado"]){
								echo '<span class="hide">Pago pendiente</span>';
								echo '<div class="circle-red persona-inscripto" data-id="'.$listado["id"].'" data-ins="1" style="cursor: pointer;" align="center"></div>';
							}else{
								echo '<span class="hide">Pago aprobado</span>';
								echo '<div class="circle-green persona-inscripto" data-id="'.$listado["id"].'" data-ins="0" style="cursor: pointer;" align="center"></div>';
							}
						?>
                    </td>
                    <td align="center"><?=$listado["id_cuenta"]?></td>
                    <td align="center"><?php if ($listado["numero_recibo"]) echo (int) $listado["numero_recibo"]; ?></td>
                    <td><?=$listado["nombre"]?></td>
                    <?php if ($listado["estado"] == '1' && $listado["material"] == '0') {?>
                    <td><a href="../../crear_etiqueta.php?id=<?=base64_encode($listado["id"])?>" target="_blank"><?=$listado["apellido"]?> <?=$listado["apellido2"]?></a></td>
                    <?php } else { ?>
                    <td><?=$listado["apellido"]?> <?=$listado["apellido2"]?></td>
                    <?php } ?>
                    <td><?=$tipos_documentos[$listado["tipo_documento"]]?> <?=$listado["numero_pasaporte"]?></td>
                    <td><?=$listado["email"]?></td>
                    <td align="center" valign="center"><?php 
						echo $listado["trabajos"];
					/*if ($listado["id_cuenta"])
						echo $inscripcion->getInscriptosTrabajos($listado["id_cuenta"]);
					else
						echo "";*/
					?></td>
                  </tr>
        <?php
			/*if($h == 100)
				break;
			$h++;*/
        }
        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/jquery-1.12.4.js"></script>
<script type="text/javascript" src="../js/datatables.min.js"></script>
<script type="text/javascript" src="js/consulta.js"></script>
<script>
	$("#cerrar_sesion").click(function(e){
		e.preventDefault();
		/*document.location.href = "../../login_etiquetas.php";*/
	});
</script>
</body>
</html>