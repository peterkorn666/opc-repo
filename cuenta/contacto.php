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
<title>Contacto para recepcion de resumenes</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
<div class="container">
	<div class="row" align="center">
        <img src="<?=$config["banner_congreso"]?>" alt="<?=$lang["NOMBRE_CONGRESO"]?>" class="img-fluid" style="width:70%;max-width:500px">
    </div><br><br>
    	<?php
		if($_GET["success"]=="1")
		{
		?>
        <div class="row">
            <div class="col-xs-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                <div class="alert alert-success">El contacto se ha enviado correctamente.</div>
            </div>
        </div>
        <?php
		}
		?>
        <?php
		if($_GET["empty"]=="1")
		{
		?>
        <div class="row">
            <div class="col-xs-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                <div class="alert alert-danger">Debe completar todos los campos.</div>
            </div>
        </div>
        <?php
		}
		?>
    <div class="row">
        <form action="actions/contacto.php" method="post" enctype="multipart/form-data">
            <h3 class="col-md-offset-3 col-lg-offset-3  col-sm-offset-0">Contacto para recepción de resúmenes</h3>
            <div class="row">
                <div class="col-md-3 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Apellido</label>
                    <input type="text" name="apellido" placeholder="Apellido" class="form-control" required>
                </div>
                <div class="col-md-3 col-sm-offset-0 col-md-offset-0 col-lg-offset-0">
                    <label>Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" class="form-control" required>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control" required>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Asunto</label>
                    <input type="text" name="asunto" placeholder="Asunto" class="form-control" required>
                </div>
            </div><br>
            
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Mensaje <small>Describa el problema que tuvo</small></label>
                    <textarea name="mensaje" class="form-control" style="resize:none" rows="8" required></textarea>
                    <p class="help-block"><i>Recomendamos enviar una imagen junto a su mensaje.</i></p>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0">
                    <label>Cargar una imagen</label>
                    <input type="file" name="archivo">
                    <p class="help-block">La imagen no puede superar los 2MB de tamaño.</p>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-lg-offset-3  col-sm-offset-0 text-center">
                    <input type="submit" value="Enviar" class="btn btn-primary col-sm-12 col-md-6 col-xs-12 col-lg-6">&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-link col-sm-12 col-md-6 col-xs-12 col-lg-4 col-lg-offset-1" href="login.php">Volver</a>
                </div>
            </div><br><br>
        </form>
    </div>
    <!-- END CUENTA -->
</div>

<script src="../inscripcion/js/jquery.js"></script>
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