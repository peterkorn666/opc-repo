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
				html += "<tr>"
				html += "<td width='50' valign='top'>"
					html += "<a href='#' class='quitar-trabajo-lista' title='Quitar de la lista'>[borrar]</a>";
				html += "</td>"
				html += "<td>"
					html += "<span class='numero_trabajo'>" + data.trabajo.numero_tl + "</span> - " + data.trabajo.titulo_tl + "<br>";
						for(i=0;i<data.autores.length;i++){
						html += data.autores[i].Nombre + " " + data.autores[i].Apellidos + "; ";
					}
						
					html += '<input type="hidden" name="input_selected_trabajo[]" value="'+data.trabajo.id_trabajo+'">';			
				<!-- class='alert alert-danger' -->
				html += "</td>"
				html += "</tr>"
				html += "</table>"
				$("#result_trabajos").append(html);
				$("#trabajos-favoritos .panel-footer").show();
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