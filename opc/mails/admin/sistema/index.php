<?php

require "inicializar.php";
controlarAcceso($sistema,2);

controlarAcceso($sistema,0);
$presentacion->abrir("index.php","../paginas/","Principal");
$presentacion->mostrar();

?>