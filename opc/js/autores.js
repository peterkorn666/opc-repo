$(document).ready(function(e) {
	$('#listado-autores tfoot th').each( function (i) {
        var title = $(this).text();
		if(title!='')
	        $(this).html( '<input type="text" style="width:100px;" data-index="'+i+'" />' );
		
    } );
	$('#listado-autores thead').append($('#listado-autores tfoot th'));
	
   	/*var inscriptos_table = $('#listado-inscriptos').DataTable( {
		"language": {
			"url": "../js/dataTables.spanish.lang"
		},
		"order": [[ 0, "desc" ]],
		"pageLength": 50
	} );*/
	
	var autores_table = $('#listado-autores').DataTable({
		"language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		"order": [[ 0, "desc" ]],
		//"pageLength": 50,
		"paging": false
		/*
		"fixedHeader": {
            "header": true,
            "footer": true
        }
		*/
	});
	$( autores_table.table().container() ).on( 'keyup', 'thead input', function () {
		autores_table
			.column( $(this).data('index') )
			.search( this.value )
			.draw();
			
			$(".autor-inscripto").click(function(){
				var self = this;
				var id = $(this).data("id");
				var ins = $(this).data("ins");
		
				$.ajax({
					type: "POST",
					url: "ajax/autores.php",
					cache: false,
					data: "id="+id+"&ins="+ins,
					beforeSend: function() {
						$(self).addClass('circle-loading');
					},
					success: function(a) {
						$(self).removeClass('circle-loading');
						if(a=='ok'){
							$(self).removeClass('circle-green circle-red circle-yellow');
							if(ins){
								$(self).addClass('circle-green');
								$(self).data('ins', 0);
							}else if($(".td_inscripto").eq($(".autor-inscripto").index(self)).html()!=""){
								$(self).addClass('circle-yellow');
								$(self).data('ins', 1);
							}else{
								$(self).addClass('circle-red');
								$(self).data('ins', 1);
							}
						}
						
					},
					error: function(e) {
						alert(e.toSource());
					},
					async: !0
				})
			}).css('cursor','pointer');
			
    } );
	
	
    $(".autor-inscripto").click(function(){
		console.log('entro');
		var self = this;
		var id = $(this).data("id");
		var ins = $(this).data("ins");

		$.ajax({
			type: "POST",
			url: "ajax/autores.php",
			cache: false,
			data: "id="+id+"&ins="+ins,
			beforeSend: function() {
				$(self).addClass('circle-loading');
			},
			success: function(a) {
				$(self).removeClass('circle-loading');
				if(a=='ok'){
					$(self).removeClass('circle-green circle-red circle-yellow');
					if(ins){
						$(self).addClass('circle-green');
						$(self).data('ins', 0);
					}else if($(".td_inscripto").eq($(".autor-inscripto").index(self)).html()!=""){
						$(self).addClass('circle-yellow');
						$(self).data('ins', 1);
					}else{
						$(self).addClass('circle-red');
						$(self).data('ins', 1);
					}
				}
				
			},
			error: function(e) {
				alert(e.toSource());
			},
			async: !0
		})
	}).css('cursor','pointer');
	
	$("input[name='allid']").change(function () {
		$("input[name='id_autor[]']").prop('checked', $(this).prop("checked"));
	});
	$("#unificar_autores").click(function(e){
		//e.preventDefault();
		if($("input[name='id_autor[]']:checked").length<2)
			return false;
		//$("#form_autores").prop("action",window.location.href.replace("personasTL","unificarTLa"));
		//$("form").submit();
	})
	
	$(".eliminarAutor").click(function(e){
		e.preventDefault();
		var id = $(this).data("id");
		if(id=="")
			return false;
		
		var self = this;
		alertify.confirm('Eliminar', 'Eliminar Autor?', function(){ 					
			$.ajax({
				type: "POST",
				url: "ajax/autores.php",
				cache: false,
				data: "id="+id+"&eliminar=1",
				success: function(a) {
					if(a=='ok'){
						$(self).closest("tr").remove();
						alertify.notify('Autor eliminado', 'success', 3);
					}
					
				},
				error: function(e) {
					alert(e.toSource());
				},
				async: !0
			})
			
		}
		, function(){});
		
		
	})
	
	$(".agregarIns").click(function(e){
		e.preventDefault();
		alertify.prompt( 'Nueva Institución', 'Institución', ''
               , function(evt, value) { 
			   		if(value==""){
						alertify.error('Escriba una institución.');	
						return false;
					}
			   		$.ajax({
						type: "POST",
						url: "ajax/agregarInstitucion.php",
						cache: false,
						data: "nombre="+value+"",
						dataType:"json",
						success: function(a) {
							if(a.status=='ok'){
								$('#institucion').append($('<option>', {
									value: a.id,
									text: value
								}));
								var list = $('#institucion option');
								list.sort(function(a,b){
									if (a.text > b.text) return 1;
									if (a.text < b.text) return -1;
									return 0
								});
								$('#institucion').empty().append( list );
								selectOption('#institucion option', value);
								alertify.success('Institución agregada');
							}else
								alertify.error('Hubo un error.');				
						},
						error: function(e) {
							alert(e.toSource());
						},
						async: !0
					})
			     }
               , function() {})
	})
	
	$(".agregarPais").click(function(e){
		e.preventDefault();
		alertify.prompt( 'Nuevo País', 'País', ''
               , function(evt, value) { 
			   		if(value==""){
						alertify.error('Escriba un País.');	
						return false;
					}
			   		$.ajax({
						type: "POST",
						url: "ajax/paises.php",
						cache: false,
						data: "nombre="+value+"",
						dataType:"json",
						success: function(a) {
							if(a.status=='ok'){
								$('#paises').append($('<option>', {
									value: a.id,
									text: value
								}));
								var list = $('#paises option');
								list.sort(function(a,b){
									if (a.text > b.text) return 1;
									if (a.text < b.text) return -1;
									return 0
								});
								$('#paises').empty().append( list );
								selectOption('#paises option', value);
								alertify.success('País agregado');
							}else
								alertify.error('Hubo un error.');				
						},
						error: function(e) {
							alert(e.toSource());
						},
						async: !0
					})
			     }
               , function() { })
	})
	
	$(".agregarProfesion").click(function(e){
		e.preventDefault();
		alertify.prompt( 'Nueva Profesión', 'Profesión', ''
               , function(evt, value) { 
			   		if(value==""){
						alertify.error('Escriba una Profesión.');	
						return false;
					}
			   		$.ajax({
						type: "POST",
						url: "ajax/profesiones.php",
						cache: false,
						data: "nombre="+value+"",
						dataType:"json",
						success: function(a) {
							if(a.status=='ok'){
								$('#profesiones').append($('<option>', {
									value: a.id,
									text: value
								}));
								var list = $('#profesiones option');
								list.sort(function(a,b){
									if (a.text > b.text) return 1;
									if (a.text < b.text) return -1;
									return 0
								});
								$('#profesiones').empty().append( list );
								selectOption('#profesiones option', value);
								alertify.success('Profesión agregada');
							}else
								alertify.error('Hubo un error.');				
						},
						error: function(e) {
							alert(e.toSource());
						},
						async: !0
					})
			     }
               , function() { })
	})
	
	$(".agregarCargos").click(function(e){
		e.preventDefault();
		alertify.prompt( 'Nuevo Cargo', 'Cargo', ''
               , function(evt, value) { 
			   		if(value==""){
						alertify.error('Escriba un Cargo.');	
						return false;
					}
			   		$.ajax({
						type: "POST",
						url: "ajax/cargos.php",
						cache: false,
						data: "nombre="+value+"",
						dataType:"json",
						success: function(a) {
							if(a.status=='ok'){
								$('#cargos').append($('<option>', {
									value: a.id,
									text: value
								}));
								var list = $('#cargos option');
								list.sort(function(a,b){
									if (a.text > b.text) return 1;
									if (a.text < b.text) return -1;
									return 0
								});
								$('#cargos').empty().append( list );
								selectOption('#cargos option', value);
								alertify.success('Cargo agregado');
							}else
								alertify.error('Hubo un error.');				
						},
						error: function(e) {
							alert(e.toSource());
						},
						async: !0
					})
			     }
               , function() { })
	})
});