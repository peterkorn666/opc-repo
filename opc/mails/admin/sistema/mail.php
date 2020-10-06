<?PHP
require "inicializar.php";
controlarAcceso($sistema,2);
$presentacion->abrir("mail.php","../paginas/","Principal");

require "../clases/form_abm.php";
$mensajeError="";

$arrLinks=array();
$arrImgs=array();

$form_abm_mail= new form_abm_class();
$form_abm_mail->action="mail.php";
$form_abm_mail->objDatos=$sistema->crearMails();
$form_abm_mail->script_OnLoad="eval('iniciar();');";
$form_abm_mail->funcion_previa_alta="anteriorAlta";
$form_abm_mail->funcion_posterior_alta="posteriorAlta";
$form_abm_mail->funcion_validar_alta="validarAlta";
$form_abm_mail->funcion_validar_edicion="validarEdicion";
$form_abm_mail->funcion_posterior_edicion="posteriorEdicion";
$form_abm_mail->leerDatos();

$form_abm_mail->redirect=false;

$form_abm_mail->procesar();

$form_abm_mail->asignarValoresVariables($presentacion);

$presentacion->asignarValor("FormBuscador","");
$presentacion->asignarValor("Resultado","");

$presentacion->asignarValor("Mensaje",$form_abm_mail->mensaje);

$presentacion->asignarValor("opcionesPrioridad",cargarListBoxArrayAsociativo(array("5"=>"Baja","3"=>"Normal","1"=>"Alta"),$form_abm_mail->objDatos->darValorVariable("Prioridad")));

if ($form_abm_mail->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
} else {
	$presentacion->asignarValor("FormEdicion","");
}

$form_abm_mail->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();

function anteriorAlta() {
	global $sistema,$form_abm_mail;
	$plantilla="../../plantillas/plantilla.htm";
	$form_abm_mail->objDatos->asignarValorVariable("FromEmail", FROM_EMAIL);
	$form_abm_mail->objDatos->asignarValorVariable("FromNombre", FROM_NOMBRE);
	$form_abm_mail->objDatos->asignarValorVariable("ReplyToEmail", REPLYTO_EMAIL);
	$form_abm_mail->objDatos->asignarValorVariable("ReplyToNombre", REPLYTO_NOMBRE);
	$form_abm_mail->objDatos->asignarValorVariable("CuerpoHTML",str_replace("\n","",str_replace("\r\n","",contenidoArchivo($plantilla))));
	$resultado=true;
	return $resultado;
}


function validarAlta() {
	global $sistema,$form_abm_mail;
	$form_abm_mail->objDatos->asignarValorVariable("SenderEmail", $form_abm_mail->objDatos->darValorVariable("FromEmail"));
	$form_abm_mail->objDatos->asignarValorVariable("SenderNombre", $form_abm_mail->objDatos->darValorVariable("FromNombre"));
	$form_abm_mail->objDatos->asignarValorVariable("Referencia", $form_abm_mail->objDatos->darValorVariable("Asunto"));
	$resultado=true;
	return $resultado;
}

function validarEdicion() {
	global $sistema,$form_abm_mail;
	$form_abm_mail->objDatos->asignarValorVariable("SenderEmail", $form_abm_mail->objDatos->darValorVariable("FromEmail"));
	$form_abm_mail->objDatos->asignarValorVariable("SenderNombre", $form_abm_mail->objDatos->darValorVariable("FromNombre"));
	$form_abm_mail->objDatos->asignarValorVariable("Referencia", $form_abm_mail->objDatos->darValorVariable("Asunto"));
	$resultado=true;
	return $resultado;
}

function posteriorAlta() {
	
	global $sistema,$form_abm_mail;
	
	$form_abm_mail->objDatos->asignarValorVariable("IdMail",$form_abm_mail->objDatos->id);
	
	analizarHTML($form_abm_mail->objDatos->darValorVariable("CuerpoHTML"));	
	guardarLinks($form_abm_mail->objDatos->darValorVariable("IdMail"));
	guardarImagenes($form_abm_mail->objDatos->darValorVariable("IdMail"));

	$form_abm_mail->objDatos->asignarValorVariable("CuerpoTextoPreparado", $form_abm_mail->objDatos->darValorVariable("CuerpoTexto"));
	$form_abm_mail->objDatos->asignarValorVariable("CuerpoHTMLPreparado", reemplazarLinks($form_abm_mail->objDatos->darValorVariable("IdMail"),$form_abm_mail->objDatos->darValorVariable("CuerpoHTML")));
	
	$form_abm_mail->objDatos->update($form_abm_mail->objDatos->darValorVariable("IdMail"));

	//da de alta un envio asociado a este mail
	$envio=$sistema->crearEnvios();
	$envio->setIdMail($form_abm_mail->objDatos->darValorVariable("IdMail"));
	$envio->setEnvio($form_abm_mail->objDatos->darValorVariable("Referencia"));
	$envio->setDescripcion($form_abm_mail->objDatos->darValorVariable("Referencia"));
	$envio->insert();
	
	$sistema->agregarEstadisticasEnvios($form_abm_mail->objDatos->darValorVariable("IdMail"));
	
	$resultado=true;
	return $resultado;
}

