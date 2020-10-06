<?php
    require("../init.php");
    require("class/DB.class.php");
    require("class/core.php");
    //require("../configs/config.php");
    $core = new core();
    $getConfig = $core->getConfig();//var_dump('aca');die();

    if($_GET["lang"] != ""){
        require("lang/".$_GET["lang"].".php");
    } else {
        require("lang/es.php");
    }
    /*if(empty($_GET["key"]))
    {
        header("Location: index.php");
        die();
    }*/
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$getConfig["nombre_congreso"]?></title>

    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div align="center">
        <div class="col-md-10">
            <img src="<?=$getConfig["banner_congreso"]?>" class="img-fluid">
        </div><br>
        <?php
        if ($_GET["status"] == "1") {
            ?>
            <div class="col-md-10">
                <h3><?=$lang["RESUMEN_ENVIADO"]?></h3><br><br>
                <h3><?=$lang["RECORDAR_NUMERO"]?>: <span style="color: red; font-weight: bold;"><?=base64_decode($_GET["key"])?></span></h3>
            </div>
            <?php
        } else {
            ?>
            <div class="col-md-10">
                <div class="alert alert-danger">
                    <?=$lang["ERROR_ABSTRACT"]?>
                </div>
            </div>
            <?php
        }
        ?>
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