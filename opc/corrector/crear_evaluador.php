<?php
	session_start();
	if($_SESSION["corrector"]["nivel"] != 1){
		header("Location: login.php");
		die();
	}
	require("../../init.php");
	require("clases/evaluadores.class.php");

	$instancia_evaluadores = new Evaluadores();

    $txt_accion = "Crear";
	if ($_GET["key"]){
        $txt_accion = "Editar";
        $row = $instancia_evaluadores->getEvaluadorByID($_GET["key"]);
	}

    $mensaje = "";
	if($_GET['success']){

        $alert = 'success';
        if($_GET['accion'] == 'crear'){
            $mensaje = "Se ha creado el evaluador con éxito.";
        } else if ($_GET['accion'] == 'editar'){
            $mensaje = "Se ha editado el evaluador con éxito.";
        }
    }else if($_GET['error']){

	    $alert = 'danger';
        if($_GET['accion'] == 'crear'){
            $mensaje = "Ha ocurrido un error en la creación del evaluador.";
        } else if ($_GET['accion'] == 'editar'){
            $mensaje = "Ha ocurrido un error en la edición del evaluador.";
        }
    }


	if(count($_POST) > 0){

        $campos = array();
        foreach($_POST as $key => $value){
            $campos[$key] = $value;
        }

	    if (array_key_exists('id_evaluador', $campos)){ //Editar

	        $id_evaluador = $campos['id_evaluador'];
	        unset($campos['id_evaluador']);
            $sql = $instancia_evaluadores->editarEvaluador($id_evaluador, $campos);
            $accion = 'editar&key='.$id_evaluador;

            header("Location: evaluadores.php?evaluador_editado=true&evaluador=".$id_evaluador);
            die();
        } else {

            $sql = $instancia_evaluadores->crearEvaluador($campos);
            $accion = 'crear';
        }
        if($sql) {
            header("Location: crear_evaluador.php?success=true&accion=".$accion);
        } else
            header("Location: crear_evaluador.php?error=true&accion=".$accion);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?=$txt_accion?> evaluador</title>
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css" />
</head>
<body>
    <div class="container">
        <div align="center">
            <div class="col-md-6">
                <?php
                include("include/include_image.php");
                ?>
            </div>
        </div><br>
        <form id="formEvaluador" name="formEvaluador" action="crear_evaluador.php" method="POST">
            <?php
            if($_GET["key"]) {
                ?>
                <input type="hidden" name="id_evaluador" value="<?= $_GET["key"] ?>">
                <?php
            }
            ?>

            <div align="center">
                <div class="col-md-6 text-left">
                    <?php
                    if($mensaje != ""){
                        ?>
                        <div class="row separador_fila">
                            <div class="col-md-12 alert alert-<?=$alert?>">
                                <?=$mensaje?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row separador_fila">
                        <div class="col-md-4">
                            Nombre:
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="nombre" value="<?=$row['nombre']?>" class="form-control">
                        </div>
                    </div>
                    <div class="row separador_fila">
                        <div class="col-md-4">
                            Email:
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="mail" value="<?=$row['mail']?>" class="form-control">
                        </div>
                    </div>
                    <div class="row separador_fila">
                        <div class="col-md-4">
                            País:
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="pais" value="<?=$row['pais']?>" class="form-control">
                        </div>
                    </div>
                    <div class="row separador_fila">
                        <div class="col-md-4">
                            Nivel:
                        </div>
                        <div class="col-md-8">
                            <select name="nivel" class="form-control">
                                <option value=""></option>
                                <option value="2" <?php if($row['nivel'] == 2) echo 'selected'; ?>>Evaluador</option>
                                <option value="1" <?php if($row['nivel'] == 1) echo 'selected'; ?>>Administrador</option>
                            </select>
                        </div>
                    </div>
                    <div class="row separador_fila">
                        <div class="col-md-4">
                            Clave:
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="clave" value="<?=$row['clave']?>" class="form-control">
                        </div>
                    </div>
                    <div class="row separador_fila">
                        <div class="col-md-6">
                            <a href="evaluadores.php" class="btn-block btn btn-link">Volver a evaluadores</a>
                        </div>
                        <div class="col-md-6">
                            <input type="submit" value="Guardar" class="form-control btn btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $("#formEvaluador").submit(function(){
            return guardarEvaluador();
        });
    });

    function guardarEvaluador(){

        var input_nombre = $("input[name='nombre']");
        if(input_nombre.val() == undefined || input_nombre.val() === ""){

            alert("Debe escribir un nombre al evaluador.");
            input_nombre.focus();
            return false;
        }

        var input_email = $("input[name='mail']");
        if(input_email.val() == undefined || input_email.val() === ""){

            alert("Debe escribir un email al evaluador.");
            input_email.focus();
            return false;
        }

        var select_nivel = $("select[name='nivel'] option:selected");
        if(select_nivel.val() == undefined || select_nivel.val() === ""){

            alert("Debe seleccionar un nivel para el evaluador.");
            $("select[name='nivel']").focus();
            return false;
        }

        var input_clave = $("input[name='clave']");
        if(input_clave.val() == undefined || input_clave.val() === ""){

            alert("Debe escribir una clave al evaluador.");
            input_clave.focus();
            return false;
        }

        return true;
    }
</script>
</html>