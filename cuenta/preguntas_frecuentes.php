<?php
require("../init.php");
require("class/cuenta.class.php");

$cuenta = new Cuenta(true);
$config = $cuenta->getConfig();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Preguntas frecuentes</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
<div class="container">
	<div class="row" align="center">
        <img src="<?=$config["banner_congreso"]?>" alt="<?=$lang["NOMBRE_CONGRESO"]?>" class="img-fluid" style="width:70%;max-width:500">
    </div><br><br>
    <div class="tgl">
        <div class="row">
                <h3 class="col-md-offset-3 col-lg-offset-3  col-sm-offset-0">Preguntas frecuentes</h3>
                 <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="font-size:16px">¿Cuál es la sede del congreso?</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="margin-left:20px">La sede principal del congreso ALAS 2017 será la I.M.M (Intendencia Municipal de Montevideo - Av. 18 de Julio 1360, 11200 Montevideo). <br>
    
    Además en diferentes Facultades de la UdelaR se realizaran presentaciones de ponencias. <br>
    
    Una de ellas, ya confirmada, es la Facultad de Ciencias Sociales - UdelaR (Constituyente 1502, 11200 Montevideo).</div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="font-size:16px">¿Cuál debe de ser la duración de la exposición oral de mi ponencia completa?</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="margin-left:20px">La exposición oral de las ponencias completas deberán tener una duración máxima de 10 minutos.</div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 ">
                        <div style="font-size:16px">¿Por qué no me llegan los email a mi cuenta?</div>
                        <div style="margin-left:20px">Hemos tenido dificultad con las direcciones de correo electrónico de la empresa hotmail.</div>
                    </div>
                 </div> <br>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="font-size:16px">¿Cómo veo si mi trabajo está Aceptado o Rechazado?</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="margin-left:20px">Ingresando <a href="login.php">aquí</a> con su respectiva cuenta (CON LA CUAL SE ENVIÓ EL RESÚMEN).<br>Además si fue Aceptado podrá descargar su Carta de Aceptación haciendo click sobre el nombre escrito en azul debajo del título del trabajo.</div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="font-size:16px">¿Cómo veo si mi panel está Aceptado o Rechazado?</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <div style="margin-left:20px">- El 01/06/2017 es el Cierre de postulación de Paneles. <br> - El 01/08/2017 la Comunicación de aceptación de Paneles</div>
                    </div>
                </div><br>
                <!--<div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <label>Si usted necesita recuperar su contraseña, ingrese <a href="#" id="btn-reset-password">aquí</a>.</label>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                        <label>Si no logró resolver su problema, <a href="contacto.php">contáctenos</a>.</label>
                    </div>
                </div><br>
                        <?php echo "<div class='col-sm-6 col-md-6 col-xs-6 col-lg-6'>&nbsp;</div>"; ?>
                    <div>
                        <a class="btn btn-link col-sm-12 col-md-6 col-xs-12 col-lg-1 col-lg-offset-1" href="login.php">Volver</a>
                    </div>
                </div><br><br>
        </div>
	</div>
</div>
<!-- END TGL -->
<!-- Recuperar contraseña -->
<div id="reset-password" class="collapse">
    <form action="actions/reset-password.php" method="post">
        <h3 class="col-md-offset-6 col-lg-offset-4  col-sm-offset-0">Recuperar contraseña</h3><br>
        <div class="row">
            <div class="col-md-3 col-md-offset-3 col-lg-offset-4  col-sm-offset-0">
                <label>Escriba el email con el que se registró.</label>
                <div class="input-group">
                    <input type="email" required name="pswd-email" class="form-control">
                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-success" value="Recuperar">
                    </span>
                </div>
                <p class="help-block">Le enviaremos un email a su correo con la nueva contraseña.</p>
            </div>
        </div>
    </form>
    
    <?php echo "<div class='col-sm-6 col-md-6 col-xs-6 col-lg-6'>&nbsp;</div>"; ?>
    <div>
		<a class="btn btn-link col-sm-12 col-md-6 col-xs-12 col-lg-1 col-lg-offset-1" href="login.php">Volver</a>
	</div>
</div>
<!-- END Recuperar contraseña -->

<script src="../inscripcion/js/jquery.js"></script>
<script src="js/login.js"></script>
</body>
</html>