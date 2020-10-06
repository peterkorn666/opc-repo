//Format: hide, display arrays elements.
function toggle(hide, displays){
	$(hide).each(function(index, element) {
        $(element).fadeOut("fast", function(){
			if(displays){
				$(displays).each(function(indexs, elements) {
					$(elements).fadeIn("fast");
				});
			}
		});
    });
}

function comprobante(){
	if($("input[name='numero_comprobante']").val()==''){
		alert('Escriba el numero del comprobante')
		$("input[name='numero_comprobante']").focus();
		return false;
	}
	
	if($("input[name='comprobante_pago']").val()==''){
		alert('Seleccione el comprobante')
		$("input[name='comprobante_pago']").focus();
		return false;
	}
}

$(document).ready(function(e) {	
	$("#btn_opt_panel").click(function(e){
		e.preventDefault();
		toggle(Array("#div_default_opt"),Array("#div_opt_panel"));
	});	
	$("#btn_opt_panel_back").click(function(e){
		e.preventDefault();
		toggle(Array("#div_opt_panel"),Array("#div_default_opt"));
	});
	
	$("#btn_opt_search_author").click(function(e){
		e.preventDefault();
		$("input[name='search_authors']").val("");
		$("#div_authors_result").html("");
		toggle(Array("#div_opt_panel"),Array("#div_search_autor"));
	});
	$("#btn_search_author_back").click(function(e){
		e.preventDefault();
		toggle(Array("#div_search_autor"),Array("#div_opt_panel"));
	});
	
	$("#btn_search_author").click(function(){
		$.ajax({
		  type: 'POST',
		  url: 'actions/getTrabajos.php',
		  data: { search_author: $("input[name='search_authors']").val(), j: 1 },
		  dataType:"json",
		  beforeSend: function(){
			  $("#div_authors_result").html("Cargando resultados...");
		  },
		  success: function(data){
			var html = ""
			if(data && data!=null){
				$.each(data,function(i, o){
					html += "<a href='#' class='set_author' data-id='"+o.id_trabajo+"' data-coor='"+o.id_coordinador+"' data-title='"+o.titulo+"'>";
					html += o.nombre+" "+o.apellido;
					html += "</a>";
				})
			}
			$("#div_authors_result").html(html);
		  },
		  error:function(err){
			$("#div_authors_result").html("Ha ocurrido un error.");
		  }
		});
	});
	
	$(document).on("click",".set_author",function(e){
		e.preventDefault();
		toggle(Array("#div_search_autor"),Array("#div_set_author_title"));
		var self = $(this);
		$("#holder_coor").html(self.html());
		$("input[name='id_trabajo']").val(self.data("id"));
		$("input[name='id_coordinador']").val(self.data("coor"));
		$("input[name='author_title']").val(self.data("title"));
		
	});
	$("#btn_set_author_back").click(function(e){
		e.preventDefault();
		toggle(Array("#div_set_author_title"),Array("#div_search_autor"));
	});
	
	$("#save_author_title").submit(function(e){
		e.preventDefault();
		$.ajax({
		  type: 'POST',
		  url: 'actions/guardarAutorTitulo.php',
		  data: $(this).serialize()+"&j=1",
		  dataType:"json",
		  beforeSend: function(){
			  $("#save_author_title button[type='submit']").prop("disabled", true);
			  $("#author_title_status").html("Guardando espere...");
		  },
		  success: function(data){
			$("#save_author_title button[type='submit']").prop("disabled", false);
			if(data=="ok"){
				$("#author_title_status").html("Guardado correctamente");
			}else{
				$("#author_title_status").html("Hubo un error al guardar");
			}
		  },
		  error:function(err){
			  
			$("#author_title_status").html("Ha ocurrido un error.");
		  }
		});
	});
	
	if($("input[name='numero_comprobante']").length){
		$("input[name='numero_comprobante']").keyup(function (e) {
			checkComprobante(this)
		});
		$(document).on("paste","input[name='numero_comprobante']",function (e) {
			checkComprobante(this)
		});
	}
});

function checkComprobante(e){
	var str = $(e).val();
	str = str.replace(/[^a-zA-Z 0-9]+/g, '');
	console.log(str)
	$(e).val(str);
}