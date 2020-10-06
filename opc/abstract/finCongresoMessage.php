<?php
    error_reporting(E_ALL ^ E_NOTICE);
	require("../init.php");
    require("class/DB.class.php");
    require("class/core.php");
	require("class/abstract.php");
    $core = new core();
    $getConfig = $core->getConfig();//var_dump('aca');die();

    if($_GET["lang"] != ""){
        require("lang/".$_GET["lang"].".php");
    } else {
        require("lang/es.php");
    }
	
	if($_GET["lang"]=="" && $_SESSION["abstract"]["lang"]=="")
        $_SESSION["abstract"]["lang"] = "es";
    else if($_GET["lang"]!=""){
        if($_GET["lang"] != "es" && $_GET["lang"] != "en" && $_GET["lang"] != "pt"){
            header("Location: finCongresoMessage.php");die();
        }
        $_SESSION["abstract"]["lang"] = $_GET["lang"];
    }
	
	
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$getConfig["nombre_congreso"]?></title>
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="js/lang/<?=$_SESSION["abstract"]["lang"]?>.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
	<script type="text/javascript" src="js/idioma.js"></script>
	<script type="text/javascript">
        jQuery(document).ready(function($) {
            var lang = '<?=$_SESSION["abstract"]["lang"]?>';            
            
        });
    </script>
</head>
<body>
<div class="container">
    <div align="center">
        <div class="col-md-10">
            <img src="<?=$getConfig["banner_congreso"]?>" class="img-fluid">
        </div><br>
	<div align="center" class="div_idioma">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="es()" value="<?=$lang["TXT_SPANISH"]?>" class="btn btn-link form-control" style="color: black;">
                    </div>
                    <!--<div class="col-md-4" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="en()" value="<?=$lang["TXT_ENGLISH"]?>" class="btn btn-link form-control" style="color: black;">
                    </div>-->
                    <div class="col-md-6" style="margin-top: 0px; padding: 0px;">
                        <input type="button" onClick="pt()" value="<?=$lang["TXT_PORTUGUES"]?>" class="btn btn-link form-control" style="color: black;">
                    </div>
                </div>
            </div>
        </div><br>
            <div class="col-md-10">
                <h3><?=$lang["FIN_CONGRESO"]?></h3><br><br>
                
            </div>
    </div>
</div>
</body>
</html>
<script>
    /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-89204362-1', 'auto');
    ga('send', 'pageview');*/

</script>