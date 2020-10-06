var CuantosP = 0;
var CuantosT = 0;
var CuantosA = 0;
function marcarAutor(que){
	
	for(i=0; i<CuantosA; i++){
		document.form1.elements["autor[]"][i].checked=que;
	}
	
}

function marcar(que){
	
	/*for(i=0; i<CuantosP; i++){
		document.form1.elements["participante[]"][i].checked=que;
	}*/
	$("input[name='participante[]']").prop("checked",false);
	if(que==true)
	{
		$("input[name='participante[]']").prop("checked",true);
	}
	
}

function invertir(){
	/*for(i=0; i<CuantosP; i++){
		if(document.form1.elements["participante[]"][i].checked==true){
			document.form1.elements["participante[]"][i].checked=false;
		}else{
			document.form1.elements["participante[]"][i].checked=true;	
		}
	}*/
	if($(".Ingles").is("checked")){
		$(".Espanol").attr("checked",true);
		$(".Ingles").attr("checked",false);
	}else{
		$(".Ingles").attr("checked",true);
		$(".Espanol").attr("checked",false);
	}
}

function allSpanish(){
	/*for(i=0; i<CuantosP; i++){
		if(document.form1.elements["participante_idioma_"+i].value=="Spanish"){
			document.form1.elements["participante[]"][i].checked=true;
		}else{
			document.form1.elements["participante[]"][i].checked=false;	
		}
	}*/
	$(".Espanol").attr("checked",true);
	$(".Ingles").attr("checked",false);	
}

function allEnglish(){
	/*for(i=0; i<CuantosP; i++){
		if(document.form1.elements["participante_idioma_"+i].value=="English"){
			document.form1.elements["participante[]"][i].checked=true;
		}else{
			document.form1.elements["participante[]"][i].checked=false;	
		}
	}*/
	$(".Espanol").attr("checked",false);
	$(".Ingles").attr("checked",true)	
}

function segunRol(){
	marcar(false);
	rol = document.form1.EnCalidad.value;
	for(i=0; i<CuantosP; i++){
		separo = document.form1.elements["participante_rol_"+i].value.split(", ");
		for(a=0; a<separo.length; a++){
			if(separo[a]==rol){
				document.form1.elements["participante[]"][i].checked=true;
			}else{
				if(document.form1.elements["participante[]"][i].checked==false){
					document.form1.elements["participante[]"][i].checked=false;	
				}
			}
		}
	}	
}



function marcarTrabajos(que){
	
	for(i=0; i<CuantosT; i++){		
		document.form1.elements["trabajo[]"][i].checked=que;	
	}
	
}
function enviarMails(){
	
	document.form1.archivoTMP.value = document.form1.archivo.value
	
	if(document.form1.asunto1.value==""){
			alert("No ha puesto ningun asunto luego del nombre del participante");
			return;
	}

	if(document.form1.A_otro.checked == false && document.form1.A_participante.checked == false){
		alert("Debe seleccionar si los mails se enviaran a un solo destinatario");
		return;
	}else{
		
		if(document.form1.A_otro.checked == true && document.form1.mailAotro.value==""){
			alert("Si selecciona que los mails se van a enviar a un destinatario solo, debe especificar a cual.");
			return;
		}
		
	}
	
	/*var selecionado = false;
	for(i=0; i<CuantosP; i++){
		if(document.form1.elements["participante[]"][i].checked==true){
			selecionado = true;	
		}
	}
	
	if(selecionado == false){
		alert("Debe seleccionar algún participante");
		return;
	}*/
	
	
	document.form1.submit();
	
}

function enviarMailsTrabajos(){	
	document.form1.archivoTMP.value = document.form1.archivo.value	
	if(document.form1.asunto1.value==""){
			alert("No ha puesto ningun asunto");
			return;
	}
	if(document.form1.A_otro.checked == false && document.form1.A_participante.checked == false){
		alert("Debe seleccionar si los mails se enviaran a un solo destinatario");
		return;
	}else{		
		if(document.form1.A_otro.checked == true && document.form1.mailAotro.value==""){
			alert("Si selecciona que los mails se van a enviar a un destinatario solo, debe especificar a cual.");
			return;
		}		
	}	
	var selecionado = false;
	if(CuantosT!=1){
		for(i=0; i<CuantosT; i++){
				if(document.form1.elements["trabajo[]"][i].checked==true){
					selecionado = true;	
				}
		}
	}else{
		if(document.form1.elements["trabajo[]"].checked==true){
					selecionado = true;	
		}
	}
	if(selecionado == false){
		alert("Debe seleccionar algún trabajos");
		return;
	}
	document.form1.submit();
}

function enviarMailsCasilleros(){	
	if(document.form1.asunto1.value==""){
			alert("No ha puesto ningun asunto");
			return;
	}
	if(document.form1.A_otro.checked == false && document.form1.A_participante.checked == false){
		alert("Debe seleccionar si los mails se enviaran a un solo destinatario");
		return;
	}else{		
		if(document.form1.A_otro.checked == true && document.form1.mailAotro.value==""){
			alert("Si selecciona que los mails se van a enviar a un destinatario solo, debe especificar a cual.");
			return;
		}		
	}	
	var selecionado = false;
	for(i=0; i<CuantosP; i++){
		if(document.form1.elements["participante[]"][i].checked==true){
			selecionado = true;	
		}
	}	
	if(selecionado == false){
		alert("Debe seleccionar algún participantes");
		return;
	}
	document.form1.submit();
}

function enviarMailsAutores(){
	
	document.form1.archivoTMP.value = document.form1.archivo.value
	
	if(document.form1.asunto1.value==""){
			alert("No ha puesto ningun asunto");
			return;
	}

	if(document.form1.A_otro.checked == false && document.form1.A_participante.checked == false){
		alert("Debe seleccionar si los mails se enviaran a un solo destinatario");
		return;
	}else{
		
		if(document.form1.A_otro.checked == true && document.form1.mailAotro.value==""){
			alert("Si selecciona que los mails se van a enviar a un destinatario solo, debe especificar a cual.");
			return;
		}
		
	}
	
	var selecionado = false;
	for(i=0; i<CuantosA; i++){
		if(document.form1.elements["autor[]"][i].checked==true){
			selecionado = true;	
		}
	}
	
	if(selecionado == false){
		alert("Debe seleccionar algún autor/coautor");
		return;
	}
	
	
	document.form1.submit();
	
}

function FondoTD(TdId, color){
	eval(TdId).bgColor=color;
	}