function posteriorEdicion() {
	global $sistema,$form_abm_mail;
	analizarHTML($form_abm_mail->objDatos->darValorVariable("CuerpoHTML"));
	analizarHTML($form_abm_mail->objDatos->darValorVariable("CuerpoHTML"));
	guardarLinks($form_abm_mail->objDatos->darValorVariable("IdMail"));
	guardarImagenes($form_abm_mail->objDatos->darValorVariable("IdMail"));
	$form_abm_mail->objDatos->asignarValorVariable("CuerpoTextoPreparado", $form_abm_mail->objDatos->darValorVariable("CuerpoTexto"));
	$form_abm_mail->objDatos->asignarValorVariable("CuerpoHTMLPreparado", reemplazarLinks($form_abm_mail->objDatos->darValorVariable("IdMail"),$form_abm_mail->objDatos->darValorVariable("CuerpoHTML")));
	$form_abm_mail->objDatos->update($form_abm_mail->objDatos->darValorVariable("IdMail"));

	
	//modifica el envio asociado a este mail (asume que hay uno solo)  //  ALTER TABLE `envios` ADD UNIQUE `IdMail` ( `IdMail` )  
	$envio=$sistema->crearEnvios();
	$rsEnvio=$envio->buscarDatos("IdEnvio","IdMail=" . $form_abm_mail->objDatos->darValorVariable("IdMail"));

	if ($rsEnvio && $rsEnvio->filas>0) {
		//  toma el primero
		$row=$rsEnvio->darSiguienteFila();
		$envio->select($row["IdEnvio"]);
		$envio->setEnvio($form_abm_mail->objDatos->darValorVariable("Referencia"));
		$envio->setDescripcion($form_abm_mail->objDatos->darValorVariable("Referencia"));
		$envio->update($row["IdEnvio"]);
	} else {
		// si no lo encuentra crea uno
		$envio->setIdMail($form_abm_mail->objDatos->darValorVariable("IdMail"));
		$envio->setEnvio($form_abm_mail->objDatos->darValorVariable("Referencia"));
		$envio->setDescripcion($form_abm_mail->objDatos->darValorVariable("Referencia"));
		$envio->insert();
	}
	
	$resultado=true;
	return $resultado;
}


// carga los arrays de links e imágenes locales (no las http://)
function analizarHTML($textoHTML) {

	global $arrLinks;
	global $arrImgs;
	
	$textoHTML=str_replace("\\\"","\"",$textoHTML);

	include_once("../clases/htmlsql/snoopy.class.php");
    include_once("../clases/htmlsql/htmlsql.class.php");
    
    $wsql = new htmlsql();
    
    $wsql->connect('string', $textoHTML);

    if (!$wsql->query('SELECT href as url FROM a WHERE preg_match("/^http:\/\//", $href) or preg_match("/^HTML:\/\//", $href)')){
        print "Error en la consulta: " . $wsql->error; 
        return false;
    }

	$arrLinks=$wsql->fetch_array();

    if (!$wsql->query('SELECT src as url FROM img')){
        print "Query error: " . $wsql->error; 
        return;
    }
	
	$arrImgs=$wsql->fetch_array();
}


function guardarLinks($idMail) {

	global $arrLinks;
	global $sistema;
	
	//da de alta links que no estan
	//no borra los links anteriores por si fue enviado algún mail que los usaba (habría que controlar si tuvieron eventos de click -2-)
		
    foreach($arrLinks as $row){
		$sql="SELECT * FROM mails_links WHERE IdMail=$idMail and Url='" . $row['url'] . "'";

		$sistema->database->obtenerRecordset($sql);
		$rs=new RS($sistema->database->rs);

		if ($rs->filas==0) {
			$sql = "INSERT INTO `mails_links` ( `IdMailLink` , `IdMail` , `Nombre` , `Url` , `Comentarios` ) ";
			$sql .= "VALUES ( ";
			$sql .= "'', '$idMail', '', '" ;
			$sql .= $row['url'] ;
			$sql .= "', '')";
			
			$sistema->database->ejecutarSentenciaSQL($sql);
		}
    }

	return;
}

