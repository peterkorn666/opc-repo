var arrayHora = new Array();

function llenarHoras(){
				
	//borrro combo
	for(i=document.form1.hora_inicio_.options.length-1; i>=0; i--){
		document.form1.hora_inicio_.remove(i);
		document.form1.hora_fin_.remove(i);
	}	
					
	//ordeno array
	arrayHora.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayHora.length; i++){
		agregarItem(document.form1.hora_inicio_, arrayHora[i].substring(0,5), arrayHora[i]);
		agregarItem(document.form1.hora_fin_, arrayHora[i].substring(0,5), arrayHora[i]);
	}
					
}
			
function llenarArrayHoras(elemento){
	arrayHora.push(elemento)
}

function seleccionarHorasInicio(cual){
	for(i=document.form1.hora_inicio_.options.length-1; i>=0; i--){
		if(cual==document.form1.hora_inicio_[i].value){
			document.form1.hora_inicio_[i].selected = true;
		}
	}	
}
function seleccionarHorasFin(cual){
	for(i=document.form1.hora_fin_.options.length-1; i>=0; i--){
		if(cual==document.form1.hora_fin_[i].value){
			document.form1.hora_fin_[i].selected = true;
		}
	}	
}

////ALTA 
function Validar(){

		
	  if(form1.hora_.value==""){alert("Por Favor, Ingrese un numero para la hora.");form1.hora_.focus();return;}
	  if(form1.min_.value==""){alert("Por Favor, Ingrese un numero para los minutos");form1.min_.focus();return;}
	
	form1.submit();
	}
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta hora?");
		 if ( return_value == true ) {
			 document.location.href = "eliminarHora.php?id=" + cual;
		 }
		 
	 }
	 
	 
function updateHoras(hora){
	var selects = document.getElementById('hora_inicio_');
	
	var opt = document.createElement('option');
	opt.value = hora;
	opt.innerHTML = hora;
	selects.appendChild(opt);
	
	selects = document.getElementById('hora_fin_');
	
	opt = document.createElement('option');
	opt.value = hora;
	opt.innerHTML = hora;
	selects.appendChild(opt);
}	 