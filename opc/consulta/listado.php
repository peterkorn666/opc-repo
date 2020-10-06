<?php
require("../../init.php");
require("../class/inscripcion.class.php");
require("../class/util.class.php");
$util = new Util();
$inscripcion = new Inscripcion();
$util->isLogged();
$config = $inscripcion->getConfig();
$db = \DB::getInstance();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Consulta</title>
<link type="text/css" href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/datatables.min.css" rel="stylesheet">
<link type="text/css" href="../estilos/custom.css" rel="stylesheet">
<style type="text/css">
.green{
	border:1px solid green;
}
</style>
</head>
<body>
<div class="container">
	<div class="row">
    	<div class="col-xs-12 text-center"><img src="<?=$config["banner_congreso"]?>"></div>
    </div><br>
    <br>
    
        <?php
		$cuentas = $db->query("SELECT id, nombre, apellido, email FROM cuentas ORDER BY id DESC")->results();
        foreach($cuentas as $cuenta){
			$autores = $db->query("SELECT * FROM cuenta_autores as c JOIN trabajos_libres_participantes as l ON l.ID_participante=c.id_autor JOIN trabajos_libres as t ON t.id_trabajo= l.ID_trabajos_libres JOIN personas_trabajos_libres as p ON l.ID_participante=p.ID_Personas WHERE c.id_cuenta=?", [$cuenta["id"]])->results();
			if(count($autores)>0){
		?>
        		<div class="row" style="border:1px solid">
                    <div class="col-xs-12">
                        <?php
                            echo sprintf("Cuenta: %s %s %s", $cuenta["nombre"], $cuenta["apellido"], $cuenta["email"]);
                        ?>
                    </div>
        
        			<?php	
					$inscriptos = $db->query("SELECT id, nombre, apellido, email FROM inscriptos WHERE id_cuenta=?", [$cuenta["id"]])->results();		
					foreach($inscriptos as $inscripto){
					?>
                		<div class="col-xs-11 col-xs-offset-1" style="border:1px solid red;">
                    	<?php
                        	echo sprintf("Inscripto: %s %s %s", $inscripto["nombre"], $inscripto["apellido"], $inscripto["email"]);
                    	?>
                		</div>
        			<?php	
					}
					?>
                    <div class="col-xs-11 col-xs-offset-1">
                    <?php
					foreach($autores as $autor){
						$class = "";
						if($autor["revisar"]=="0")
							$class = "green";
						echo "<div class='col-xs-12 . $class'>".$autor["numero_tl"]. " ".$autor["Nombre"]. " ".$autor["Apellidos"]."</div>";
					}
					?>
                    </div>
        </div>
        <?php
			}
		?>
        
        <?php
		}
        ?>
        
</div>
<script type="text/javascript" src="../js/datatables.min.js"></script>
<script type="text/javascript" src="js/consulta.js"></script>
</body>
</html>