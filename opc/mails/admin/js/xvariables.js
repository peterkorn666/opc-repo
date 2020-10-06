
var dec=1/2;
var str="" + dec;
var separadorDecimal=str.substr(1,1);

function reemplazarSeparadorDecimal(nombreCampo) {
	valor=buscarValor("form1",nombreCampo);
	valor=valor.replace(",",separadorDecimal);
	asignarValor("form1",nombreCampo,valor);
}

function iniciar() {

}

function agregarVariable(nombreArray,nombre,label,predeterminado,textoAyuda,nombreFuncionFocus,nombreFuncionBlur,nombreFuncionChange,nombreFuncionKeyPress,formato,requerida,largo,decimales,valoresPosibles,expresionesValidacion,expresionesFocus,habilitada,visible) {
	 variables[variables.length]=nombre;
	 variablesLabels[nombre]=label;
	 variablesArray[nombre]=nombreArray;
	 variablesPredeterminado[nombre]=predeterminado;
	 variablesAyuda[nombre]=unescape(textoAyuda);
	 variablesFuncionesFocus[nombre]=nombreFuncionFocus;
	 variablesFuncionesBlur[nombre]=nombreFuncionBlur;
	 variablesFuncionesChange[nombre]=nombreFuncionChange;
	 variablesFuncionesKeyPress[nombre]=nombreFuncionKeyPress;
	 variablesFormato[nombre]=formato;
	 variablesRequerida[nombre]=requerida;
	 variablesLargo[nombre]=largo;
	 variablesDecimales[nombre]=decimales;
	 variablesValoresPosibles[nombre]=valoresPosibles;
	 variablesExpresionesValidacion[nombre]=[];
	 variablesExpresionesFocus[nombre]=[];
	 
	 if (isArray(expresionesValidacion)) {
		for(i=0;i<expresionesValidacion.length;i++) {
			variablesExpresionesValidacion[nombre].push(expresionesValidacion[i]);
		}
	 } else {
		if (expresionesValidacion!="") {
			variablesExpresionesValidacion[nombre].push(expresionesValidacion);
		}
	 }
	 
	 if (isArray(expresionesFocus)) {
		for(i=0;i<expresionesFocus.length;i++) {
			variablesExpresionesFocus[nombre].push(expresionesFocus[i]);
		}
	 } else {
		if (expresionesFocus!="") {
			variablesExpresionesFocus[nombre].push(expresionesFocus);
		}
	 }
	 
	 variablesHabilitada[nombre]=habilitada;
	 variablesVisible[nombre]=visible;
	 
}

function isArray(obj) {
   if (obj.constructor.toString().indexOf("Array") == -1)
      return false;
   else
      return true;
}

var variables=[];
var variablesLabels=[];
var variablesArray=[];
var variablesPredeterminado=[];
var variablesAyuda=[];
var variablesFuncionesFocus=[];
var variablesFuncionesBlur=[];
var variablesFuncionesChange=[];
var variablesFuncionesKeyPress=[];
var variablesFormato=[];
var variablesRequerida=[];
var variablesLargo=[];
var variablesDecimales=[];
var variablesValoresPosibles=[];
var variablesExpresionesValidacion=[];
var variablesExpresionesFocus=[];
var variablesHabilitada=[];
var variablesVisible=[];


function escribirDatos(nombreArray,arrayDatos) {
	  var i;
	  for(i=0;i<variables.length;i++) {
		  if (variablesArray[variables[i]]==nombreArray) {
			 eval("asignarValor('form1','" + variables[i] + "','" + arrayDatos[variables[i]] + "');");
		  }
	  }
}

function leerDatos(nombreArray) {
	var i;
	arrayDatos=[];
	for(i=0;i<variables.length;i++) {
		if (variablesArray[variables[i]]==nombreArray) {
			arrayDatos[variables[i]]=buscarValor('form1',variables[i]);
		}
	}
	return arrayDatos;
}


