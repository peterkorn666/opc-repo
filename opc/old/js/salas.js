var arraySalas= new Array();

//------------------------------------------------------

function llenarSalas(){
				
	//borrro combo
	for(i=document.form1.elements["sala_[]"].options.length-1; i>=0; i--){
		document.form1.elements["sala_[]"].remove(i);
	}	
					
	//ordeno array
	arraySalas.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arraySalas.length; i++){
		agregarItem(document.form1.elements["sala_[]"], arraySalas[i][0] + " - " +   arraySalas[i][1]  , arraySalas[i][1]);
	}
					
}
	
//------------------------------------------------------
	
function llenarArraySalas(elemento0, elemento1){
	
	if(elemento0<10){
		elemento0 = "0"+ elemento0;
	}
	
	arraySalas.push(new Array(elemento0, elemento1))
}

function seleccionarSalas(cual){
	for(i=document.form1.elements["sala_[]"].options.length-1; i>=0; i--){
		if(cual==document.form1.elements["sala_[]"][i].value){
			document.form1.elements["sala_[]"][i].selected = true;
		}
	}	
}

/////ALTA SALA
  arraySalaNuevo = new Array();
  arraySalaOrdenNuevo = new Array();
  
function Validar(){
	for(i=0;i<arraySalaNuevo.length; i++){
			
				if(form1.sala_.value == arraySalaNuevo[i]){
					alert("Ya existe una Sala con igual valor.");
					form1.sala_.focus();
					return;
				}
				
		  }
		for(i=0;i<arraySalaOrdenNuevo.length; i++){
			
				if(form1.orden_.value == arraySalaOrdenNuevo[i]){
					alert("Ya existe el valor para el orden.");
					form1.orden_.focus();
					return;
				}
				
		  }
		
	
	  if(form1.sala_.value==""){alert("Por Favor, Ingrese un nombre de sala.");form1.sala_.focus();return;}
	  if(form1.orden_.value==""){alert("Por Favor, Ingrese un orden para la sala");form1.orden_.focus();return;}
	
	form1.submit();
	}
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar esta sala?");
		 if ( return_value == true ) {
			 document.location.href = "gestionSala.php?id=" + cual;
		 }
		 
	 }
	 
function llenarSalas_combo(){			
	
	//borrro combo
	for(i=document.form_filtro.filtro_sala.options.length-1; i>=0; i--){
		document.form_filtro.filtro_sala.remove(i);
	}	
					
	//ordeno array
	//arraySalas.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arraySalas.length; i++){
		if (i==0){
			agregarItem(document.form_filtro.filtro_sala, "(Todas)", "(Todas)")
		}
		agregarItem(document.form_filtro.filtro_sala, arraySalas[i][1], arraySalas[i][1]);
	}
					
}
			
function llenarArraySalas_combo(elemento){
	arraySalas.push(new Array(elemento.toUpperCase(), elemento))
}

function updateSalas(sala,orden){
	var selects = document.getElementById('sala_[]');
	
	var opt = document.createElement('option');
	opt.value = sala;
	opt.innerHTML = orden +"-"+ sala;
	selects.appendChild(opt);
}