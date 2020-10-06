<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');
require("../../init.php");
require("class/core.php");
require("class/abstract.php");
require("class/class.lang.php");
$browser = new Browser();
$trabajos = new abstracts();
$core = new core();
$getConfig = $core->getConfig();
$getLang = new Lang("es");
require("lang/".$getLang->lang.".php");

$modalidades = $core->getModalidades();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$getConfig['nombre_congreso']?></title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="col-md-12" style="text-align: center;">
        <img src="../imagenes/banner.jpg" alt="<?=$getConfig["nombre_congreso"]?>" style='width: 600px;'>
    </div><br>
    <?php
    /*if (!$_SESSION["admin"]) {
        if(empty($_GET["u"])) {
            echo '<br><h2 align="center" style="color:red">Ha finalizado la presentación de resúmenes</h2>';
            die();
        }
    }*/

    if (empty($_SESSION["abstract"]["id_tl"])){
        ?>
        <div class="login">
            <a href="javascript:void(0)" class="link_login">Para modificar su abstract haga click aquí</a>
        </div><br><br>
        <div class="login" style="display:none">
            <form action="login.php" method="post">
                <div class="col-md-4 offset-4">
                    <div class="row" style="margin-bottom: 10px;">
                        <div clasS="col-md-2">
                            N&ordm;
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="codigo" class="form-control"/>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div clasS="col-md-2">
                            Clave
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="clave" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" value="Ingresar" class="form-control btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
            <br><br>
        </div>
        <?php
    } else {
        echo '<a href="salir.php">Salir</a>';
    }
    if($_GET["error"]=="empty"){
        ?>
        <div class="row">
            <div class="col-md-12 alert alert-danger" style="text-align: center;">
                Debe completar todos los campos.
            </div>
        </div>
        <?php
    }
    ?>
    <form action="datos.post.php" method="post">
        <div class="col-md-6 offset-3">
            <?php
            $chk = "";
            if($_SESSION["abstract"]["reglamento"] == '1'){
                $chk = 'checked';
            }
            ?>
            <div class="row" style="padding-bottom: 15px;">
                <div class="col-md-10" style="text-align: justify;">
                    <strong><?=$lang["reglamento"]?></strong>
                </div>
                <div clasS="col-md-2" style="text-align: center; vertical-align: middle;">
                    <input type="radio" name="reglamento" value="1" <?=$chk?>>
                </div>
            </div>
            <?php
            $chk = "";
            if($_SESSION["abstract"]["reglamento"] == '2'){
                $chk = 'checked';
            }
            ?>
            <div class="row" style="padding-bottom: 15px;">
                <div class="col-md-10" style="text-align: justify;">
                    <strong><?=$lang["reglamento2"]?></strong>
                </div>
                <div clasS="col-md-2" style="text-align: center; vertical-align: middle;">
                    <input type="radio" name="reglamento" value="2" <?=$chk?>>
                </div>
            </div>
            <div id="conflicto" class="row">
                <div class="col-md-12">
                    <textarea name="conflicto_descripcion" class="form-control" placeholder="Describa el conflicto aquí"><?=$_SESSION["abstract"]["conflicto_descripcion"]?></textarea>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <?=$lang['MODALIDAD']?>
                </div>
                <div class="col-md-9">
                    <select name="modalidad" class="form-control">
                        <option value=""></option>
                        <?php
                        $slctd = "";
                        foreach($modalidades as $modalidad){
                            if($_SESSION["abstract"]["modalidad"] == $modalidad['id'])
                                $slctd = 'selected';
                            ?>
                            <option value="<?=$modalidad['id']?>" <?=$slctd?>><?=$modalidad['modalidad']?></option>
                            <?php
                            $slctd = "";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 input_next">
                    <input type="submit" value="Continuar" class="form-control btn btn-primary">
                </div>
            </div>
            <input type="hidden" name="step" value="0">
        </div>
    </form>
</div>
</body>
</html>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script><!-- jquery1.11.1.js -->
<script type="text/javascript">
    $(document).ready(function(e) {
        $("form:last").submit(function(){
            var alerta = "Todos los campos son obligatorios";

            var input_reglamento = $("input[name='reglamento']");
            if(!input_reglamento.is(':checked')){
                alert(alerta);
                input_reglamento.eq(0).focus();
                return false;
            } else {
                var reglamento = $("input[name='reglamento']:checked");
                if(reglamento.val() == 2){
                    var conflicto_descripcion = $("textarea[name='conflicto_descripcion']");
                    if(conflicto_descripcion.val()==""){
                        alert(alerta);
                        conflicto_descripcion.focus();
                        return false;
                    }
                }
            }

            var select_modalidad = $("select[name='modalidad'] option:selected");
            if(select_modalidad.val() === "" || select_modalidad.val() == undefined){
                alert(alerta);
                $("select[name='modalidad']").focus();
                return false;
            }
        });

        conflicto();
        $("input[name='reglamento']").click(function(){
            conflicto();
        });

        $(".login .link_login").click(function(e){
            e.preventDefault();
            $(".login").slideToggle("fast");
        });
    });

    function conflicto(){
        var div_conflicto = $("#conflicto");
        div_conflicto.hide();
        var conflicto = false;
        var input_reglamento = $("input[name='reglamento']");
        if(input_reglamento.is(':checked')){
            var reglamento = $("input[name='reglamento']:checked");
            if(reglamento.val() == 2){
                div_conflicto.show();
                conflicto = true;
            }
        }
        if(conflicto === false){
            $("textarea[name='conflicto_descripcion']").val("");
        }
    }
</script>