var CuantosP = 0;
var CuantosT = 0;
var CuantosA = 0;
var CuantosI = 0;
function marcarAutor(que){
	if(que){
		var filtro_autor_inscripto = document.form1.filtro_no_inscriptos.checked;
		var filtro_trabajo_aceptado = document.form1.filtro_trabajos_aprobados.checked;
		var filtro_no_repetidos = document.form1.filtro_no_repetidos.checked;
		var se_puede_marcar = false;
		
		var arrayNombres = [];
		var arrayApellidos = [];
		var arrayMails = [];
		for(i=0; i<CuantosA; i++){
			se_puede_marcar = false;
			if(filtro_autor_inscripto != '1' && filtro_trabajo_aceptado != '1' && filtro_no_repetidos != '1')
				se_puede_marcar = true;
			else{
				if(filtro_autor_inscripto == '1'){
					if(document.form1.elements["autor[]"][i].dataset.inscripto == '0'){
						se_puede_marcar = true;
					}else
						se_puede_marcar = false;
				}
				if(se_puede_marcar || filtro_autor_inscripto != '1'){
					if(filtro_trabajo_aceptado == '1'){
						if(document.form1.elements["autor[]"][i].dataset.estado_trabajo != '3'){
							se_puede_marcar = true;
						}else
							se_puede_marcar = false;
					}
				}
				if(se_puede_marcar || (filtro_autor_inscripto != '1' && filtro_trabajo_aceptado != '1')) {
					if(filtro_no_repetidos == '1'){
						var tiene_nombre_apellido_email_repetidos = arrayNombres.includes(document.form1.elements["autor[]"][i].dataset.nombre) && arrayApellidos.includes(document.form1.elements["autor[]"][i].dataset.apellido) && arrayMails.includes(document.form1.elements["autor[]"][i].dataset.email);
						if(tiene_nombre_apellido_email_repetidos){
							
							se_puede_marcar = false;
						}else{
							
							arrayNombres.push(document.form1.elements["autor[]"][i].dataset.nombre);
							arrayApellidos.push(document.form1.elements["autor[]"][i].dataset.apellido);
							arrayMails.push(document.form1.elements["autor[]"][i].dataset.email);
							se_puede_marcar = true;
						}
					}
				}
			}
			if(se_puede_marcar)
				document.form1.elements["autor[]"][i].checked=que;
		}
	}else{
		for(i=0; i<CuantosA; i++)
			document.form1.elements["autor[]"][i].checked=que;
	}
}

function marcar(que){
	
	/*for(i=0; i<CuantosP; i++){
		document.form1.elements["participante[]"][i].checked=que;
	}*/
	
	/*$("input[name='participante[]']").prop("checked",false);
	if(que==true)
	{
		
		$("input[name='participante[]']").prop("checked",true);
	}*/
	
	$("input[name='participante[]']").prop("checked", false); //paso todo a false
	
	if(que === true){
		var filtro_coordinador = $("input[name='filtro_coordinador']:checked");
		var se_puede_marcar;
		var coordinador;
		$("input[name='participante[]']").each(function(){
			se_puede_marcar = true;
			
			if(filtro_coordinador.val() == 1){
				coordinador = $(this).data('coordinador');
				if(coordinador != 1){
					se_puede_marcar = false;
				}
			}
			$(this).prop('checked', se_puede_marcar);
		});
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

function marcarTodos(que, nombre_campo){
	$("input[name='inscriptos[]']").each(function(index, element) {
		if($(this).is(":visible")){
			$(this).attr('checked', que);
		}
	});
	/*for(i=0; i<CuantosI; i++){		
		document.form1.elements["inscriptos[]"][i].checked=que;	
	}*/
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

function seleccionarTipo(){
	var tipo_selected = document.form1.filtro_tipo_inscripcion.value;
	var url_split = window.location.href.split("?");
	var parametros = url_split[1]; //tomo los parametros
	var cada_parametro;
	if(parametros)
		cada_parametro = parametros.split("&"); //divido por cada parametro
	else
		cada_parametro = Array();
	var query = Array(); //creo un array auxiliar
	var vars = "";
	
	for(i=0; i<cada_parametro.length; i++){
		if(!cada_parametro[i].includes("filtro_tipo_inscripcion")) //si no es el parametro, lo agrego al array auxiliar
			query.push(cada_parametro[i]); //ingresa el elemento al array
	}
	
	if(tipo_selected != ""){
		query.push("filtro_tipo_inscripcion="+tipo_selected); //agrego al array el parametro deseado
	}
	
	for(i=0; i<query.length; i++){
		vars += query[i]+"&";
	}
	
	vars = vars.substr(0, vars.length-1); //saco el & del final
	if(vars.length > 0) //tengo parametros
		vars = url_split[0]+"?"+vars;
	else
		vars = url_split[0]; //url simple
	window.location.href = vars;
	
	/*$("input[name='inscriptos[]']").each(function(index, element) {
		var tipo_inscripto = $(this).next("input[name='tipo_inscripcion']").val();
		if(tipo_inscripto != tipo_selected && tipo_selected != ""){
			$(".inscripto"+$(this).val()).hide();
		}else
			$(".inscripto"+$(this).val()).show();
	});*/
}

function seleccionarCostoInscripcion(){
	var costo_inscripcion_selected = document.form1.filtro_costos_inscripcion.value;
	var url_split = window.location.href.split("?");
	var parametros = url_split[1]; //tomo los parametros
	var cada_parametro;
	if(parametros)
		cada_parametro = parametros.split("&"); //divido por cada parametro
	else
		cada_parametro = Array();
	var query = Array(); //creo un array auxiliar
	var vars = "";
	
	for(i=0; i<cada_parametro.length; i++){
		if(!cada_parametro[i].includes("filtro_costos_inscripcion")) //si no es el parametro, lo agrego al array auxiliar
			query.push(cada_parametro[i]); //ingresa el elemento al array
	}
	
	if(costo_inscripcion_selected != ""){
		query.push("filtro_costos_inscripcion="+costo_inscripcion_selected); //agrego al array el parametro deseado
	}
	
	for(i=0; i<query.length; i++){
		vars += query[i]+"&";
	}
	
	vars = vars.substr(0, vars.length-1); //saco el & del final
	if(vars.length > 0) //tengo parametros
		vars = url_split[0]+"?"+vars;
	else
		vars = url_split[0]; //url simple
	window.location.href = vars;

	/*$("input[name='inscriptos[]']").each(function(index, element) {
		var costo_inscripcion_inscripto = $(this).nextAll("input[name='costo_inscripcion']").val();
		console.log("costo ");
		console.log(costo_inscripcion_inscripto);
		console.log("/costo ");
		if(costo_inscripcion_inscripto != costo_inscripcion_selected && costo_inscripcion_selected != ""){
			$(".inscripto"+$(this).val()).hide();
		}else
			$(".inscripto"+$(this).val()).show();
	});*/
}

function enviarMailsInscriptos(){	
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
	$("input[name='inscriptos[]']").each(function(index, element) {
		if($(this).is(':checked')){
			selecionado = true;
		}
	});
	/*if(CuantosI!=1){
		for(i=0; i<CuantosI; i++){
			if(document.form1.elements["inscriptos[]"][i].checked==true){
				selecionado = true;	
			}
		}
	}else{
		if(document.form1.elements["inscriptos[]"].checked==true){
			selecionado = true;	
		}
	}*/
	if(selecionado == false){
		alert("Debe seleccionar algún inscripto");
		return;
	}
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