function fijarFoco(nombreCampo) {
	var campo=MM_findObj(nombreCampo);
	if (campo) {
		if (campo.type) {
			campo.focus(); // da error si el campo esta oculto
		}
	}
}


function mayusculas(nombreCampo) {
	var campo=MM_findObj(nombreCampo);
	
	if (campo) {
		if (campo.type && (campo.type=="text" || campo.type=="textarea") ){	
			var campoCheck=MM_findObj("mayusculas_" + nombreCampo);
			if (!campoCheck || campoCheck.checked) {
						
				nuevoValor=campo.value.toUpperCase();								

				campo.value=nuevoValor;
				
				ocultarAvisos();
			}
		}


		
	}
	return "";
}

function revisarUnidades(nombreCampo,mayusculas) {
	var campo=MM_findObj(nombreCampo);
	if (campo) {
		if (campo.type && (campo.type=="text" || campo.type=="textarea") ){	
			valor=campo.value;
	
			// lista de palabras que tienen que quedar minMay
			var excepciones=new Array("Kg","g","mg","mcg","L","dL","mL","cc","UI","Kcal","mEq","mOsm","ºC");
			var caracteresPosterioresBuscar=new Array(" ","\\.",";",",","\\-","\\/","\\)","$");
			var caracteresPosterioresReemplazar=new Array(" ",".",";",",","-","/",")","");
			var caracteresAnterioresBuscar=new Array(" ","0","1","2","3","4","5","6","7","8","9","\\-","^","\\/");
			var caracteresAnterioresReemplazar=new Array(" ","0 ","1 ","2 ","3 ","4 ","5 ","6 ","7 ","8 ","9 ","-","","/");
			var buscar="";
			var reemplazar="";
			var temp="";
			
			eval("valor=valor.replace(/º C/gi, 'ºC');");
			
			for(i=0;i<excepciones.length;i++) {
				for(j=0;j<caracteresAnterioresBuscar.length;j++) {
					for(k=0;k<caracteresPosterioresBuscar.length;k++) {
						if (mayusculas) {
							buscar=caracteresAnterioresBuscar[j] + excepciones[i].toUpperCase() + caracteresPosterioresBuscar[k];
						} else {
							buscar=caracteresAnterioresBuscar[j] + excepciones[i] + caracteresPosterioresBuscar[k];
						}
						reemplazar=caracteresAnterioresReemplazar[j] + excepciones[i] + caracteresPosterioresReemplazar[k];
						eval("valor=valor.replace(/" + buscar + "/gi, '" + reemplazar +"');");
					}
				}
			}
			
			campo.value=valor;
		}
	}
	return "";
}



function vaciarDatos(nombreArray) {
	var i;
	for(i=0;i<variables.length;i++) {
	  if (variablesArray[variables[i]]==nombreArray) {
		 eval("asignarValor('form1','" + variables[i] + "','" + variablesPredeterminado[variables[i]] + "');");
	  }
	}
}


function buscarValor(form,nombreCampo) {
	var valor=null;
	var i;
	var campo=MM_findObj(nombreCampo);
	if (campo) {
			if (campo.type) {
				switch(campo.type) {
					case "text":
					case "password":
						valor=campo.value;
					break;
					case "textarea":
						valor=campo.value;
					break;
					case "select-one":
						if (campo.selectedIndex>-1) {
							var opcion=campo.options[campo.selectedIndex];
							if (opcion) {
								valor=opcion.value;
								if (valor=="") {
										valor=opcion.text;
								}
							}
						}
					break;
					case "checkbox":
						valor=campo.checked;
					break;
					case "hidden":
						valor=campo.value;
					break;
				}
			} else {
				//radiobuttons
				for (i=0;i<campo.length;i++) {
					if(campo[i].type=="radio") {
						if (campo[i].checked) {
								valor=campo[i].value;
						}
					}
				}
			}
	}
	return valor;
}