// guarda la url de las imagenes que se van a enviar adjuntas
function guardarImagenes($idMail) {

	global $sistema;
	global $arrImgs;
	
	//borra las imagenes guardadas actualmente para este mensaje
	$sql="DELETE FROM mails_imgs WHERE IdMail=$idMail ";
	$sistema->database->ejecutarSentenciaSQL($sql);	
	
	
	//da de alta las imagenes que se estan usando	
    foreach($arrImgs as $row){

		if (strpos($row["url"],"http://")===0) {

		} else {
		
			$sql="SELECT * FROM mails_imgs WHERE IdMail=$idMail and Url='" . $row['url'] . "'";

			$sistema->database->obtenerRecordset($sql);
			$rs=new RS($sistema->database->rs);

			if ($rs->filas==0) {
				$sql = "INSERT INTO `mails_imgs` ( `IdMailImg` , `IdMail` ,  `Url` , `Archivo` ,`Comentarios` ) ";
				$sql .= "VALUES ( ";
				$sql .= "'', '$idMail',  '" ;
				$sql .= $row['url'] ;
				$sql .= "', '";
				$sql .= $row['url'] ;
				$sql .= "','')";
				
				$sistema->database->ejecutarSentenciaSQL($sql);
			}
		}
    }

	return;
}

// en los campos cuerpoTextoPreparado y cuertoHTMLPreparado están hechos los reemplazos de los links
// queda como %%..GUID..%% el texto que luego se reemplaza al enviar a cada destinatario
function reemplazarLinks($idMail,$cuerpoHTML) {

	global $sistema;
	$guid="%%..GUID..%%";
	
	$linksReemplazar=-1;
	$linksOriginal=array();
	$linksNuevo=array();
	
	//listado de links a reemplazar
	$sql = "SELECT * FROM mails_links WHERE IdMail=$idMail";
	$sistema->database->ejecutarSentenciaSQL($sql);
	$rsMailLinks = $sistema->database->rs;
	
	
	if ($rsMailLinks && mysqli_num_rows($rsMailLinks)>0 && mysqli_data_seek ($rsMailLinks,0)) {
		while ($row = mysqli_fetch_array($rsMailLinks)){
			//hay que terminar la url con una comilla o espacio para evitar que reemplace la url en imagenes
			//por ejemplo url=http://www.midominio.com e imagen=http://www.midominio.com/imagenes/img.gif
			$linksReemplazar++;
			$linksOriginal[$linksReemplazar]=$row["Url"] . "\"";
			$linksNuevo[$linksReemplazar]=URL_SCRIPTS_TRACKING . "link.php?guid=" . $guid ."&l=" . $row["IdMailLink"] . "\"";

			$linksReemplazar++;
			$linksOriginal[$linksReemplazar]=$row["Url"] . "'";
			$linksNuevo[$linksReemplazar]=URL_SCRIPTS_TRACKING . "link.php?guid=" . $guid ."&l=" . $row["IdMailLink"] . "'";

			$linksReemplazar++;
			$linksOriginal[$linksReemplazar]=$row["Url"] . " ";
			$linksNuevo[$linksReemplazar]=URL_SCRIPTS_TRACKING . "link.php?guid=" . $guid ."&l=" . $row["IdMailLink"] . " ";
		}
	}

	//imagen para tracking
	$imagenTracking="<img src='" .  URL_SCRIPTS_TRACKING . "img.php?guid=$guid' width='1' height='1'>";
	
	$textoUnsubscribe="";
	if (MOSTRAR_UNSUBSCRIBE) {
		$textoUnsubscribe="<hr>Ud. est&aacute; registrado con la casilla %%..EMAIL..%%, para borrarse envie un email a %%..REPLYTO..%% con su solicitud o <a href='" . URL_SCRIPTS_TRACKING . "unsubscribe.php?guid=%%..GUID..%%&email=%%..EMAIL..%%'>haga click aqu&iacute;</a>.";
		$imagenTracking.=$textoUnsubscribe;
	}

	if (strpos($cuerpoHTML, "</BODY>")>0 || strpos($cuerpoHTML, "</body>")>0) {
		$linksReemplazar++;
		$linksOriginal[$linksReemplazar]="</BODY>";
		$linksNuevo[$linksReemplazar]=$imagenTracking . "</BODY>";
		$linksReemplazar++;
		$linksOriginal[$linksReemplazar]="</body>";
		$linksNuevo[$linksReemplazar]=$imagenTracking . "</body>";
	} else if (strpos($cuerpoHTML, "</HTML>")>0 || strpos($cuerpoHTML, "</html>")>0) {
		$linksReemplazar++;
		$linksOriginal[$linksReemplazar]="</HTML>";
		$linksNuevo[$linksReemplazar]=$imagenTracking . "</HTML>";
		$linksReemplazar++;
		$linksOriginal[$linksReemplazar]="</html>";
		$linksNuevo[$linksReemplazar]=$imagenTracking . "</html>";
	} else {
		$cuerpoHTML.=$imagenTracking;
	}
		
	return str_replace($linksOriginal,$linksNuevo,$cuerpoHTML);

		
}


function contenidoArchivo($archivo) {
	$resultado="";
	$resultado=file_get_contents($archivo,FILE_USE_INCLUDE_PATH);
	return $resultado;
}
?>