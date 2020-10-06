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
<title><?=$config["nombre_congreso"]?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/cuenta.css">
</head>

<body>
<?php
if($_SERVER["SERVER_NAME"] == "beta-alas2017.easyplanners.info"):
?>
<div id="beta-alert"></div>
<?php
endif;
?>
<div class="container">
	 <div align="center">
            
                <img src="<?=$config["banner_congreso"]?>" alt="<?=$lang["NOMBRE_CONGRESO"]?>" class="img-fluid" style="width:70%;max-width:500">
            
        </div><br><br>
	<!-- LOGIN -->
 	<div class="tgl">
        <form action="actions/login.php" method="post">
            <?php
            if($_GET["error"]=="1"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-danger text-center">
                        Email o Clave incorrectas.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php
            if($_GET["crear"]=="1"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-danger text-center">
                        Todos los campos son obligatorios.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php
            if($_GET["crear"]=="2"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-danger text-center">
                        Las contraseñas no coinciden.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php
            if($_GET["crear"]=="3"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-danger text-center">
                        El email ya se encuentra en uso.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php
            if($_GET["crear"]=="4"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-danger text-center">
                        Los emails no coinciden.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php
            if($_GET["success"]=="1"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-success text-center">
                        Cuenta creada correctamente, ya puede ingresar al sistema.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php
            if($_GET["psw"]=="1"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-success text-center">
                        Se ha enviado un correo con la nueva clave.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php
            if($_GET["psw"]=="2" || $_GET["psw"]=="3"){
            ?>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <div class="alert alert-danger text-center">
                        Ha ocurrido un error, intente nuevamente en unos minutos.
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="row" id="login-form" style="display: visible;">
                <div class="col-md-3 col-md-offset-3 col-lg-offset-4  col-sm-offset-0">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="col-md-3 col-md-offset-3 col-lg-offset-4 col-sm-offset-0">
                    <label>Clave</label>
                    <input type="password" class="form-control" name="clave" placeholder="Clave">
                    <!-- <p class="help-block text-right"><a href="#" id="btn-reset-password">recuperar contraseña</a></p> -->
                </div>
            </div><br>            
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <input type="button" id="loginbtn" class="btn btn-primary col-md-6 col-md-offset-3 col-lg-offset-2  col-sm-offset-0" value="Ingresar">
                    <input type="submit" id="loginsbm" style="display: none;" value="Ingresar" class="btn btn-primary col-md-6 col-md-offset-3 col-lg-offset-2  col-sm-offset-0"><br><br><br>
                    <div class="col-xs-12 col-lg-offset-0  col-sm-offset-0 text-justify">
                        <p>Aqu&iacute; podr&aacute; descargar su constancia de participación en <b>FEPAL 2020</b>.<br>
En caso de ser el contacto de una presentación en Grupos de Trabajo o Panel, podr&aacute; descargar su certificado.
Tenga en cuenta que es requisito haberlo presentado y estar inscripto pago.<br>
Solamente podr&aacute;n descargar los certificados los titulares de la cuenta con la que se carg&oacute; al sistema; en caso de ser co autor y no haber subido usted mismo, <b>solic&iacute;telo al titular.</b><br> Hemos enviado la clave por mail a todos los participantes, si a usted no le llego <a href="contacto.php">cont&aacute;ctenos</a>.<br> Por temas acad&eacute;micos dir&iacute;jase a secretaria y por temas de pago relativos a su inscripción dir&iacute;jase a fepal2020@gmail.com</p>
                        <!--<a class="tglbtn col-xs-12 btn btn-primary">Crear nueva cuenta</a>-->
                    </div>
                    <?php
						//if($_GET["nuevo"]=="1")
						//{
					?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <!--<a class="btn btn-link col-sm-12 col-md-6 col-xs-12 col-lg-4 col-lg-offset-1 tglbtn" style="font-size:20px">Crear Cuenta</a>-->
                    <?php
						/*}else
							echo "<div class='col-sm-12 col-md-12 col-xs-12 col-lg-12'>&nbsp;</div><div style='clear:both'></div>";*/
							echo "<div class='col-sm-12 col-md-12 col-xs-12 col-lg-12'>&nbsp;</div><div style='clear:both'></div>";
					?>
                    <div class="col-md-6 col-md-offset-3 col-lg-offset-2  col-sm-offset-0">
                    	<!--<p class="help-block text-center">Creación de nuevas cuentas y recuperación de contraseña en mantenimiento</p>-->
                    	<!--<p class="help-block text-center">Si usted es coautor de un trabajo y no posee una cuenta propia puede crearla haciendo click <a class="tglbtn">aquí</a></p>-->
                    </div>
                    <div class="row">
                    	<div class="col-xs-12 col-md-6 col-lg-6">
                    		<p class="help-block text-left"><a href="preguntas_frecuentes.php">Preguntas frecuentes</a></p>
                        </div>  
                        <div class="col-xs-12 col-md-6 col-lg-6">  
		                    <p class="help-block text-right">visitas: <?=$cuenta->getVisitas()?></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END LOGIN -->
    
    <!-- Recuperar contraseña -->
    <div id="reset-password" class="collapse">
    	<form action="actions/reset-password.php" method="post">
        	<h3 class="col-md-offset-6 col-lg-offset-3  col-sm-offset-0">Recuperar contraseña</h3><br>
            <div class="row">
            	<div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
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
    </div>
    <!-- END Recuperar contraseña -->
    <!-- CREAR CUENTA -->
    <div class="tgl">
        <form action="actions/crearcuenta.php" method="post">
            <h3 class="col-md-offset-3 col-lg-offset-3  col-sm-offset-0">Crear Cuenta</h3>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">Si usted ya creó una cuenta en algún momento, por favor no cree una nueva. <br>Trataremos de ayudarlo para encontrar su vieja cuenta, <a href="contacto.php">contáctenos</a>.
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Apellido</label>
                    <input type="text" name="apellido" placeholder="Apellido" class="form-control">
                </div>
                <div class="col-md-3 col-sm-offset-0 col-md-offset-0 col-lg-offset-0">
                    <label>Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control">
                </div>
                <div class="col-md-3 col-md-offset-0 col-lg-offset-0  col-sm-offset-0">
                    <label>Confirme el Email</label>
                    <input type="text" name="email2" placeholder="Email" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Clave</label>
                    <input type="password" name="clave1" placeholder="****" class="form-control">
                </div>
                <div class="col-md-3 col-sm-offset-0 col-md-offset-0 col-lg-offset-0">
                    <label>Repetir Clave</label>
                    <input type="password" name="clave2" placeholder="****" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
                    <input type="submit" value="Crear Cuenta" class="btn btn-primary col-sm-12 col-md-6 col-xs-12 col-lg-6">&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-link col-sm-12 col-md-6 col-xs-12 col-lg-4 col-lg-offset-1 tglbtn">Volver</a>
                </div>
            </div>
        </form>
    </div>
    <!-- END CUENTA -->
</div>

<script src="../opc/inscripcion/js/jquery.js"></script>
<script src="js/login.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89204362-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>