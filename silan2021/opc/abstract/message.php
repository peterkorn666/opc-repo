<?php
	require("../../init.php");
	require("class/core.php");
	require("../configs/config.php");
	if(empty($_GET["key"]))
	{
		header("Location: index.php");
		die();
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$getConfig["nombre_congreso"]?></title>
</head>

<body>
	<div style="width:800px; margin:0 auto">
    	<p align="center"><img src="<?=$getConfig["banner_congreso"]?>" width="600"></p>
        <?php
			if($_GET["status"]=="1")
			{
				if($_GET["t"] == 1){
		?>
					<h3 align="center">Su carga de trabajo completo se ha realizado con éxito.</h3>
        <?php		
				}else{
		?>
                    <h3 align="center">El resumen de su trabajo se ha enviado correctamente.</h3>
                    <h3 align="center"><strong>Recuerde el número del mismo:
                    <span style="font-size:28px;color:red"><?=base64_decode($_GET["key"])?></span>
                    </strong>        </h3>
            
                    <p align="center">
                         Agradecemos recordar el <strong>n&uacute;mero asignado:</strong><br>
                        <em><strong>Para recibir la informaci&oacute;n en relaci&oacute;n a su resumen </strong></em><br>(fechas importantes a recordar,  d&iacute;a - hora - sala que  le ser&aacute;n asignados para la presentaci&oacute;n,  <br>          
                        etc.)
                        <br>
                    </p>
      <?php
				}
			}
			else
			{
		?>        
      		<h2 align="center" style="color:red">Ha ocurrido un error al guardar su abstract.<br></h2>
        <?php
			}
		?>
    </div>
</body>
</html>