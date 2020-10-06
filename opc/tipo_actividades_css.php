<?php
header("Content-type: text/css; charset: UTF-8");
require("codebase/config.php");
$sql = $res->prepare("SELECT * FROM tipo_de_actividad ORDER BY tipo_actividad");
$sql->execute();
while($row = $sql->fetch())
{
?>
.tipo_actividad_<?=$row["id_tipo_actividad"]?> .dhx_body, .tipo_actividad_<?=$row["id_tipo_actividad"]?> .dhx_title{
	background-color:<?=$row["color_actividad"]?> !important;
}
.tipo_actividad_<?=$row["id_tipo_actividad"]?> .dhx_body {
  /*  opacity: 0.85;
    transition: opacity 0.1s ease 0s;*/
}
<?php
}
?>