$(document).ready(function(){
	//$('.trabajo_programa .resumen').hide();
	
	$('.display-resumen-link').click(function(e){
        e.preventDefault();
        var pos = $('.display-resumen-link').index(this);
		var l = $(this);
        $('.trabajo .resumen').eq(pos).stop().stop().slideToggle('fast', function(){
			if ($(this).is(':visible'))
                l.text('[ocultar]');
            else
                l.text('[ver]');
		});
		$('.trabajo_programa .resumen').eq(pos).stop().stop().slideToggle('fast', function(){//
			var es_visible = $(this).is(':visible');
			if (es_visible){
                l.text('[ocultar]');
			}else{
                l.text('[ver]');
			}
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
		var pos = $(".ver_mas_conf").index(this);
		var self = $(this);
		$('.div_obs_conf').eq(pos).stop().stop().slideToggle('fast', function(){
			if ($(this).is(':visible'))
                self.text('[ocultar]');
            else
                self.text('[ver]');
		});
		
		var id = $(this).data('id');
		$('.div_cv_conf[data-id=' + id + ']').hide();
		$('.ver_cv_conf[data-id=' + id + ']').text('[cv]');
	})
	
	$(".ver_cv_conf").click(function(e){
		e.preventDefault();
		var pos = $(".ver_cv_conf").index(this);
		var self = $(this);
		$('.div_cv_conf').eq(pos).stop().stop().slideToggle('fast', function(){
			if ($(this).is(':visible'))
                self.text('[ocultar]');
            else
                self.text('[cv]');
		});
		
		var id = $(this).data('id');
		$('.div_obs_conf[data-id=' + id + ']').hide();
		$('.ver_mas_conf[data-id=' + id + ']').text('[ver]');
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