function asignarValor(form,nombreCampo,valor) {
	var campo=MM_findObj(nombreCampo);
	var valorAnterior=null;
	var i=0;
	if (campo && !(valor==undefined || valor==null || valor=="undefined")) {
		if (campo.type) {
			switch(campo.type) {
				case "text":
					valorAnterior=campo.value;
					campo.value=valor;
				break;
				case "textarea":
					valorAnterior=campo.value;
					campo.value=valor;
				break;
				case "select-one":
					valorAnterior=campo.selectedIndex;
					campo.selectedIndex=-1;
					while (i<campo.options.length && campo.selectedIndex==-1) {
							if (campo.options[i].value==valor || campo.options[i].text==valor) {
									campo.selectedIndex=i;
							}
							i++;
					}
				break;
				case "checkbox":
					valorAnterior=campo.checked;
					campo.checked=eval(valor);
				break;
				case "hidden":
					valorAnterior=campo.value;
					campo.value=valor;
				break;
				default:
					valorAnterior=campo.value;
					campo.value=valor;
				break;
			}
		} else {
			//radiobuttons
			for (i=0;i<campo.length;i++) {
				if(campo[i].type=="radio") {
					 if(campo[i].checked) {
						valorAnterior=campo[i].value;
					 }
					 campo[i].checked=(campo[i].value==valor);
				}
			}
		}
	}
}

function asignarFuncion(nombreCampo,nombreEvento,nombreFuncion) {
	var campo=null;
	campo=MM_findObj(nombreCampo);
	if (campo) {
	  if (campo.type) {
		  eval("campo." + nombreEvento + "="+nombreFuncion);
	  } else {
		 for (var i=0;i<campo.length;i++) {
			 if(campo[i].type=="radio") {
					eval("campo[i]." + nombreEvento + "="+nombreFuncion + ";");
			 }
		 }
	  }
	}
}

function MM_findObj(n, d) { //v4.0
if (n) {
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}
}
        if(!document.getElementById){
          if(document.all)
          document.getElementById=function(){
                if(typeof document.all[arguments[0]]!="undefined")
                return document.all[arguments[0]]
                else
                return null
          }
          else if(document.layers)
          document.getElementById=function(){
                if(typeof document[arguments[0]]!="undefined")
                return document[arguments[0]]
                else
                return null
          }
        }

function getStyleObject(objectId) {
  // checkW3C DOM, then MSIE 4, then NN 4.
  //
  if(document.getElementById && document.getElementById(objectId)) {
		return document.getElementById(objectId).style;
   }
   else if (document.all && document.all(objectId)) {
		return document.all(objectId).style;
   }
   else if (document.layers && document.layers[objectId]) {
		return document.layers[objectId];
   } else {
		return false;
   }
}


function obtenerPosicion(element) {

    var valueT = 0, valueL = 0;
    do {
      valueT += element.offsetTop  || 0;
      valueL += element.offsetLeft || 0;
      element = element.offsetParent;
      if (element) {
        if (element.tagName == 'BODY') break;
        var p = Element.getStyle(element, 'position');
        if (p == 'relative' || p == 'absolute') break;
      }
    } while (element);
	
	if( (typeof( window.innerWidth ) != 'number' ) && document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		valueT+=16;
    }
	
    return Element._returnOffset(valueL, valueT);
}


function obtenerTamanoVentana() {
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  var result = [myWidth ,myHeight];
  result.width = myWidth;
  result.height = myHeight;
  return result;
}

function asignarEstado(nombreElemento,estado) {
	var elemento=document.getElementById(nombreElemento);
	if (elemento) {
		if (elemento.type=="radio") {
			//esta harcodeado "form1", ver como referenciar el objeto
			radioGroup=form1.elements[nombreElemento];
			radioGroup.disabled = !estado;
			for (var b = 0; b < radioGroup.length; b++) {
				  radioGroup[b].disabled = !estado;
			}
		} else {
			elemento.disabled=!estado;
		}
		
	}
	return false;
}

