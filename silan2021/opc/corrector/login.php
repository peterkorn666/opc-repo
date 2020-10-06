<?php
session_start();
header("Cache-Control: private, no-cache, must-revalidate");
header("Pragma: no-cache");

if($_SESSION["corrector"]["Login"] == "Logueado"){
    if($_SESSION["corrector"]["nivel"] == 1){
        header("Location: admin.php");die();
    }else if($_SESSION["corrector"]["nivel"] == 2){
        header("Location: personal.php");die();
    }
}

include("../../init.php");
include("clases/Auxiliar.php");
$auxiliar_instancia = new Auxiliar();
$config = $auxiliar_instancia->getConfig();

$_SESSION["pasos"]=1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Evaluadores - <?=$config['nombre_congreso']?></title>
    <link href="../../bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <style>
		.div-formulario{
			margin-bottom: 15px;
		}
	</style>
    <!--<link href="estilos.css" type="text/css" rel="stylesheet" />-->
</head>
<body>
	<div class="container" style="text-align: center;">
        <div align="center">
            <div class="col-md-10">
                <form id="form1" name="form1" action="login02.php" method="post" onsubmit="return validarLogin()">
                    <div class="col-md-12">
                        <?php
                        include("include/include_image.php");
                        ?>
                    </div>
                    <br />
                    <div class="col-md-10" style="background-color: #028DC8; color: #FFFFFF;">
                        Ingrese su email y contrase&ntilde;a para realizar las evaluaciones (arbitraje).
                    </div>
                    <br />
                    <?php
                    if($_GET["error"] == true){
                        ?>
                        <div class="col-md-10 alert alert-danger">
                            El usuario y/o contrase&ntilde;a son incorrectos.
                        </div>
                        <br />
                        <?php
                    }
                    ?>
                    <div class="col-md-8">
                        <div class="row div-formulario">
                            <div class="col-md-4 text-left">
                                Usuario:
                            </div>
                            <div class="col-md-8 text-left">
                                <input type="text" name="txtUsuario" class="form-control" />
                            </div>
                        </div>
                        <div class="row div-formulario">
                            <div class="col-md-4 text-left">
                                Contraseña:
                            </div>
                            <div class="col-md-8 text-left">
                                <input type="password" name="txtPassword" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" value="Conectarse" class="btn btn-primary btn-block" />
                            </div>
                        </div><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script language="javascript">
	function validarLogin() {
		/*CONTROL DE USUARIO*/
		var user = $("input[name='txtUsuario']");
		if (user.val() == ""){
			alert("No ha ingresado ningún usuario.");
			user.focus();
			return false;
		}
		/*CONTROL DE PASSWORD*/
		var password = $("input[name='txtPassword']");
		if (password.val() == ""){
			alert("No ha ingresado ningún usuario.");
			password.focus();
			return false;
		}
		return true;
	}
</script>