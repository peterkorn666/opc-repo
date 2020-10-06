var arrayTipo_de_actividades = new Array(new Array(" ","", ""));

function llenarTipo_de_actividades(){			
	
	//borrro combo
	for(i=document.form1.tipo_de_actividad_.options.length-1; i>=0; i--){
		document.form1.tipo_de_actividad_.remove(i);
	}	
					
	//ordeno array
	arrayTipo_de_actividades.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayTipo_de_actividades.length; i++){
		agregarItem(document.form1.tipo_de_actividad_, arrayTipo_de_actividades[i][1], arrayTipo_de_actividades[i][1],arrayTipo_de_actividades[i][2]);
	}
					
}
			
function llenarArrayTipo_de_actividades(elemento, estilo){
	arrayTipo_de_actividades.push(new Array(elemento.toUpperCase(), elemento, estilo))
}

function seleccionarTipo_de_actividades(cual){
	for(i=document.form1.tipo_de_actividad_.options.length-1; i>=0; i--){
		if(cual==document.form1.tipo_de_actividad_[i].value){
			document.form1.tipo_de_actividad_[i].selected = true;
		}
	}	
}
function alterarColor_tipo_de_actividad(cual){
	
			if(arrayTipo_de_actividades[cual][2].substring(0,1) == "#"){
				TD_tipo_de_actividad.style.background  = arrayTipo_de_actividades[cual][2];
			}else{
				TD_tipo_de_actividad.style.background = "url('img/patrones/"+arrayTipo_de_actividades[cual][2]+"')";
			}
			
			
}

arrayActividadNuevo = new Array();
 function Validar(){
	 

	 for(i=0;i<arrayActividadNuevo.length; i++){
			
				if(form1.actividad_.value == arrayActividadNuevo[i]){
					alert("Ya existe una Actividad con igual nombre.");
					form1.actividad_.focus();
					return;
				}
				
		  }
		  
	  if(form1.actividad_.value==""){alert("Por Favor, Ingrese una actividad.");form1.actividad_.focus();return;}
	  form1.submit();
	}
	
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta actividad?");
		
		 if ( return_value == true ) {
			 document.location.href = "eliminarActividad.php?id=" + cual;
		 }
		 
	 }
	 function tirar_color(cual){
		
		form1.colorRGB.value = cual
		document.form1.actividad_.style.background = cual
	
		
	}
	
	function tirar_diseno(cual){

		form1.colorRGB.value = cual
		document.form1.actividad_.style.background = "url(img/patrones/" + cual + ")";
	
		
	}
	
function updateTipoActividad(tipo_actividad,bg_color){
	var selects = document.getElementById('tipo_de_actividad_');
	
	var opt = document.createElement('option');
	opt.value = tipo_actividad;
	if(bg_color.indexOf("#") > -1){
		opt.style.backgroundColor = bg_color;
	}else{
		opt.style.background = "url(img/patrones/" + bg_color + ")";;
	}
	opt.innerHTML = tipo_actividad;
	selects.appendChild(opt);
	
	selects.value = tipo_actividad;
}	
	