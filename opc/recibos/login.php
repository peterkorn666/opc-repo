<?php
require("../init.php");
require("clases/DB.class.php");
if($_SESSION["opc"]["admin"] && $_GET["next"]){
	header("Location: form_recibo.php?key=".$_GET["next"]);
	die();
}
if ($_POST["usuario"] && $_POST["clave"])
{
	$db = DB::getInstance();
	$cuenta = $db->query("SELECT * FROM claves WHERE usuario = ? AND clave = ?", [$_POST["usuario"], $_POST["clave"]])->first();
	$_SESSION["opc"]["admin"] = false;
	if (count($cuenta) > 0) {
		$_SESSION["opc"]["admin"] = true;
		header("Location: form_recibo.php?key=".$_GET["next"]);
	}else {
		header('Location: login.php?error=1&next='.$_GET["next"]);
	}
}

if ((int)$_GET["error"] === 1) {
	echo "<div class='row'>
			<div class='col-xs-6 col-lg-offset-3 col-md-6 col-lg-6 text-center alert alert-danger'>
				Usuario o clave incorrectos
			</div>
		  </div>";
}
if ((int)$_GET["error"] === 2) {
	echo "<div class='row'>
			<div class='col-xs-6 col-lg-offset-3 col-md-6 col-lg-6 text-center alert alert-danger'>
				Ha ocurrido un error con el inscripto
			</div>
		  </div>";
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login Recibo</title>
<link type="text/css" href="css/boostrap.css" rel="stylesheet">
<link type="text/css" href="../opc/estilos/datatables.min.css" rel="stylesheet">
<link type="text/css" href="consulta/estilos.css" rel="stylesheet">
<link type="text/css" href="css/beta-alert.css" rel="stylesheet">
</head>
<body>

<form id="login_recibo" action="login.php?next=<?php echo $_GET["next"] ?>" method="post">
	<div align="center"><img src="../imagenes/banner.jpg" style="width:580px;height:110px"></div><br>
    <table width="240" border="0" cellspacing="2" cellpadding="5" align="center">
      <tr>
        <td>Usuario: </td>
        <td><input type="text" name="usuario" /></td>
      </tr>
      <tr>
        <td>Clave: </td>
        <td><input type="password" name="clave" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" value="Ingresar" /> </td>
      </tr>
    </table>
</form>

</body>
</html>
<script type="text/jscript" src="js/jquery.js"></script>
<script>
$(document).ready(function(e) {
	$("#login_recibo").submit(function(){
		if ($("input[name='usuario']").val() == "" || $("input[name='clave']").val() == "") {
			alert("Debe escribir un usuario y una clave");
			return false;
		}
	})
})
</script>