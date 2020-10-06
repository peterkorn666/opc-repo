var ArrayPaises = new Array("Seleccione un pa�s","Afganist�n", "Albania", "Alemania", "Andorra", "Angola", "Anguila", "Antigua Rep�blica Yugoslava de Macedonia", "Antigua y Barbuda", "Arabia Saud�", "Argelia", "Argentina", "Armenia", "Australia", "Austria", "Azerbaiy�n", "Bahamas", "Bahr�in", "Bangladesh", "Barbados", "B�lgica", "Belice", "Ben�n", "Bermudas", "Bielorrusia", "Birmania (actualmente Myanmar) ", "Bolivia", "Bosnia y Herzegovina", "Botsuana", "Brasil", "Brun�i", "Bulgaria", "Burkina Faso", "Burundi", "But�n", "Cabo Verde", "Camboya", "Camer�n", "Canad�", "Chad", "Chequia", "Chile", "China", "Chipre", "Cisjordania y Franja de Gaza", "Colombia", "Comoras", "Congo", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "Emiratos �rabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "Espa�a", "Estados Unidos", "Estonia", "Etiop�a", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gab�n", "Gambia", "Georgia", "Ghana", "Granada", "Grecia", "Guadalupe", "Guadalupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guinea Ecuatorial", "Guyana", "Hait�", "Holanda (Pa�ses Bajos)", "Honduras", "Hong Kong", "Hungr�a", "India", "Indonesia", "Ir�n", "Iraq", "Irlanda", "Islandia", "Islas Marshall", "Islas Salom�n", "Israel", "Italia", "Jamaica", "Jap�n", "Jordania", "Kazajist�n", "Kenia", "Kirguizist�n", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "L�bano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Macedonia", "Madagascar", "Malasia", "Malaui", "Maldivas", "Mal�", "Malta", "Marruecos", "Mauritania", "Mauricio", "M�xico", "Micronesia", "Moldavia", "M�naco", "Mongolia", "Montenegro", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Nueva Zelanda", "Nicaragua", "N�ger", "Nigeria", "Niue", "Noruega", "Om�n", "Pa�ses Bajos", "Pakist�n", "Palau", "Palestina", "Panam�", "Pap�a-Nueva Guinea", "Paraguay", "Per�", "Polonia", "Portugal", "Puerto Rico", "Quatar", "Reino Unido", "Rep�blica Centroafricana", "Rep�blica Democr�tica del Congo", "Rep�blica Dominicana", "Rumania", "Rusia", "Ruanda", "Sahara Occidental", "Samoa", "San Crist�bal y Nieves", "San Marino", "San Vicente y las Granadinas", "Santa Luc�a", "Santo Tom� y Pr�ncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somal�a", "Sri Lanka", "Sud�frica", "Sud�n", "Suecia", "Suiza", "Surinam", "Suazilandia", "Tailandia", "Taiw�n", "Tanzania", "Tayikist�n", "Timor Oriental", "Togo", "Tonga", "Trinidad y Tobago", "T�nez", "Turkmenist�n", "Turqu�a", "Tuvalu", "Ucrania", "Uganda", "Uruguay", "Uzbekist�n", "Vanuatu", "Vaticano", "Venezuela", "Vietnam", "Yemen", "Yibuti", "Yugoslavia", "Zambia", "Zimbabue");

var cuantosAutores = 1;

var archivoAdjuntado = 0;

function agregarItem(cual,txt){
	
	var oOption = document.createElement("OPTION");
	oOption.text = txt;
	oOption.value = txt;
	cual.options.add(oOption);

}

function cargarPaises(){

		
			for(i=0;i<ArrayPaises.length; i++){
				if(cuantosAutores==1){
					agregarItem(document.form1.elements["pais[]"], ArrayPaises[i]);
				}else{
					agregarItem(document.form1.elements["pais[]"][cuantosAutores-1], ArrayPaises[i]);
				}
				
			
		}

	
}
cargarPaises()

var colorfila = 1;




function agregarCoAutor(){
	
		if (colorfila == 0){
			var color = "#F0F0F0";
			colorfila=1;
		} else {
			var color = "#E1E1E1";
			colorfila=0;
		}

	var tablaPersonas =  '<div id="divCoAutor_'+cuantosAutores+'">';
	    tablaPersonas += '<table width="376" border="0" align="center" cellpadding="5" bgColor="'+color+'" cellspacing="0" class="textos">';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td>Nombre: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td><input name="nombre[]" type="text" class="campos" id="nombre[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td width="70">Apellidos: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td width="309"><input name="apellido[]" type="text" class="campos" id="apellido[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td>Instituci&oacute;n:<font color="#FF0000">*</font></td>';
		tablaPersonas += '<td><input name="institucion[]" type="text" class="campos" id="institucion[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td>E-mail: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td><input name="mail[]" type="text" class="campos" id="mail[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td width="70">Pa&iacute;s: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td width="309"><select name="pais[]"  class="campos" id="pais[]"  style="width:300;">';
		tablaPersonas += '</select></td>';
		tablaPersonas += '</tr><tr>';
		tablaPersonas += '<td valign="bottom" class="horizontales"><font size="1" color="#666666">Co-autor '+cuantosAutores+'</font></td>';
		tablaPersonas += '<td class="horizontales"><input name="lee[]" type="hidden" id="lee[]"><input name="lee_[]" type="checkbox" id="lee_[]" value="1">';
		tablaPersonas += 'Este co-autor lee? <br>';
		tablaPersonas += '<input name="inscripto[]" type="hidden" id="inscripto[]"><input name="inscripto_[]" type="checkbox" id="inscripto_[]" value="1">';
		tablaPersonas += 'Este co-autor est&aacute; inscripto en el congreso?</td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '</table>';
 		tablaPersonas += '<a name="fin"><a>';
		tablaPersonas += '</div>';
		document.all.divPersonas.innerHTML += tablaPersonas;
		BotonElimiar(cuantosAutores)
		cuantosAutores = cuantosAutores + 1;
		cargarPaises();
	
}
/*agregos al principio un para de couatores nomas*/
agregarCoAutor();
agregarCoAutor();

function BotonElimiar(cual){
	if(cual>0){
	document.getElementById("divEliminarCoAutor").innerHTML= "<a href=\"#fin\" class=\"textos\" onClick=\"eliminarDivCoAutor("+cual+")\">[-] Eliminar el �ltimo co-autor</a>";
	}else{
		document.getElementById("divEliminarCoAutor").innerHTML="";
		}
	}


//
//Eliminar coautor
function eliminarDivCoAutor(cual){
	document.getElementById("divCoAutor_" + cual).innerHTML= "";
	document.getElementById("divCoAutor_" + cual).style.display= "none";
	document.getElementById("divCoAutor_" + cual).id="";
	cuantosAutores = cuantosAutores - 1;
	BotonElimiar(cual-1)
}


//
//cargar si lee y si esta inscripto

function cargarLeeInscripto(){

	if(cuantosAutores>1){
		for(u=0; u<cuantosAutores; u++){	
		
			if(document.form1.elements['lee_[]'][u].checked == true){
				document.form1.elements['lee[]'][u].value = "1";
			}else{
				document.form1.elements['lee[]'][u].value = "0";
			}
			
			if(document.form1.elements['inscripto_[]'][u].checked == true){
				document.form1.elements['inscripto[]'][u].value = "1";
			}else{
				document.form1.elements['inscripto[]'][u].value = "0";
			}
			
		}
			
	}

}
//
//Validar forma
function validar(){

	if(form1.tituloTl.value==""){
		alert("Por favor, ingrese el titulo del trabajo");
		document.form1.tituloTl.focus();
		return;
	}
	
	var areaTLSeleccionada = false;
	
	for(i=0; i<cuantasAreas; i++){
		if(document.form1.areaTL[i].checked == true){
			areaTLSeleccionada = true;
		}
	}
	
	if(areaTLSeleccionada==false){
		alert("Por favor, seleccione un �rea para el trabajo");
		return;
	}
	

	
	if(form1.contactoMail.value==""){
		alert("Por favor, ingrese un mail de contacto");
		document.form1.contactoMail.focus();
		return;
	}
	
	if (form1.contactoMail.value.indexOf('@', 0) == -1 || form1.contactoMail.value.indexOf('.', 0) == -1) {
	 	alert("Por favor, escriba un E-mail correcto.");
		form1.contactoMail.focus();
		return; 
	}
	
	if(cuantosAutores>1){
	
		for(i=0;i<cuantosAutores;i++) {
			
			if(document.form1.elements['nombre[]'][i].value==""){
				if(i==0){
					alert("Por favor, escriba un nombre para el autor presentador");
				}else{
					alert("Por favor, escriba un nombre para el co-autor " + i);
				}
				document.form1.elements['nombre[]'][i].focus();
				return; 
			}
			
			if(document.form1.elements['apellido[]'][i].value==""){
				if(i==0){
					alert("Por favor, escriba un apellido para el autor presentador");
				}else{
					alert("Por favor, escriba un apellido para el co-autor " + i);
				}
				document.form1.elements['apellido[]'][i].focus();
				return; 
			}
			
			if(document.form1.elements['institucion[]'][i].value==""){
				if(i==0){
					alert("Por favor, escriba una institucion para el autor presentador");
				}else{
					alert("Por favor, escriba una institucion para el co-autor " + i);
				}
				document.form1.elements['institucion[]'][i].focus();
				return; 
			}
			
			if(document.form1.elements['mail[]'][i].value==""){
				if(i==0){
					alert("Por favor, escriba un E-mail para el autor presentador");
				}else{
					alert("Por favor, escriba un E-mail para el co-autor " + i);
				}
				document.form1.elements['mail[]'][i].focus();
				return; 
			}
			
			
			if (document.form1.elements['mail[]'][i].value.indexOf('@', 0) == -1 || document.form1.elements['mail[]'][i].value.indexOf('.', 0) == -1) {
					
				if(i==0){
					alert("Por favor, escriba un E-mail correcto para el autor presentador");
				}else{
					alert("Por favor, escriba un E-mail correcto para el co-autor " + i);
				}
					
				document.form1.elements['mail[]'][i].focus();
				return; 
			}
				
			if(document.form1.elements['pais[]'][i].value=="Seleccione un pa�s"){
				if(i==0){
					alert("Por favor, seleccione un Pa�s para el autor presentador");
				}else{
					alert("Por favor, seleccione un Pa�s  para el co-autor " + i);
				}
				document.form1.elements['pais[]'][i].focus();
				return; 
			}	
	
		}
	}else{
			if(document.form1.elements['nombre[]'].value==""){
				alert("Por favor, escriba un nombre para el autor presentador");
				document.form1.elements['nombre[]'].focus();
				return; 
			}
			
			if(document.form1.elements['apellido[]'].value==""){
				alert("Por favor, escriba un apellido para el autor presentador");
				document.form1.elements['apellido[]'].focus();
				return; 
			}
			
			if(document.form1.elements['institucion[]'].value==""){
				alert("Por favor, escriba una institucion para el autor presentador");
				document.form1.elements['institucion[]'].focus();
				return; 
			}
			
			if(document.form1.elements['mail[]'].value==""){		
				alert("Por favor, escriba un E-mail para el autor presentador");
				document.form1.elements['mail[]'].focus();
				return; 
			}
			
			if (document.form1.elements['mail[]'].value.indexOf('@', 0) == -1 || document.form1.elements['mail[]'].value.indexOf('.', 0) == -1) {
				alert("Por favor, escriba un E-mail correcto para el autor presentador");
				document.form1.elements['mail[]'].focus();
				return; 
			}
				
			if(document.form1.elements['pais[]'].value=="Seleccione un pa�s"){
				alert("Por favor, seleccione un Pa�s para el autor presentador");
				document.form1.elements['pais[]'].focus();
				return; 
			}	
	
		
	}
	
	if(archivoAdjuntado == 0){
		alert("Por favor, debe adjuntar alg�n archivo del trabajo.")
		document.form1.archivo.focus();
		return; 
	}	
		cargarLeeInscripto();
		
		form1.action="inscripcionTL_enviar.php";
		form1.target="_self" ;
		form1.submit();
	

	
}

function adjuntarArchivo(){
	
	var extension = document.form1.archivo.value.substring((document.form1.archivo.value.length-3),document.form1.archivo.value.length);
	
	document.form1.extensionArchivo.value= extension
	
	if(document.form1.archivo.value==""){
		alert("Por favor, seleccione un archivo para ser adjuntado");
		document.form1.archivo.focus();
		return; 
	}

	
	document.getElementById("imgAdjuntando").style.display="inline";
	document.getElementById('adjuntando').style.display='none';
	document.getElementById("adjuntando").innerHTML = "<iframe id='marcoCargando' name='marcoCargando' src='adjuntando.php' scrolling='auto' height='100' frameborder='0' width='100%'></iframe>"
	form1.action="adjuntando.php"
	form1.target="marcoCargando" 
	form1.submit();
	
}



function activarEnviar(){
	
		if(form1.acepto.checked==true){
			form1.enviar.disabled = false;	
		}else{
			form1.enviar.disabled = true;	
		}
	
}
activarEnviar();