function asignarVisibilidad(nombreElemento,estado) {
	if (estado) {
		asignarEstilo(nombreElemento,"display","block");
	} else  {
		asignarEstilo(nombreElemento,"display","none");
	}
}


function asignarVisibilidadSeccion(nombreSeccion,estado) {
	asignarVisibilidad(nombreSeccion,estado);
}

function asignarEstilo(nombreElemento,estilo,valor) {
	var elemento=document.getElementById(nombreElemento);
	if (elemento) {
		var estiloSeccion = getStyleObject(nombreElemento);
		if (estiloSeccion) {
			eval("estiloSeccion." + estilo + " = \"" + valor + "\"");
		}
	}
	return false;
}

function blurCampo(e) {
	 if (!e) var e=event;
	 var obj=null;
	 if (e.srcElement) {
		 obj=e.srcElement;
	 }
	 else if(e.target) {
		  obj=e.target;
	 }
	 if (obj) {
		 ocultarAyuda(obj.name);
		 if (variablesFuncionesBlur[obj.name]) {
			 eval(variablesFuncionesBlur[obj.name]);
		 }
		mostrarAvisos(validarCampo(obj.name));
	 }
	 return true;
}



function overCampo(e) {
	if (!e) var e=event;
	var obj=null;
	if (e.srcElement) {
		obj=e.srcElement;
	}
	else if(e.target) {
		obj=e.target;
	}
	if (obj) {
		mostrarAyuda(e,obj.name);
	}
	return true;
}

function outCampo(e) {
	if (!e) var e=event;
	var obj=null;
	if (e.srcElement) {
		obj=e.srcElement;
	}
	else if(e.target) {
		obj=e.target;
	}
	if (obj) {
		ocultarAyuda(obj.name);
	}
	return true;
}


function focusCampo(e) {
	if (!e) var e=event;
	var obj=null;
	if (e.srcElement) {
		obj=e.srcElement;
	}
	else if(e.target) {
		obj=e.target;
	}
	if (obj) {
		mostrarAyuda(e,obj.name);
		if (variablesFuncionesFocus[obj.name]) {
			eval(variablesFuncionesFocus[obj.name]);
		}
		for(ii=0;ii<variablesExpresionesFocus[obj.name].length;ii++) {
			eval(variablesExpresionesFocus[obj.name][ii]);
		}
	}
	return true;
}


function changeCampo(e) {
	if (!e && typeof(event)!="undefined") var e=event;
	var obj=null;
	if (e) {
		if (e.srcElement) {
			obj=e.srcElement;
		}
		else if(e.target) {
			obj=e.target;
		}
	} else {
		obj=this;
	}
	if (obj) {
		if (variablesFuncionesChange[obj.name]) {
			eval(variablesFuncionesChange[obj.name]);
		}
	}
	cancelBubble=false;
	return true;
}


function keyPressCampo(e) {
	if (!e) var e=event;
	var obj=null;
	if (e.srcElement) {
		obj=e.srcElement;
	}
	else if(e.target) {
		obj=e.target;
	}
	if (obj) {
		if (obj.type) {
			if (obj.type=="text") {
				//obj.value=obj.value.toUpperCase();
			}
		}

		if (variablesFuncionesKeyPress[obj.name]) {
			eval(variablesFuncionesKeyPress[obj.name]);
		}	
		tecla=eventKey(e);
		if (tecla) {
			resultado=validarTecla(obj,tecla);
		} else {
			resultado=true;
		}
		if (e.returnValue) {
			e.returnValue=resultado;
		}  else {
			return resultado;
		}			
	}
	return true;
}

function eventKey(e)
{
	var keynum;
	var keychar;
	if(window.event) // IE
	{
	keynum = e.keyCode;
	}
	else if(e.which) // Netscape/Firefox/Opera
	{
	keynum = e.which;
	}
	if (keynum>31) {
		keychar = String.fromCharCode(keynum);
		return (keychar);
	} else {
		return false;
	}
}


