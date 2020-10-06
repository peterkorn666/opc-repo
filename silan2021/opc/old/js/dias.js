var arrayDias= new Array();

function llenarDias(){
				
	//borrro combo
	for(i=document.form1.dia_.options.length-1; i>=0; i--){
		document.form1.dia_.remove(i);
	}	
					
	//ordeno array
	arrayDias.sort();
					
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayDias.length; i++){
		agregarItem(document.form1.dia_, arrayDias[i][0] + " - " +   arrayDias[i][1]  , arrayDias[i][1]);
	}
					
}
			
function llenarArrayDias(elemento0, elemento1){
	if(elemento0<10){
		elemento0 = "0"+ elemento0;
		}
	arrayDias.push(new Array(elemento0, elemento1))
}
function seleccionarDias(cual){
	for(i=document.form1.dia_.options.length-1; i>=0; i--){
		if(cual==document.form1.dia_[i].value){
			document.form1.dia_[i].selected = true;
		}
	}	
}
/////ALTA DIAS
  arrayDiasNuevo = new Array();
  arrayDiasOrdenNuevo = new Array();
  
function Validar(){
	for(i=0;i<arrayDiasNuevo.length ; i++){
			
				if(form1.dia_.value == arrayDiasNuevo[i]){
					alert("Ya existe un Día con igua valor.");
					form1.dia_.focus();
					return;
				}
				
		  }
		for(i=0;i<arrayDiasOrdenNuevo.length ; i++){
			
				if(form1.orden_.value == arrayDiasOrdenNuevo[i]){
					alert("Ya existe el valor para el orden.");
					form1.orden_.focus();
					return;
				}
				
		  }
	  if(form1.dia_.value==""){alert("Por Favor, Ingrese un nombre de día.");form1.dia_.focus();return;}
	  if(form1.orden_.value==""){alert("Por Favor, Ingrese un orden para el día");form1.orden_.focus();return;}
	  form1.submit();
	}
	
function eliminar(cual){
	
	var return_value = confirm("¿Esta seguro que desea eliminar este día?");
	if (return_value == true ) {
		document.location.href = "gestionDia.php?id=" + cual;
	}

}
 
function updateDias(dia,orden){
	var selects = document.getElementById('dia_');
	
	var opt = document.createElement('option');
	opt.value = dia;
	opt.innerHTML = orden +"-"+ dia;
	selects.appendChild(opt);
}