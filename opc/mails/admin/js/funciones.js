function validarTintas(valor,prefijo){	
	var dom = document.getElementById;
	var estado;
	estado = false;
	if(valor=="Compuesta"){
		$(prefijo + "tintaC").checked = estado;
		$(prefijo + "tintaY").checked = estado;
		$(prefijo + "tintaM").checked = estado;
		$(prefijo + "tintaK").checked = estado;
		$(prefijo + "tinta_otra").checked = estado;
		$(prefijo + "tintasCMYK").checked = estado;
		
	}else if(valor=="CMYK"){
		if( $(prefijo + "tintasCMYK").checked == true){
			estado = true;
		}
		$(prefijo + "tintaC").checked = estado;
		$(prefijo + "tintaY").checked = estado;
		$(prefijo + "tintaM").checked = estado;
		$(prefijo + "tintaK").checked = estado;
		$(prefijo + "tinta_compuesta").checked = false;
	}else{
		$(prefijo + "tinta_compuesta").checked = false;
		
		$(prefijo + "tintasCMYK").checked =  ($(prefijo + "tintaC").checked && $(prefijo + "tintaY").checked  && $(prefijo + "tintaM").checked && $(prefijo + "tintaK").checked)
	}
	if($(prefijo + "tinta_otra").checked==true){
	 	$(prefijo + "txt_tinta_otra").style.background = '#f4f4f4';
	 	$(prefijo + "txt_tinta_otra").disabled = false;
		$(prefijo + "txt_tinta_otra").focus();
	}else{
		$(prefijo + "txt_tinta_otra").style.background = '#666666';
		$(prefijo + "txt_tinta_otra").value = '';
		$(prefijo + "txt_tinta_otra").disabled = true;
	}

	asignarValorTintas(prefijo);

	return;
}

function asignarValorTintas(prefijo) {
	valorTintas="";
	if ($(prefijo + "tintaC").checked) {
		valorTintas+="C";
	}
	if ($(prefijo + "tintaM").checked) {
		valorTintas+="M";
	}
	if ($(prefijo + "tintaY").checked) {
		valorTintas+="Y";
	}
	if ($(prefijo + "tintaK").checked) {
		valorTintas+="K";
	}
	valorTintas+=":";

	valorTintas+= $(prefijo + "txt_tinta_otra").value ;
	valorTintas+=":";
	if ($(prefijo + "tinta_compuesta").checked) {
		valorTintas+="1";
	}
	$(prefijo + "tintas").value=valorTintas;

	return;
}

function mostrarTintas(prefijo) {
	tintas=$(prefijo + "tintas").value;
	if (tintas=="") {
		tintas=":::";
	}
	arrTintas=tintas.split(":");
	if (arrTintas.length>0) {
		$(prefijo + "tintasCMYK").checked = (arrTintas[0].indexOf("CMYK")>=0);
		$(prefijo + "tintaC").checked = (arrTintas[0].indexOf("C")>=0);
		$(prefijo + "tintaM").checked = (arrTintas[0].indexOf("M")>=0);
		$(prefijo + "tintaY").checked = (arrTintas[0].indexOf("Y")>=0);
		$(prefijo + "tintaK").checked = (arrTintas[0].indexOf("K")>=0);
	}
	if (arrTintas.length>1) {
		$(prefijo + "txt_tinta_otra").value = arrTintas[1];
		$(prefijo + "tinta_otra").checked = (arrTintas[1]!="");
		if($(prefijo + "tinta_otra").checked==true){
		 	$(prefijo + "txt_tinta_otra").style.background = '#f4f4f4';
		 	$(prefijo + "txt_tinta_otra").disabled = false;
			$(prefijo + "txt_tinta_otra").focus();
		}else{
			$(prefijo + "txt_tinta_otra").style.background = '#666666';
			$(prefijo + "txt_tinta_otra").value = '';
			$(prefijo + "txt_tinta_otra").disabled = true;
		}
	}
	if (arrTintas.length>2) {
		$(prefijo + "tinta_compuesta").checked = (arrTintas[2]==1);
	}
}


function mostrar(queDiv){
	document.getElementById("subitemAdmin").style.display  = "none";
	document.getElementById("subitemProd").style.display  = "none";
	document.getElementById("subitemMant").style.display  = "none";
	if((queDiv=="subitemMantClientes")||(queDiv=="subitemMantUsuarios")){
		document.getElementById("subitemMant").style.display  = "block";	
	}
	document.getElementById(queDiv).style.display  = "block";	
	
}
function cambiarTitulo(tit){
	document.getElementById("Titulo").innerHTML = tit;
}

 function abrirVentana(url,nombre,ancho,alto) {
  window.open(url,nombre,'width=' + ancho + ', height=' + alto + ',  menubar=no, status=yes, location=no, toolbar=no, scrollbars=no, resizable=yes');
 return false;
 }