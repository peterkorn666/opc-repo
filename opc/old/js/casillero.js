function CargarDatosDiaSalaHora(donde){
	
	//if(document.getElementById(donde).style.display=="none"){
		for(i=document.form1.elements["sala_[]"].options.length-1; i>=0; i--){		
			if(document.form1.elements["sala_[]"][i].selected == true){
				salas = document.form1.elements["sala_[]"][i].value;
			}
		}	
			
			dia = document.form1.dia_.value;
			hora_ini = document.form1.hora_inicio_.value.substr(0, 5);
			hora_fin = document.form1.hora_fin_.value.substr(0, 5);
			
			document.getElementById(donde).innerHTML = dia +" - " +salas+" - " +hora_ini+" a " +hora_fin;
			abrir_cerrar_div('ContenedorDatosCasilla');
	/*}else{
		document.getElementById(donde).innerHTML = "";	
	}*/
}

function CargarDatosActividad(donde){
	
	//if(document.getElementById(donde).style.display=="none"){
		tipo = document.form1.tipo_de_actividad_.value;
		titulo = document.form1.titulo_de_actividad_.value;
		if((titulo == "")||(titulo == "Ingrese aquí el Titulo de la actividad")){
			alert("Debe ingresar un título para la actividad. Gracias.");
		}else{
			document.getElementById(donde).innerHTML = tipo +" - " +titulo;		
			abrir_cerrar_div('ContenedorDatosActividadLista');
		}
	/*}else{
		document.getElementById(donde).innerHTML = "";	
	}*/
}

function validarHora(){
	H_inicio = $("#hora_inicio_").val().replace(":","")
	H_inicio = H_inicio.replace(":","")
	
	H_fin = $("#hora_fin_").val().replace(":","")
	H_fin = H_fin.replace(":","")
	
	if(H_fin < H_inicio){ 
		alert("La hora inicio no puede ser mayor a la hora de fin");
		return false;
	}else if (H_fin == H_inicio){
		alert("La hora inicio no puede igual a la hora de fin");
		return false;
	}
	return true;
}

function validar_casillero(){
	
	if($("#dia_").val()==""){
		alert("Debe seleccionar el dia.");
		return false;
	}
	
	if($("#sala_").length==0){
		alert("Debe seleccionar la sala.");
		return false;
	}
	
	if($("#hora_inicio_").val()==""){
		alert("Debe seleccionar la hora de inicio.");
		return false;
	}
	
	if($("#hora_fin_").val()==""){
		alert("Debe seleccionar la hora de fin.");
		return false;
	}
	
	if(!validarHora())
		return false;
		
	if($("#resultTlajax").text()!=""){
		alert("Debe cerrar el buscador de trabajos libres.");
		return false;
	}
	
	if($(".sortable_tl").length>0){
		$("#trabajo_libre_").attr("checked",true);
	}
}