function mostrarAvisos(avisos) {
	if (avisos!="") {
		window.status=avisos;
	} else {
		ocultarAvisos();
	}
}

function ocultarAvisos() {
	window.status="";
}

function mostrarAyuda(e,variable) {	
    if (variablesAyuda[variable]!="") {
		window.status=variablesAyuda[variable];
    }
}

function ocultarAyuda(variable) {
	window.status="";
}

function validarDatos(nombreArray,focus) {
	var i;
	var errores="";
	var valor="";
	var primerCampo="";
	var err="";
	for(i=0;i<variables.length;i++) {
		err="";
		if (nombreArray=="" || variablesArray[variables[i]]==nombreArray) {
			if (variablesHabilitada[variables[i]]) {
				err=validarCampo(variables[i],false);
				if (err!="") {
					errores+="\n" + err;
					if (primerCampo=="") {
						primerCampo=variables[i];
					}
				}
			}
		}
	}
	if (focus && primerCampo!="") {
		fijarFoco(primerCampo);
	}
	return errores;
}

function validarCampo(nombreCampo,focus) {
	var errores="";
	var valor=buscarValor('form1',nombreCampo);
	var formato=variablesFormato[nombreCampo];
	var largo=variablesLargo[nombreCampo];
	var decimales=variablesDecimales[nombreCampo];

	asignarEstilo(nombreCampo,"background","white") ;
	
	for(ii=0;ii<variablesExpresionesValidacion[nombreCampo].length;ii++) {
		err="";
		eval("err=" + variablesExpresionesValidacion[nombreCampo][ii]);
		if (err!="") {
			errores=errores+err;
		}
	}
	if (errores=="") {
		if (eval(variablesRequerida[nombreCampo])) {
			if (valor=="" || valor==null || (formato!="N0" && formato!="double" && formato!="int" && formato!="2" && formato!="10" && valor=="0")) {
				errores=variablesLabels[nombreCampo] + " es requerida.";
			}
		}	
		if (errores=="" && valor!=null && valor!="") {
			if (largo>0 && largo<valor.length) {
				errores="El largo máximo del campo "+ variablesLabels[nombreCampo] +" es " + largo +" y está usando " + valor.length;
			} else {
				errores=validarTipoDato(nombreCampo,formato,valor,largo,decimales);
				if (errores=="") {
					if (valor!="") {
						errores=validarValoresPosibles(valor,variablesValoresPosibles[nombreCampo],formato);
						if (errores!="") {
							errores=variablesLabels[nombreCampo] + " debería: " + errores;
						}
					}				
				}
				
			}
		}
	}
	
	if (errores!="") {
		asignarEstilo(nombreCampo,"background","#ffeeee") ;
		if (focus) {
			fijarFoco(nombreCampo);
		}
	}
	return errores;
}


function validarTipoDato(nombreCampo,tipoDato,valor,largo,decimales) {
	var errTipo="";
	switch (tipoDato) {
			/*
			1	string	Texto
			2	Numero
			3	bool	Boolean
			4	dataTime	Fecha y Hora
			5	excluyentes	Opciones excluyentes
			6	no_excluyentes	Opciones no excluyentes
			7	fecha	Fecha
			8	hora	Hora
			9 	email
			10 	entero
			*/	
		case "1":
		break;
		case "email":
		case "9":
			if (valor!="" && !validarEmail (valor)) {
				errTipo=variablesLabels[nombreCampo] + " no es un Email válido.";
			}
		break;
		case "double":
		case "2":					
			valor=valor.replace(",",separadorDecimal);
			reemplazarSeparadorDecimal(nombreCampo);
			if (  (valor!="" && !validarNumero(valor,largo,decimales)) || isNaN(valor)) {
				errTipo="En el campo " + variablesLabels[nombreCampo];								
				if (decimales>0) {
					errTipo+=" puede ingresar hasta " + (largo-1-decimales) + " enteros y  " + decimales;
					if (decimales==1) {
						errTipo+= " decimal";
					} else {
						errTipo+= " decimales";
					}
				} else {
					errTipo+=" Puede ingresar un número entero de hasta " + largo + " dígitos de largo.";
				}
			}
		break;
		case "int":
		case "10":
			if ((!IsNumeric(valor) && valor!=0)|| isNaN(valor)) {
				errTipo=variablesLabels[nombreCampo] + " no es un número válido.";
			}
		break;
	}
	return errTipo;
}

