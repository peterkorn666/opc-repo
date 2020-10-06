var ArrayPaises = new Array("Select country","Afganist�n", "Albania", "Alemania", "Andorra", "Angola", "Anguila", "Antigua Rep�blica Yugoslava de Macedonia", "Antigua y Barbuda", "Arabia Saud�", "Argelia", "Argentina", "Armenia", "Australia", "Austria", "Azerbaiy�n", "Bahamas", "Bahr�in", "Bangladesh", "Barbados", "B�lgica", "Belice", "Ben�n", "Bermudas", "Bielorrusia", "Birmania (actualmente Myanmar) ", "Bolivia", "Bosnia y Herzegovina", "Botsuana", "Brasil", "Brun�i", "Bulgaria", "Burkina Faso", "Burundi", "But�n", "Cabo Verde", "Camboya", "Camer�n", "Canad�", "Chad", "Chequia", "Chile", "China", "Chipre", "Cisjordania y Franja de Gaza", "Colombia", "Comoras", "Congo", "Corea del Norte", "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca", "Dominica", "Ecuador", "Egipto", "El Salvador", "Emiratos �rabes Unidos", "Eritrea", "Eslovaquia", "Eslovenia", "Espa�a", "Estados Unidos", "Estonia", "Etiop�a", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gab�n", "Gambia", "Georgia", "Ghana", "Granada", "Grecia", "Guadalupe", "Guadalupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guinea Ecuatorial", "Guyana", "Hait�", "Holanda (Pa�ses Bajos)", "Honduras", "Hong Kong", "Hungr�a", "India", "Indonesia", "Ir�n", "Iraq", "Irlanda", "Islandia", "Islas Marshall", "Islas Salom�n", "Israel", "Italia", "Jamaica", "Jap�n", "Jordania", "Kazajist�n", "Kenia", "Kirguizist�n", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia", "L�bano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo", "Macedonia", "Madagascar", "Malasia", "Malaui", "Maldivas", "Mal�", "Malta", "Marruecos", "Mauritania", "Mauricio", "M�xico", "Micronesia", "Moldavia", "M�naco", "Mongolia", "Montenegro", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Nueva Zelanda", "Nicaragua", "N�ger", "Nigeria", "Niue", "Noruega", "Om�n", "Pa�ses Bajos", "Pakist�n", "Palau", "Palestina", "Panam�", "Pap�a-Nueva Guinea", "Paraguay", "Per�", "Polonia", "Portugal", "Puerto Rico", "Quatar", "Reino Unido", "Rep�blica Centroafricana", "Rep�blica Democr�tica del Congo", "Rep�blica Dominicana", "Rumania", "Rusia", "Ruanda", "Sahara Occidental", "Samoa", "San Crist�bal y Nieves", "San Marino", "San Vicente y las Granadinas", "Santa Luc�a", "Santo Tom� y Pr�ncipe", "Senegal", "Serbia", "Seychelles", "Sierra Leona", "Singapur", "Siria", "Somal�a", "Sri Lanka", "Sud�frica", "Sud�n", "Suecia", "Suiza", "Surinam", "Suazilandia", "Tailandia", "Taiw�n", "Tanzania", "Tayikist�n", "Timor Oriental", "Togo", "Tonga", "Trinidad y Tobago", "T�nez", "Turkmenist�n", "Turqu�a", "Tuvalu", "Ucrania", "Uganda", "Uruguay", "Uzbekist�n", "Vanuatu", "Vaticano", "Venezuela", "Vietnam", "Yemen", "Yibuti", "Yugoslavia", "Zambia", "Zimbabue");

var cuantosAutores = 1;

var archivoAdjuntado = 0;
var archivoAdjuntadoR = 0;


function agregarItem(cual,txt){
	
	var oOption = document.createElement("OPTION");
	oOption.text = txt;
	oOption.value = txt;
	cual.options.add(oOption);

}
//*
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
	    tablaPersonas += '<table width="399" border="0" align="center" cellpadding="5" bgColor="'+color+'" cellspacing="0" class="textos">';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td>Name: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td><input name="nombre[]" type="text" class="campos" id="nombre[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td width="70">Surname: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td width="309"><input name="apellido[]" type="text" class="campos" id="apellido[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td>Institution: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td><input name="institucion[]" type="text" class="campos" id="institucion[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td>E-mail: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td><input name="mail[]" type="text" class="campos" id="mail[]" style="width:300;"></td>';
		tablaPersonas += '</tr>';
		tablaPersonas += '<tr>';
		tablaPersonas += '<td width="70">Country: <font color="#FF0000">*</font></td>';
		tablaPersonas += '<td width="309"><select name="pais[]"  class="campos" id="pais[]"  style="width:300;">';
		tablaPersonas += '</select></td>';
		tablaPersonas += '</tr><tr>';
		tablaPersonas += '<td valign="bottom" class="horizontales"><font size="1" color="#666666">Co-author '+cuantosAutores+'</font></td>';
		tablaPersonas += '<td class="horizontales"><input name="lee[]" type="hidden" id="lee[]"><input name="lee_[]" type="checkbox" id="lee_[]" value="1">';
		tablaPersonas += 'This author reads? <br>';
		tablaPersonas += '<input name="inscripto[]" type="hidden" id="inscripto[]"><input name="inscripto_[]" type="checkbox" id="inscripto_[]" value="1">';
		tablaPersonas += 'This author is registered in the congress?</td>';
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


/*-----No se le puse area al form de vssagi*/
/*function activarOtraArea(valor){

	if(valor=="otro"){
		document.form1.otraArea.disabled = false	
		document.form1.otraArea.style.backgroundColor = "#F7F9F9"
	}else{
		document.form1.otraArea.disabled = true	
		document.form1.otraArea.style.backgroundColor = "#999999"
		document.form1.otraArea.value=""
		}
	
}
activarOtraArea()*/
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
		alert("Please, it enters I title of the work");
		document.form1.tituloTl.focus();
		return;
	}
	
/*	var areaTLSeleccionada = false;
	
	for(i=0; i<=cuantasAreas; i++){
		if(document.form1.areaTL[i].checked == true){
			areaTLSeleccionada = true;
		}
	}
	
	if(areaTLSeleccionada==false){
		alert("Por favor, seleccione una categoria de trabajo");
		return;
	}
	
	if(document.form1.areaTL[cuantasAreas].checked == true && document.form1.otraArea.value==""){
		alert("Please, it must enter to that another one categorie belongs the work");
		document.form1.otraArea.focus();
		return;
	}*/
	
	
	
	if(form1.contactoMail.value==""){
		alert("Please, a mail of contact enters");
		document.form1.contactoMail.focus();
		return;
	}
	
	if (form1.contactoMail.value.indexOf('@', 0) == -1 || form1.contactoMail.value.indexOf('.', 0) == -1) {
	 	alert("Please, a correct email writes.");
		form1.contactoMail.focus();
		return; 
	}
	
	if(cuantosAutores>1){
	
		for(i=0;i<cuantosAutores;i++) {
			
			
			
			
			if(document.form1.elements['nombre[]'][i].value==""){
				if(i==0){
					alert("Please, a name for the author writes presenter");
				}else{
					alert("Please, a name for the Co-author " + i + " writes");
				}
				document.form1.elements['nombre[]'][i].focus();
				return; 
			}
			
			if(document.form1.elements['apellido[]'][i].value==""){
				if(i==0){
					alert("Please, a last name for the author writes presenter");
				}else{
					alert("Please, a last name for the Co-author " + i + " writes");
				}
				
				document.form1.elements['apellido[]'][i].focus();
				return; 
			}
			
			if(document.form1.elements['institucion[]'][i].value==""){
				if(i==0){
					alert("Please, an institution for the author writes presenter");
				}else{
					alert("Please, an institution for Co-author " + i + " writes");
				}
				document.form1.elements['institucion[]'][i].focus();
				return; 
			}
			
			if(document.form1.elements['mail[]'][i].value==""){
				if(i==0){
					alert("Please, an email for the author writes presenter");
				}else{
					alert("Please, an email for the Co-author " + i + " writes");
				}
				document.form1.elements['mail[]'][i].focus();
				return; 
			}
			
			
			if (document.form1.elements['mail[]'][i].value.indexOf('@', 0) == -1 || document.form1.elements['mail[]'][i].value.indexOf('.', 0) == -1) {
					
				if(i==0){
					alert("Please, a correct email for the author writes presenter");
				}else{
					alert("Please, a correct email for the Co-author " + i + " writes");
				}
					
				document.form1.elements['mail[]'][i].focus();
				return; 
			}
				
			if(document.form1.elements['pais[]'][i].value=="Select country"){
				if(i==0){
					alert("Please, it selects to a Country for the author presenter");
				}else{
					alert("Please, it selects a Country for the Co-author " + i + " writes");

				}
				document.form1.elements['pais[]'][i].focus();
				return; 
			}	
			
			
			
			
			
	
		}
	}else{
			if(document.form1.elements['nombre[]'].value==""){
				alert("Please, a name for the author writes presenter");
				document.form1.elements['nombre[]'].focus();
				return; 
			}
			
			if(document.form1.elements['apellido[]'].value==""){
				alert("Please, a last name for the author writes presenter");
				document.form1.elements['apellido[]'].focus();
				return; 
			}
			
			if(document.form1.elements['institucion[]'].value==""){
				alert("Please, an institution for the author writes presenter");
				document.form1.elements['institucion[]'].focus();
				return; 
			}
			
			if(document.form1.elements['mail[]'].value==""){		
				alert("Please, an email for the author writes presenter");
				document.form1.elements['mail[]'].focus();
				return; 
			}
			
			if (document.form1.elements['mail[]'].value.indexOf('@', 0) == -1 || document.form1.elements['mail[]'].value.indexOf('.', 0) == -1) {
				alert("Please, a correct email for the author writes presenter");
				document.form1.elements['mail[]'].focus();
				return; 
			}
				
			if(document.form1.elements['pais[]'].value=="Select country"){
				alert("Please, it selects to a Country for the author presenter");	
				document.form1.elements['pais[]'].focus();
				return; 
			}	
	
		
	}
	
	if(archivoAdjuntado == 0){
		alert("Please, it must enclose some file of the paper.")
		document.form1.archivo.focus();
		return; 
	}	
	if(archivoAdjuntadoR == 0){
		alert("Please, it must enclose some file of the abstract.")
		document.form1.archivoR.focus();
		return; 
	}	
	
		cargarLeeInscripto();
		
		form1.action="inscripcionTL_enviar.php";
		form1.target="_self";
		form1.submit();
	

	
}

