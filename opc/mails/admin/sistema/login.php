<?PHP
require "inicializar.php";
$presentacion->abrir("login.php","../paginas/","Principal");

require "../clases/form_abm.php";

$mensajeError="";
$form_login= new form_class();
$form_login->method="post";
$form_login->action="login.php";
$form_login->accionPorDefecto="";
//$form_login->objDatos=$sistema->crearUsuario();
$form_login->objDatos=new objeto();

$v=new Variable(1,"","nick",1);
$v->requerida=true;
$form_login->objDatos->agregarVariable2($v);
$v=new Variable(1,"","clave",1);
$v->requerida=true;
$form_login->objDatos->agregarVariable2($v);
//$form_login->redirigir=false;
$form_login->script_OnLoad="eval('iniciar();');";
$form_login->leerDatos();
$form_login->procesar();

$usuario=$form_login->objDatos->darValorVariable("nick");
$clave=$form_login->objDatos->darValorVariable("clave");
$paginaSolicitada=leerParametro("paginaSolicitada");

  switch ($form_login->accion) {
    case "":
      //logout();
      if ($paginaSolicitada<>"") {
        $form_login->mensaje="La página solicitada requiere que introduzca su usuario y contrase&ntilde;a";
      }
      else {
        $form_login->mensaje="Introduzca su usuario y contrase&ntilde;a";
      }
	  $form_login->mostrar=1;
    break;
    case "validar":
		if ($usuario=="" || $clave=="") {
			$form_login->mensaje="Ingrese usuario y contrase&ntilde;a";
			$form_login->mostrar=1;
		} else {
      if ($sistema->validarUsuario($conexion, $usuario,$clave)) {
        $form_login->mensaje=$_SESSION['s_Nombre'] . " puede entrar a las &aacute;reas para usuarios del sitio";
        $form_login->mostrar=2;
        if ($paginaSolicitada!="") {
          $form_login->mensaje.="<br>Haga <a href=\"$paginaSolicitada\">click aquí</a> para ir a la página solicitada.";
        }
      }	  
      else
      {
        $form_login->mensaje="Usuario o contrase&ntilde;a incorrectos";
		$form_login->mostrar=1;
      }
	  }
    break;
    case "logout":
      $sistema->logout();
      $form_login->mensaje="Sesión terminada. Si lo desea, entre nuevamente.";
      $form_login->mostrar=1;
    break;
  }

  switch ($form_login->mostrar) {
   case 1:
     $scripts='
  <script type="text/javascript">
        document.form1.nick.focus();
		function validar() {
			document.form1.submit();
		}
     </script>
     ';
	 $clave=$form_login->objDatos->asignarPropiedadVariable("clave","mostrarValor",false);
	 $form_login->agregarScript($scripts);
    $form_login->accion="validar";

    if ($paginaSolicitada != "")
    {
         $form_login->agregarCampoOculto("paginaSolicitada", $paginaSolicitada );
    }
   break;
   case 2:
		if ($paginaSolicitada!="") {
			$scripts.='<script type="text/javascript">location.href="' . $paginaSolicitada . '";</script>';
			$form_login->agregarScript($scripts);
		}
		
   break;
  }
  

$form_login->asignarValoresVariables($presentacion);
$presentacion->definirSecciones();

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Resultado","");

$presentacion->asignarValor("Mensaje",$form_login->mensaje);

if ($form_login->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
} else {
	$presentacion->asignarValor("FormEdicion","");
}


$form_login->mostrarEnPresentacion($presentacion);
$presentacion->mostrar();


    ?>
