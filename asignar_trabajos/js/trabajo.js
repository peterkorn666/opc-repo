$(document).ready(function(e) {
    $("#buscar-trabajo").click(function(){
		if(checkTrabajoNumber()===false){
			searchTrabajo(null, null, null);
		}
	})
	
	$(document).on("click",".option-autor", function(e){
		e.preventDefault();
		var id_tl = $(this).data("tl");
		if(id_tl==null)
			return false;
		$(this).closest("table").find(".option-autor").removeClass("autor-select");
		$(this).addClass("autor-select");
		$("#autor_tl_" + id_tl).val($(this).data("autor"));
		$("#autor-no-encontrado-"+id_tl+"").hide();
	})
	
	$(document).on("click", ".quitar-trabajo-lista", function(e){
		e.preventDefault();
		$(this).closest("table").remove();
	})
});

function checkTrabajoNumber(){
	var numero = 0,
		input = parseInt($("input[name='numero_tl']").val()),
		existe = false;
	if($(".numero_trabajo").length){
		$(".numero_trabajo").each(function(i, e){
			numero = parseInt($(e).html());
			if(numero==input)
				existe = true;
		})
		if(existe)
			alert("Ya existe este trabajo")
		return existe;
	}
	return false;
}

function searchTrabajo(tl, autores, callback){		
	var num = tl || $("input[name='numero_tl']").val()
	var autores = autores || null
	$.ajax({
		type: "POST",
		url: "../asignar_trabajos/buscar_trabajo.php",
		data: "numero_tl="+num,
		dataType: "json",
		beforeSend: function(){
			$("#buscar-trabajo").prop("disabled", true).html("BUSCANDO");
		},
		success: function(data) {
			if(data.status==1)
			{
				html = '';
				html += "<table width='100%'>"
				if(data.cuenta){
					html += "<tr>"
						html += "<td colspan='2' valign='top' align='right'>"
							html += '<div style="font-size:13px;">cuenta: ' + data.cuenta.id + " " + data.cuenta.email + " " + data.cuenta.nombre + " " + data.cuenta.apellido + "</div>";
						html += "</td>"
					html += "</tr>"
				}
				html += "<tr>"
				html += "<td width='50' valign='top'>"
					html += "<a href='#' class='quitar-trabajo-lista' title='Quitar de la lista'>[borrar]</a>";
				html += "</td>"
				html += "<td>"
					html += "<span class='numero_trabajo'>" + data.trabajo.numero_tl + "</span> - " + data.trabajo.titulo_tl + "<br>";
					if(data.found==1 && data.autores.length==1){
						html += '<a href="#" class="autor-select option-autor" data-tl="'+data.trabajo.id_trabajo+'" data-autor="'+data.autores[0].ID_Personas+'">' + data.autores[0].Nombre + " " + data.autores[0].Apellidos + "</a><br><br>";
						html += '<input type="hidden" id="autor_tl_'+data.trabajo.id_trabajo+'" name="input_selected_autor[]" value="' +data.autores[0].ID_Personas+ '">';
						html += '<input type="hidden" name="input_revisar_autor[]" value="0">';
						$("#id-selected-autor").val(data.autores[0].ID_Personas);
					}else{
						id_autor = "";
						for(i=0;i<data.autores.length;i++){
							chk = "";
							if(autores !== null){
								if($.inArray(parseInt(data.autores[i].ID_Personas), autores) !== -1){
									chk = "autor-select";
									id_autor = data.autores[i].ID_Personas;
								}
							}
							html += '<a href="#" class="'+chk+' option-autor" data-tl="'+data.trabajo.id_trabajo+'" data-autor="'+data.autores[i].ID_Personas+'">' + data.autores[i].Nombre + " " + data.autores[i].Apellidos + "</a>; ";
						}
							
						html += '<input type="hidden" id="autor_tl_'+data.trabajo.id_trabajo+'" name="input_selected_autor[]" value="'+id_autor+'">';
						html += '<input type="hidden" name="input_revisar_autor[]" value="1">';
						html += "<br><br><div class='alert alert-danger' align='center' style='color:white; background-color:#CC0000;' id='autor-no-encontrado-"+data.trabajo.id_trabajo+"'><b>No encontramos coincidencia entre los autores. <br> Es posible que su nombre este escrito diferente o que el email utilizado sea otro. <br> Presione sobre el que corresponda.</b></div>";
					}
				
				<!-- class='alert alert-danger' -->
				html += "</td>"
				html += "</tr>"
				html += "</table>"
				$("#result_trabajos").append(html);
				if(data.trabajo.id_trabajo && (data.found==1 || id_autor))
					$("#autor-no-encontrado-"+data.trabajo.id_trabajo).hide()
				/*setTimeout(function(){
					if($("#result_trabajos table").length==1)
						$("#txt_colocar_trabajos").html("<b style='font-size:12px'>Si usted participa en más de un trabajo, prosiga escribiendolos uno a uno</b>");
				},1000);*/
				if(callback!==null)
					callback();
			}else
				alert("No se encontró el trabajo");
		}
	});
	
	$( document ).ajaxComplete(function() {
		$("input[name='numero_tl']").val("")
		$("#buscar-trabajo").prop("disabled", false).html("Aceptar");
	});
}