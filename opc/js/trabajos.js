cantTrab = -1;
function agregarTrabajo(){
		$clone = $("#confsClone").html();
		$("#nuevas_ponencias").append($clone);
		
		renderTrabajos();
		//cantTrab = cantTrab + 1;
		
}
function renderTrabajos(){
	/*$(".en_calidad_template").each(function(index, element) {
		for(i=0;i<ArrayEnCalidadesNuevo.length;i++){
			if(ArrayEnCalidadesNuevo[i]!=""){
        		$(this).append("<option value='"+ArrayEnCalidadesNuevo[i]+"'>"+ArrayEnCalidadesNuevo[i]+"</option>")
			}
		}
    });*/
	
	$(".divTrabajos_tempalte").each(function(index, element) {
        $("#nuevas_ponencias").append($(this).html(function(i, oldHTML) {
			cantTrab = cantTrab+1;
			$(this).attr("id","div_conf_"+cantTrab)
			return oldHTML.replace(/\@@@@/g, cantTrab);
		}))
    });
	
	$(".en_calidad").removeClass("en_calidad_template");
	$(".divTrabajos").removeClass("divTrabajos_tempalte");
}



function tempSeleccionTituloTrabajos(){
	
		arraySeleccionTituloTrabajos = new Array();
		
		for(u=0; u<=cantTrab-1; u++){
		
			arraySeleccionTituloTrabajos.push(document.form1.elements['trabajo[]'][u].value);
		
		}
	
}

function llenarTituloTrabajos(){
	
		for(u=0; u<=cantTrab-1; u++){
		
			if(arraySeleccionTituloTrabajos[u]!= undefined){
			document.form1.elements['trabajo[]'][u].value = arraySeleccionTituloTrabajos[u];
			}
		}
	
}

$(document).ready(function(e) {
    $(document).on("click",".deleteConf",function(){
		if(!confirm("Desea eliminar este conferencista?"))
			return		
		
		var cual = $(this).attr("data-pos");
		
		if(cual!=null){
			$("#div_conf_"+cual).slideUp("slow",function(){
				$("#div_conf_"+cual).remove();
			})
		}
	})
	$(document).on("click","input[name='crono[]']",function(){
		var cual = $(this).attr("data-pos");
		if($(this).is(":checked")){
			$("#en_crono_"+cual).val(1);
		}else{
			$("#en_crono_"+cual).val(0);
		}
	})
	
});


function borrarTexto(cual, valor, indice){
	
	if(valor=="Ingrese aquí el Titulo de la actividad"){		
		document.getElementById(cual).value="";
	}
	if(valor=="Ingrese aquí el Título del trabajo"){
		document.form1.elements[cual][indice].value="";		
	}
	
	
}