function validarTecla(campo,c) {
	var seleccionado=(getSel(campo)!="");
	var largo=variablesLargo[campo.name];	
	var formato=variablesFormato[campo.name];
	switch (formato) {
			/*
			1	string	Texto
			2	numerico	Numerico
			3	bool	Boolean
			4	dataTime	Fecha y Hora
			5	excluyentes	Opciones excluyentes
			6	no_excluyentes	Opciones no excluyentes
			7	fecha	Fecha
			8	hora	Hora
			9 	email
			10 	int Entero
			*/	
		case "text":
		case "varchar":
		case "1":
			return (seleccionado || largo=="" || (largo && largo>campo.value.length));
		break;
		case "email":
		case "9":			
			aceptados="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@._-,;";
			return (seleccionado || largo=="" || (largo && largo>campo.value.length)) && (aceptados.indexOf(c) != -1);
			break;
		case "double":
		case "2":
			aceptados="0123456789";
			decimales=variablesDecimales[campo.name];
			if (decimales!=0 && decimales!="") {
				valor=campo.value;
				if (valor.indexOf(".") == -1 && valor.indexOf(",") == -1) {
					aceptados += ".,";
				}
			}
			return (seleccionado || largo=="" || (largo && largo>campo.value.length)) && (aceptados.indexOf(c) != -1);
			break;
		case "int":
		case "10":
			return (seleccionado || largo=="" || (largo && largo>campo.value.length)) && ("0123456789".indexOf(c) != -1);
		break;
	}

	return true;
}


function getSel(campo)
{
	txt="";
	if(window.getSelection){
		txt = window.getSelection();
	} else if(txt=="" && document.getSelection){
		txt = document.getSelection();
	} else if (txt=="" && document.selection)
	{
		txt = document.selection.createRange().text;
	} else if ( txt =="" && (campo.selectionStart != undefined || campo.selectionEnd != undefined))
	{
		inicio=campo.selectionStart;
		fin= campo.selectionEnd;
		if (campo.value) {
			txt=campo.value.substring(inicio,fin);
		}
	}
	return txt;
}

function evaluarRegExp(expresion,valor) {
  resultado=true;
  if (expresion!=null && expresion!="" && valor!=null && valor!="") {  
	var re = new RegExp(expresion);
	if (re!=null && typeof(re)=="object") {	
		resultado=(valor.match(re)); //test de la regwxp
	}
  }
  return resultado;
}




function pedirConfirmacion(texto) {
	return confirm(texto);
}

function validarFecha(dia,mes,anio) {
		var errFecha="";
		if (anio.length!=4) {
			errFecha="El año debe ser de 4 cifras";
		}
		else {
			errFecha=check_date(dia,mes,anio);
		}
		return errFecha;
}