function adjuntarArchivo(){
	
	var extension = document.form1.archivo.value.substring((document.form1.archivo.value.length-3),document.form1.archivo.value.length);
	
	document.form1.extensionArchivo.value= extension
	
	if(document.form1.archivo.value==""){
		alert("Please, it selects to a paper file *.doc or *.rtf to be enclosed");
		document.form1.archivo.focus();
		return; 
	}


	if(extension=="doc" || extension=="rtf" ){
	}else{
		alert("The selected paper file must be * doc or * rtf");
		document.form1.archivo.focus();
		return; 
	}
	
	
	document.getElementById("imgAdjuntando").style.display="inline";
	document.getElementById('adjuntando').style.display='none';
	document.getElementById("adjuntando").innerHTML = "<iframe id='marcoCargando' name='marcoCargando' scrolling='auto' height='100' frameborder='0' width='100%'></iframe>"
	form1.action="adjuntando.php"
	form1.target="marcoCargando" 
	form1.submit();
	
}

function adjuntarArchivoR(){
	
	var extensionR = document.form1.archivoR.value.substring((document.form1.archivoR.value.length-3),document.form1.archivoR.value.length);
	
	document.form1.extensionArchivoR.value= extensionR
	
	if(document.form1.archivoR.value==""){
		alert("Please, it selects to a abstract file *.doc or *.rtf to be enclosed");
		document.form1.archivoR.focus();
		return; 
	}


	if(extensionR=="doc" || extensionR=="rtf" ){
	}else{
		alert("The selected abstract file must be * doc or * rtf");
		document.form1.archivoR.focus();
		return; 
	}
	
	
	document.getElementById("imgAdjuntandoR").style.display="inline";
	document.getElementById('adjuntandoR').style.display='none';
	document.getElementById("adjuntandoR").innerHTML = "<iframe id='marcoCargandoR' name='marcoCargandoR' scrolling='auto' height='100' frameborder='0' width='100%'></iframe>"
	form1.action="adjuntandoR.php"
	form1.target="marcoCargandoR" 
	form1.submit();
	
}

function activarEnviar(){
	
		if(document.form1.acepto.checked==true){
			document.form1.enviar.disabled = false;	

		}else{
		
			document.form1.enviar.disabled = true;	
		}
	
}
activarEnviar();
