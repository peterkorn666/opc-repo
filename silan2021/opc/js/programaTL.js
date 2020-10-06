$(document).ready(function(){
	$('.display-resumen-link').click(function(e){
        e.preventDefault();
        var id = $(this).data("id");
		var l = $(this);
        $('#resumen'+id).stop().stop().slideToggle('fast', function(){
			if ($(this).is(':visible'))
                l.text('[ocultar]');
            else
                l.text('[ver]');
		});
    })
	
	$("#reset_tl").click(function() {
		$(this).closest('form').find("input[type=text], textarea, select").val("");
		$(this).closest('form').find("input[type=radio], input[type=checkbox]").prop("checked", false);
	});
	
	$("#actions_tl input[type='button']").click(function(){
		var object = this;
		$.ajax({
			url: "actions/actionsTL.php",
			type: "POST",
			cache: false,
			data: "from="+$(object).data("target")+"&id_trabajos="+$("input[name='id_trabajos[]']:checked").map(function(){return $(this).val();}).get()+"&to="+$("select[name='asignar_"+$(object).data("target")+"']").val(),
			beforeSend: function(){
				$(".loading").show();
			},
			success: function(data){
				if(data!=0)
					window.location.reload();
				else{
					alert("Error al realizar la accion, revise que haya seleccionado los trabajos.");
					$(".loading").hide();
				}
			},
			error: function(data){
				//alert(data.toSource());
			}
		});
	})
	
	$(".editar_hora_tl").keyup(function(){
		var hora_pos = $("input[name='"+$(this).attr("name")+"']").index(this);
		var hora_inicio = $("input[name='hora_inicio']").eq(hora_pos).val();
		var minutos_inicio = $("input[name='minutos_inicio']").eq(hora_pos).val();
		var hora_fin = $("input[name='hora_fin']").eq(hora_pos).val();
		var minutos_fin = $("input[name='minutos_fin']").eq(hora_pos).val();
		var id_tl = $("input[name='id_tl']").eq(hora_pos).val();
//		alert(hora_pos);
		if(hora_inicio!="" && hora_inicio!="00" && id_tl!=""){
			$.ajax({
				url: "ajax/guardarHoraTL.php",
				type: "POST",
				cache: false,
				data: "hora_inicio="+hora_inicio+":"+minutos_inicio+"&hora_fin="+hora_fin+":"+minutos_fin+"&id_tl="+id_tl,
				success: function(data){
					if(data=="0")
						alert("error al guardar.");
				}
			});
		}
	})
	
	$(".ver_mas_conf").click(function(e){
		e.preventDefault();
		var id = $(this).data("id");
		var self = $(this);
		$('#rc'+id).stop().stop().slideToggle('fast', function(){
			if ($(this).is(':visible'))
                self.text('[ocultar]');
            else
                self.text('[ver]');
		});
	})
	
	$(".ver_cv_conf").click(function(e){
		e.preventDefault();
		var id = $(this).data("id");
		var self = $(this);
		$('#cv'+id).stop().stop().slideToggle('fast', function(){
			if ($(this).is(':visible'))
                self.text('[ocultar]');
            else
                self.text('[cv]');
		});
	})
	
	$(".checkuntls").click(function(e){
		e.preventDefault();
		if($("input[name='id_trabajos[]']").prop("checked"))
			$("input[name='id_trabajos[]']").prop("checked", false);
		else
			$("input[name='id_trabajos[]']").prop("checked", true);
	})
})

function filterPrograma(dia, sala){
	var url = "?page=programaExtendido";
	if(dia)
		url += "&day="+dia;
	if(sala)
		url += "&section="+sala;
	var actividad = $("select[name='tipo_actividad'] option:selected").val();
	if(actividad)
		url += "&actividad="+actividad;
	document.location.href = url;
}
function filterProgramaImp(dia, sala){
	var url = "?page=programaExtendidoImp";
	if(dia)
		url += "&day="+dia;
	if(sala)
		url += "&section="+sala;
	var actividad = $("select[name='tipo_actividad'] option:selected").val();
	if(actividad)
		url += "&actividad="+actividad;
	document.location.href = url;
}