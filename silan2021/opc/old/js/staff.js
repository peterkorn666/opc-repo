var arrayStaff= new Array();

function llenarStaff(){			
	//borrro combo
	for(i=document.form1.staff.options.length-1; i>=0; i--){
		document.form1.staff.remove(i);
	}
	//ordeno array
	arrayStaff.sort();
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayStaff.length; i++){
		if (i==0){
			agregarItem(document.form1.staff, "(Seleccione)", "(Seleccione)")
		}
		agregarItem(document.form1.staff, arrayStaff[i][1], arrayStaff[i][1]);
	}
					
}

function llenarStaff_combo(){			
	//borrro combo
	for(i=document.form_filtro.filtro_staff.options.length-1; i>=0; i--){
		document.form_filtro.filtro_staff.remove(i);
	}
	//ordeno array
	arrayStaff.sort();
	//lleno el combo (cual, texto, valor)
	for(i=0;i<arrayStaff.length; i++){
		if (i==0){
			agregarItem(document.form_filtro.filtro_staff, "(Todas)", "(Todas)")
		}
		agregarItem(document.form_filtro.filtro_staff, arrayStaff[i][1], arrayStaff[i][1]);
	}
					
}
			
function llenarArrayStaff(elemento){
	arrayStaff.push(new Array(elemento.toUpperCase(), elemento))
}

function seleccionarStaff(cual){
	for(i=document.form1.elements["nombre_[]"].options.length-1; i>=0; i--){
		if(cual==document.form1.elements["nombre_[]"][i].value){
			document.form1.elements["nombre_[]"][i].selected = true;
		}
	}	
}

/////ALTA Staff
  arrayStaffNuevo = new Array();
  arrayStafOrdenNuevo = new Array();
  
function Validar(){
	for(i=0;i<arrayStaffNuevo.length; i++){
			
				if(form1.nombre_.value == arrayStaffNuevo[i]){
					alert("Ya existe un Staff con igual valor.");
					form1.nombre_.focus();
					return;
				}
				
		  }		
	
	  if(form1.nombre_.value==""){alert("Por Favor, Ingrese un nombre de Staff.");form1.nombre_.focus();return;}
	
	form1.submit();
	}
	function eliminar(cual){
 		
		var return_value = confirm("¿Esta seguro que desea eliminar este Staff?");
		 if ( return_value == true ) {
			 document.location.href = "gestionStaff.php?id=" + cual;
		 }
		 
	 }
	 
	 function eliminar_persona(cual,staff){
		var return_value = confirm("¿Esta seguro que desea eliminar esta Persona?");
		 if ( return_value == true ) {
			 document.location.href = "gestionStaff.php?modificar=false&id=" + cual + "&staff=" + staff +"&esPersona=SI" ;
		 }
		 
	 }
	 
function agregarPersona_staff(idStaff){
	mantenerPosicionDiv("divEdicion",400,300);
	mostrarDiv('divEdicion');
	petision("editarPersonaStaff.php", "divEdicion", "POST", "idStaff="+idStaff);
}

function editarPersona_staff(idStaff,idPersona,nombre,apellido,telefono,email,pais,cargo){
	mantenerPosicionDiv("divEdicion",400,300);
	mostrarDiv('divEdicion');
	petision("editarPersonaStaff.php", "divEdicion", "POST", "idStaff="+idStaff+"&idPersona="+idPersona+"&nombre="+nombre+"&apellido="+apellido+"&telefono="+telefono+"&email="+email+"&pais="+pais+"&cargo="+cargo);
}


function mostrarDiv(cualDiv){
	document.getElementById(cualDiv).style.display = 'block';	
}
function ocultarDiv(cualDiv){
	document.getElementById(cualDiv).style.display = 'none';	
}


function mantenerPosicionDiv(cualDiv,margenX,margenY) {

	deltaX =  window.pageXOffset
                || document.documentElement.scrollLeft
                || document.body.scrollLeft
                || 0;
    deltaY =  window.pageYOffset
                || document.documentElement.scrollTop
                || document.body.scrollTop
                || 0;


	
	ubicarDiv(cualDiv,deltaX + margenX, deltaY  + margenY)
}

function ubicarDiv(cualDiv,X,Y) {
	document.getElementById(cualDiv).style.position="absolute";
	document.getElementById(cualDiv).style.left=X + "px";
	document.getElementById(cualDiv).style.top=Y + "px";
}

function enviar_Registration(cual){
	document.location.href="altaStaff.php?id="+cual;	
}