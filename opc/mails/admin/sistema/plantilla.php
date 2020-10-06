<?PHP
require "inicializar.php";
controlarAcceso($sistema,0);
$presentacion->abrir("plantilla.php","../paginas/","Principal");

$archivosDatos="../../plantillas/plantilla.htm";

require "../clases/form_class.php";
$mensajeError="";
$form_abm_1= new form_class();
$form_abm_1->objDatos= new objeto();
$form_abm_1->action="plantilla.php";
$form_abm_1->script_OnLoad="eval('iniciar();');";
$form_abm_1->accionPorDefecto="mostrar";
$form_abm_1->acciones["mostrar"]="cargarDatos";
$form_abm_1->acciones["guardar"]="guardarDatos";

$v=new Variable(1,"","Plantilla",1);	
$v->campoSQL="";
$form_abm_1->objDatos->agregarVariable2($v);

$form_abm_1->agregarScript(scripts());

$form_abm_1->redirect=false;
$form_abm_1->leerDatos();
$form_abm_1->procesar();

$presentacion->asignarValor("Mensaje",$form_abm_1->mensaje);

$form_abm_1->mostrar=1;
if ($form_abm_1->mostrar==1) {
	$presentacion->parse("FormEdicion",false);
} else {
	$presentacion->asignarValor("FormEdicion","");
}

$form_abm_1->mostrarEnPresentacion($presentacion);

$presentacion->mostrar();

function cargarDatos() {
	global $form_abm_1,$archivosDatos;
	$form_abm_1->objDatos->asignarValorVariable("Plantilla",str_replace("\n","",str_replace("\r\n","",contenidoArchivo($archivosDatos))));
	$form_abm_1->accion="guardar";
}

function guardarDatos() {
	global $form_abm_1,$archivosDatos;
	escribirEnArchivo($archivosDatos,$form_abm_1->objDatos->darValorVariable("Plantilla"));
}

function scripts() {
	global $form_abm_1;
	$resultado .= '
		<script type="text/javascript">
		var js_form = {
			formulario_nombre: "form1",
			formulario:null,
			variable_accion_nombre: "accion",
			variable_pr_nombre: "pr",
			variable_accion: null,
			variable_pr: null,
			listo: false,
			inicializar:function() {
				this.formulario=document.forms[this.formulario_nombre];
				if (this.formulario) {
					this.variable_accion=this.formulario.elements[this.variable_accion_nombre];
					this.variable_pr=this.formulario.elements[this.variable_pr_nombre];
					if (this.variable_accion) {
						this.listo=true;
					} else {
					}
				}
			},
			aceptar:function(){
				if (this.validar()) {
					this.formulario.submit();
				} else {

				}

			},
			confirmarAccion:function(nombreAccion,valorAccion,id,detalle) {
				if (pedirConfirmacion("Confirma " + nombreAccion + " " + this.elemento_articulo_singular + " " + this.elemento_singular + " \n" + detalle + "?")) {
					this.formulario.id.value=id;
					this.variable_accion.value=valorAccion;
					this.formulario.submit();
				}
				else {
					return false;
				}
			},
			cancelar:function() {
				this.variable_accion.value="cancelar";
				this.formulario.submit();
			},
			validar:function() {
				return true;
			}
		};

		js_form.inicializar();
		function aceptar() {
			return js_form.aceptar();
		}
		function cancelar() {
			return js_form.cancelar();
		}
		';

		if (MOSTRAR_POPUP_ADMIN && $form_abm_1->mensaje!="") {
		    $resultado.="\nalert(\"". str_replace("\n","\\n",$form_abm_1->mensaje) . "\");";
		}

		if ($form_abm_1->redirigir && $form_abm_1->paginaRetorno) {
		    $resultado.="\nlocation.href='" . $form_abm_1->paginaRetorno . "'";
		}

		$resultado.='</script>';

		return $resultado;

	}

function contenidoArchivo($archivo) {
	$resultado="";
	$resultado=file_get_contents($archivo,FILE_USE_INCLUDE_PATH);
	return $resultado;
}

function escribirEnArchivo($archivo,$datos) {
	return @file_put_contents($archivo,$datos);  
}

?>