function emailCheck (emailStr) {
/* The following pattern is used to check if the entered e-mail address
   fits the user@domain format.  It also is used to separate the username
   from the domain. */
var emailPat=/^(.+)@(.+)$/
/* The following string represents the pattern for matching all special
   characters.  We don't want to allow special characters in the address. 
   These characters include ( ) < > @ , ; : \ " . [ ]    */
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
/* The following string represents the range of characters allowed in a 
   username or domainname.  It really states which chars aren't allowed. */
var validChars="\[^\\s" + specialChars + "\]"
/* The following pattern applies if the "user" is a quoted string (in
   which case, there are no rules about which characters are allowed
   and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
   is a legal e-mail address. */
var quotedUser="(\"[^\"]*\")"
/* The following pattern applies for domains that are IP addresses,
   rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
   e-mail address. NOTE: The square brackets are required. */
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
/* The following string represents an atom (basically a series of
   non-special characters.) */
var atom=validChars + '+'
/* The following string represents one word in the typical username.
   For example, in john.doe@somewhere.com, john and doe are words.
   Basically, a word is either an atom or quoted string. */
var word="(" + atom + "|" + quotedUser + ")"
// The following pattern describes the structure of the user
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
/* The following pattern describes the structure of a normal symbolic
   domain, as opposed to ipDomainPat, shown above. */
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")


/* Finally, let's start trying to figure out if the supplied address is
   valid. */

/* Begin with the coarse pattern to simply break up user@domain into
   different pieces that are easy to analyze. */
var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
  /* Too many/few @'s or something; basically, this address doesn't
     even fit the general mould of a valid e-mail address. */
	//alert("Email address seems incorrect (check @ and .'s)")
	return false
}
var user=matchArray[1]
var domain=matchArray[2]

// See if "user" is valid 
if (user.match(userPat)==null) {
    // user is not valid
    //alert("The username doesn't seem to be valid.")
    return false
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
   host name) make sure the IP address is valid. */
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        //alert("Destination IP address is invalid!")
		return false
	    }
    }
    return true
}

// Domain is symbolic name
var domainArray=domain.match(domainPat)
if (domainArray==null) {
	//alert("The domain name doesn't seem to be valid.")
    return false
}

/* domain name seems valid, but now make sure that it ends in a
   three-letter word (like com, edu, gov) or a two-letter word,
   representing country (uk, nl), and that there's a hostname preceding 
   the domain or country. */

/* Now we need to break up the domain to get a count of how many atoms
   it consists of. */
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
    domArr[domArr.length-1].length>3) {
   // the address must end in a two letter or three letter word.
   //alert("The address must end in a three-letter domain, or two letter country.")
   return false
}

// Make sure there's a host name preceding the domain.
if (len<2) {
   var errStr="This address is missing a hostname!"
   //alert(errStr)
   return false
}

// If we've gotten this far, everything's valid!
return true;
}

function validarNumero(valor,largoTotal,decimales) {
	if (valor==null || largoTotal==null || decimales==null) {
		return true;
	} else {
		if (decimales!="" && decimales>0) {
			enteros=largoTotal-decimales-1;
			exp="^([1-9]{0,1}[0-9]{0," + (enteros-1) + "}([\.|,]{1}[0-9]{1}[0-9]{0," + (decimales-1) + "})?|0([\.|,]{1}[0-9]{1}[0-9]{0," + (decimales-1) + "})?)$";	
			//exp="^([1-9]{1}[0-9]{0," + (enteros-1) + "}([\.|,][0-9]{" + decimales + "})?|0(\.[0-9]{" + decimales + "})?)$";	
		} else {
			enteros=largoTotal;
			exp="^([0-9]{0," + (enteros) + "})$";	
		}
		return(evaluarRegExp(exp,valor)!=null);
	}
}

function validarEmail(valor) {
	resultado=true;
	// permite varios mails separados por , o ;
	arrMails=valor.split(new RegExp( "[,|;]"));
	for(i = 0; i < arrMails.length; i++){
		resultado=resultado && emailCheck (arrMails[i]);
	}	
	return resultado;
}
 

function IsNumeric(strString)
   //  check for valid numeric strings	
   {
   var strValidChars = "0123456789";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnResult = false;
         }
      }
   return blnResult;
   }

