<?PHP
require_once("../clases/variable.php");
require_once("../clases/objeto.php");
require_once("../clases/session.php");
require_once("objetos/class.envios_datos.php");
require_once("objetos/class.envios_estados_datos.php");
require_once("objetos/class.envios_eventos_datos.php");
require_once("objetos/class.envios_subscriptos_datos.php");
require_once("objetos/class.eventos_datos.php");
require_once("objetos/class.iniciales_datos.php");
require_once("objetos/class.mails_datos.php");
require_once("objetos/class.mails_links_datos.php");
require_once("objetos/class.remitentes_datos.php");
require_once("objetos/class.subscriptos_datos.php");
require_once("objetos/class.subscriptos_datos_personales_datos.php");
require_once("objetos/class.subscriptos_estados_datos.php");
require_once("objetos/class.grupos_datos.php");
require_once("objetos/class.subscriptos_grupos_datos.php");
require_once("objetos/class.usuarios_datos.php");
require_once("objetos/class.usuarios_estados_datos.php");
require_once("objetos/class.usuarios_niveles_datos.php");

class usuario extends usuarios_datos {
	function usuario($sistema = null) {
		parent::usuarios_datos();
		if ($sistema!=null) {
			$this->sistema=$sistema;
			$this->database=$sistema->database;
		}
	}
}

	
	class envios extends envios_datos {
		var $sistema;
		function envios($sistema = null) {
			parent::envios_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	class envios_estados extends envios_estados_datos {
		var $sistema;
		function envios_estados($sistema = null) {
			parent::envios_estados_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class envios_eventos extends envios_eventos_datos {
		var $sistema;
		function envios_eventos($sistema = null) {
			parent::envios_eventos_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class envios_subscriptos extends envios_subscriptos_datos {
		var $sistema;
		function envios_subscriptos($sistema = null) {
			parent::envios_subscriptos_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class eventos extends eventos_datos {
		var $sistema;
		function eventos($sistema = null) {
			parent::eventos_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class iniciales extends iniciales_datos {
		var $sistema;
		function iniciales($sistema = null) {
			parent::iniciales_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class mails extends mails_datos {
		var $sistema;
		function mails($sistema = null) {
			parent::mails_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class mails_links extends mails_links_datos {
		var $sistema;
		function mails_links($sistema = null) {
			parent::mails_links_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class remitentes extends remitentes_datos {
		var $sistema;
		function remitentes($sistema = null) {
			parent::remitentes_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class subscriptos extends subscriptos_datos {
		var $sistema;
		function subscriptos($sistema = null) {
			parent::subscriptos_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	class subscriptos_datos_personales extends subscriptos_datos_personales_datos {
		var $sistema;
		function subscriptos_datos_personales($sistema = null) {
			parent::subscriptos_datos_personales_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class subscriptos_estados extends subscriptos_estados_datos {
		var $sistema;
		function subscriptos_estados($sistema = null) {
			parent::subscriptos_estados_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}


	class grupos extends grupos_datos {
		var $sistema;
		function grupos($sistema = null) {
			parent::grupos_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}	
	
	class subscriptos_grupos extends subscriptos_grupos_datos {
		var $sistema;
		function subscriptos_grupos($sistema = null) {
			parent::subscriptos_grupos_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}	
	
	class usuarios extends usuarios_datos {
		var $sistema;
		function usuarios($sistema = null) {
			parent::usuarios_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class usuarios_estados extends usuarios_estados_datos {
		var $sistema;
		function usuarios_estados($sistema = null) {
			parent::usuarios_estados_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}
	
	
	
	class usuarios_niveles extends usuarios_niveles_datos {
		var $sistema;
		function usuarios_niveles($sistema = null) {
			parent::usuarios_niveles_datos();
			if ($sistema!=null) {
				$this->sistema=$sistema;
				$this->database=$sistema->database;
			}
		}
	}


class sistema
{ // class : begin


// **********************
// ATTRIBUTE DECLARATION
// **********************

var $idioma;
var $database;
var $usuarios;
var $estado;
var $constantes;


// **********************
// CONSTRUCTOR METHOD
// **********************

function sistema($database,$idioma="es")
{
	$this->database=$database;
	$this->idioma=$idioma;
	$this->constantes=new constantes();
}

function buscarIdSubscripto($mail){
	$resultado=null;
	$grupos=$this->crearSubscriptos();
	$rs=$grupos->buscarDatos("IdSubscripto","Email='$mail'","");
	if ($row=$rs->darSiguienteFila()) {
		$resultado=$row["IdSubscripto"];
	}
	return $resultado;
}

function darListaUsuarios() {
	$u=new usuario();
	$u->database=$this->database;
	return $u->buscarDatos("usuario.Id,usuario.Usuario","","usuario.Usuario");
}

function darNombreUsuario($id=0) {
	$nombre="";
	$usuario=new datos_usuario();
	$usuario->database=$this->database;
	if ($usuario->select($id)) {
		$nombre=$usuario->getusuario();
	}
	return $nombre;
}


function buscarUsuario($usuario,$clave){
  $u=new usuario($this);
  return $u->buscarDatos("Id,Nombre,Apellido,Usuario","IdEstadoUsuario=3 AND Usuario='" . $usuario . "' AND Clave='" . $clave . "'");
}

function validarUsuario($conexion, $usuario,$clave){
  $rs=$this->buscarUsuario($usuario,$clave);
  if ($rs->filas==1)
  {
	$row=$rs->darSiguienteFila();
    $this->definirDatosSesion($row["Id"],$row["Usuario"],$row["Nombre"],$row["Apellido"]);
    return true;
  }
  return false;
}

function esUsuarioValido($permiso) {
  $resultado=false;
  if (isset($_SESSION['s_IdUsuario']) && is_numeric($_SESSION['s_IdUsuario']) && $permiso!="" ) {  
	$u=new usuario($this);
	$rs=$u->buscarDatos("Id,Nombre,Apellido,Usuario","IdEstadoUsuario=3 AND Id='" . $_SESSION['s_IdUsuario'] . "' AND IdNivel>='" . $permiso . "'");
	$resultado=($rs!=null && $rs->filas>0);
  }
  return $resultado;
}

function definirDatosSesion($idUsuario,$usuario,$nombre,$apellido) {
    $_SESSION['s_IdUsuario']=$idUsuario;
    $_SESSION['s_Usuario']=$usuario;
    if ($nombre . $apellido != "" ){
      if ($nombre=="" || $apellido=="") {
        $_SESSION['s_Nombre']=$nombre .  $apellido;
      } else {
        $_SESSION['s_Nombre']=$nombre . " " . $apellido;
      }
    } else {
      $_SESSION['s_Nombre']="";
    }
}

function darUsuarioSesion(){
	if (isset($_SESSION['s_Usuario'])) {
		return $_SESSION['s_Usuario'];
	} else {
		return "";
	}
}

function darNombreUsuarioSesion(){
	if (isset($_SESSION['s_Nombre'])) {
		return $_SESSION['s_Nombre'];
	} else {
		return "";
	}
}

function darIdUsuarioSesion(){
	if (isset($_SESSION['s_IdUsuario'])) {
		return $_SESSION['s_IdUsuario'];
	} else {
		return "";
	}
}

function logout() {
  $_SESSION = array();
  session_destroy();
}

function crearUsuarios() {
	return new usuarios($this);
}

function crearSubscriptos() {
	return new subscriptos($this);
}

function crearSubscriptosDatosPersonales() {
	return new subscriptos_datos_personales($this);
}

function crearMails() {
	return new mails($this);
}

function crearEnvios() {
	return new envios($this);
}

function crearEnvios_subscriptos() {
	return new envios_subscriptos($this);
}

function crearGrupos() {
	return new grupos($this);
}

function crearSubscriptos_grupos() {
	return new subscriptos_grupos($this);
}

function actualizarEstadisticasEnvios() {
/*
$sql="insert into estadisticas_envios (SELECT IdEnvio,count( IdSubscripto ) as EnviosTotales, count (distinct IdSubscripto) as SubscriptosUnicos,sum(if(IdEstadoEnvio=1,1,0)) as Pendientes,sum(if(IdEstadoEnvio=2,1,0)) as Enviados,sum(if(IdEstadoEnvio=3,1,0)) as Rebotados,min(FechaHora) as Primero, max(FechaHora) as Ultimo,sum(if(DATEDIFF( FechaHora, NOW( ) )>-7,1,0)) as UltimaSemana,sum(if(DATEDIFF( FechaHora, NOW( ) )=0,1,0)) as UltimoDia,sum(IF(TIMEDIFF(FechaHora,NOW())<='-01:00:00',1,0)) as UltimaHora,sum(IF(TIMEDIFF(FechaHora,NOW())<'-00:15:00',1,0)) as Ultimos15Min)";
*/
// primero borra estadísticas actuales
// luego agrega los envios 
// por último actualiza las estadísticas
// esto es porque hacer un left join de envios a envios_subscriptos demora mucho.

	$sql="DELETE from estadisticas_envios";
	$this->database->ejecutarSentenciaSQL($sql);
	$sql="INSERT INTO estadisticas_envios (IdEnvio) SELECT IdEnvio FROM envios";
	$this->database->ejecutarSentenciaSQL($sql);
	$sql="SELECT IdEnvio, COUNT( IdSubscripto ) AS EnviosTotales, COUNT( DISTINCT IdSubscripto ) AS SubscriptosUnicos, SUM( IF( IdEstadoEnvio =1, 1, 0 ) ) AS Pendientes, SUM( IF( IdEstadoEnvio =2, 1, 0 ) ) AS Enviados, SUM( IF( IdEstadoEnvio =3, 1, 0 ) ) AS Rebotados, MIN( FechaHora ) AS Primero, MAX( FechaHora ) AS Ultimo, SUM( IF( DATEDIFF( FechaHora, NOW( ) ) > -7, 1, 0 ) ) AS UltimaSemana, SUM( IF( DATEDIFF( FechaHora, NOW( ) ) =0, 1, 0 ) ) AS UltimoDia, SUM( IF( TIMEDIFF( FechaHora, NOW( ) ) <= '-01:00:00', 1, 0 ) ) AS UltimaHora, SUM( IF( TIMEDIFF( FechaHora, NOW( ) ) < '-00:15:00', 1, 0 ) ) AS Ultimos15Min
FROM envios_subscriptos
GROUP BY IdEnvio";
	$this->database->obtenerRecordset($sql);
	$rs=new RS($this->database->rs);
	while ($row=$rs->darSiguienteFila()) {
		$sql="UPDATE estadisticas_envios SET EnviosTotales=" . $row["EnviosTotales"] . ",SubscriptosUnicos=". $row["SubscriptosUnicos"] . ",Pendientes=". $row["Pendientes"] . ",Enviados=". $row["Enviados"] . ",Rebotados=". $row["Rebotados"] . ",Primero='". ($row["Primero"] !=null ? $row["Primero"] ."'" :"null"). ",Ultimo='". ($row["Ultimo"]!=null?$row["Ultimo"]. "'":"null") . ",UltimaSemana=". $row["UltimaSemana"] . ",UltimoDia=". $row["UltimoDia"] . ",UltimaHora=". $row["UltimaHora"] . ",Ultimos15Min=". $row["Ultimos15Min"] . " WHERE IdEnvio=" . $row["IdEnvio"]	;
		$this->database->ejecutarSentenciaSQL($sql);
	}
}


function actualizarEstadisticasEnviosCantidades($idEnvio,$difEnvios,$difPendientes,$difEnviados,$difRebotados) {
		$sql="UPDATE estadisticas_envios SET EnviosTotales=EnviosTotales + $difEnvios, Pendientes=Pendientes + $difPendientes,Enviados=Enviados+$difEnviados,Rebotados=Rebotados+$difRebotados WHERE IdEnvio=$idEnvio" ;

		$this->database->ejecutarSentenciaSQL($sql);
}

function agregarEstadisticasEnvios($idEnvio) {
		$sql="INSERT INTO estadisticas_envios (IdEnvio) VALUES ($idEnvio)" ;

		$this->database->ejecutarSentenciaSQL($sql);
}


} // class : end
?>