<?php
	session_start();
	if(!empty($_SESSION["abstract"]["id_tl"])){
		header("Location: index.php");die();
	}	
	require("../init.php");
	require("class/DB.class.php");
	require("class/core.php");
	$core = new core();
	$getConfig = $core->getConfig();

	$lang = "es";
	if($_GET["lang"]!=""){
        if($_GET["lang"] != "es" && $_GET["lang"] != "en" && $_GET["lang"] != "pt"){
            header("Location: index.php");die();
        }
        $lang = $_GET["lang"];
    }
    require("lang/".$lang.".php");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$getConfig['nombre_congreso']?></title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
</head>
<body>
	<div class="container">
    	<div align="center">
        	<img src="<?=$getConfig["banner_congreso"]?>" alt="<?=$getConfig["nombre_congreso"]?>" style="width: 980px;"/>
        </div><br>
	<?php
		if($_GET["error"] == "camposVacios"){
			echo "<div class='col-md-offset-3 col-md-6 alert alert-danger' style='text-align: center;'>";
				echo "Los campos están vacíos.";
			echo "</div><br>";
		}
		if($_GET["error"] == "login"){
			echo "<div class='col-md-offset-3 col-md-6 alert alert-danger' style='text-align: center;'>";
				echo "Los datos ingresados no corresponden a ningún trabajo.";
			echo "</div><br>";
		}
	?>
        <form id="form-modificar-trabajo" action="login.php" method="post">
            <div class="col-md-offset-4 col-md-4">
                <div class="row">
                    <label><?=$lang["MODIFICAR_TRABAJO_USER"]?></label>
                    <input type="text" name="codigo" class="form-control" />
                </div><br>
                <div class="row">
                    <label style="text-align: left;"><?=$lang["MODIFICAR_TRABAJO_CLAVE"]?></label>
                    <input type="password" name="clave" class="form-control" />
                </div><br>
                <div class="row">
                    <input type="submit" value="<?=$lang['MODIFICAR_TRABAJO_INGRESAR']?>" class="btn btn-primary form-control" />
                </div>
            </div>
        </form>
	</div>
</body>
<script type="text/javascript" src="../js/jquery-1.12.4.js"></script>
<script>
	$(document).ready(function(){
		$("#form-modificar-trabajo").submit(function(){
			var input_codigo = $("input[name='codigo']");
			var input_password = $("input[name='password']");
			if(input_codigo.val() == ""){
				alert("Debe ingresar el número del trabajo o el email de contacto.");
				input_codigo.focus();
				return false;
			}
			if(input_password.val() == ""){
				alert("Debe ingresar su clave.");
				input_password.focus();
				return false;
			}
		});
	});
</script>
</html>