function check_date(day,month,year){
var leap = 0;
var err = 0;
   err = 0;
   if (year == 0) {
      err = 20;
   }
   if ((month < 1) || (month > 12)) {
      err = 21;
   }
   if (day < 1) {
     err = 22;
   }
   /* Validation leap-year / february / day */
   if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)) {
      leap = 1;
   }
   if ((month == 2) && (leap == 1) && (day > 29)) {
      err = 23;
   }
   if ((month == 2) && (leap != 1) && (day > 28)) {
      err = 24;
   }
   /* Validation of other months */
   if ((day > 31) && ((month == "01") || (month == "03") || (month == "05") || (month == "07") || (month == "08") || (month == "10") || (month == "12"))) {
      err = 25;
   }
   if ((day > 30) && ((month == "04") || (month == "06") || (month == "09") || (month == "11"))) {
      err = 26;
   }
   if (err == 0) {
      return "";
   }
   else {
      return "Fecha incorrecta";
   }
}	

function validarValoresPosibles(valor,valoresPosibles,tipoDato) {

	resultado=false;
	mensaje="";
	
	if (valoresPosibles!="") {
		valoresPosibles=valoresPosibles.replace(/\/,/g, "###___###");
		arrValores=valoresPosibles.split(",");		
		for(i = 0; i < arrValores.length; i++){
			v=arrValores[i];
			arrRangos=v.split("-");
			desde="";
			hasta="";
			desde_valor="";
			hasta_valor="";
			
			switch (arrRangos.length){
				case 0:
					desde=v;
					hasta=v;
				break;
				case 1:
					desde=v;
					hasta=v;
				break;
				case 2:
					desde=arrRangos[0];
					hasta=arrRangos[1];
				break;
			}
			
			arrValorTexto=desde.split(":");
			desde_valor="";
			desde_texto="";
			switch (arrValorTexto.length){
				case 0:
					desde_valor=desde;
					desde_texto=desde;
				break;
				case 1:
					desde_valor=desde;
					desde_texto=desde;
				break;
				case 2:
					desde_valor=arrValorTexto[0];
					desde_texto=arrValorTexto[1];
				break;
			}
			
			arrValorTexto=hasta.split(":");
			hasta_valor="";
			hasta_texto="";
			switch (arrValorTexto.length){
				case 0:
					hasta_valor=hasta;
					hasta_texto=hasta;
				break;
				case 1:
					hasta_valor=hasta;
					hasta_texto=hasta;
				break;
				case 2:
					hasta_valor=arrValorTexto[0];
					hasta_texto=arrValorTexto[1];
				break;
			}
			if (mensaje!="") {
				mensaje+=" o ";
			}
			if (desde_valor == hasta_valor) {
				mensaje+="ser igual a " + desde_texto.replace(/###___###/g,",");
			} else {
				mensaje+="estar entre " + desde_texto.replace(/###___###/g,",") + " y " + hasta_texto.replace(/###___###/g,",");
			}
			desde_valor=desde_valor.replace(/###___###/g,",");			
			hasta_valor=hasta_valor.replace(/###___###/g,",");			
			
			switch (tipoDato) {
					/*
					1	string	Texto
					2	Numero
					3	bool	Boolean
					4	dataTime	Fecha y Hora
					5	excluyentes	Opciones excluyentes
					6	no_excluyentes	Opciones no excluyentes
					7	fecha	Fecha
					8	hora	Hora
					9 	email
					10 	entero
					*/	
				case "1":
				case "email":
				case "text":
				case "varchar":
				case "9":
					resultado=resultado || !(valor<desde_valor || valor>hasta_valor);
				break;
				case "double":
				case "2":
					resultado=resultado || !(parseFloat(valor)<parseFloat(desde_valor) || parseFloat(valor)>parseFloat(hasta_valor));
				break;
				case "int":
				case "10":
					resultado=resultado || !(parseInt(valor)<parseInt(desde_valor) || parseInt(valor)>parseInt(hasta_valor));
				break;
			}
			
		}
	}
	
	if (resultado) {
		return "";
	} else {
		return mensaje;
	}
}


/*
valores posibles
separados por comas
valor:texto
valores únicos 1,2,3,4,ana,1:juan,4:rojo,verde azulado,\,
rangos 3-4,a-z
*/
