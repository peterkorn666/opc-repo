$(document).ready(function(e) {
	
	$('#listado-inscriptos tfoot th').each( function (i) {
        var title = $(this).text();
		if(title!=''){
			if(title == 'Estado'){
				$(this).html( '<input type="text" style="width:70px;" data-index="'+i+'" />' );
			}else
	        	$(this).html( '<input type="text" style="width:100px;" data-index="'+i+'" />' );
		}
		
    } );
	$('#listado-inscriptos thead').append($('#listado-inscriptos tfoot th'));
	
   	/*var inscriptos_table = $('#listado-inscriptos').DataTable( {
		"language": {
			"url": "../js/dataTables.spanish.lang"
		},
		"order": [[ 0, "desc" ]],
		"pageLength": 50
	} );*/
	
	var inscriptos_table = $('#listado-inscriptos').DataTable({
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
		"pageLength": 50
	});
	

	/*$('#listado-inscriptos thead input').on('keyup change', function () {
		if (inscriptos_table.search() !== this.value ) {
			inscriptos_table.search( this.value ).draw();
		}
	} );*/
	
	$( inscriptos_table.table().container() ).on( 'keyup', 'thead input', function () {
		console.log($(this).data('index'));
        inscriptos_table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );

//etiquetas
	$('#etiquetas-inscriptos tfoot th').each( function (i) {
        var title = $(this).text();
		if(title!='' && title!='N° Recibo' && title!='Cuenta') {
	        $(this).html( '<input type="text" style="width:164px; height:36px;" data-index="'+i+'" />' );
		}
		else if (title='N° Recibo' && title!='') {
			$(this).html( '<input type="text" style="width:100px; height:25px;" data-index="'+i+'" />' );
		}
		
    } );
	$('#etiquetas-inscriptos thead').append($('#etiquetas-inscriptos tfoot th'));
	
   	/*var inscriptos_table = $('#etiquetas-inscriptos').DataTable( {
		"language": {
			"url": "../js/dataTables.spanish.lang"
		},
		"order": [[ 0, "desc" ]],
		"pageLength": 50
	} );*/
	
	var etiquetas_table = $('#etiquetas-inscriptos').DataTable({
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
		"pageLength": 50
	});
	

	/*$('#listado-inscriptos thead input').on('keyup change', function () {
		if (inscriptos_table.search() !== this.value ) {
			inscriptos_table.search( this.value ).draw();
		}
	} );*/
	
	$( etiquetas_table.table().container() ).on( 'keyup', 'thead input', function () {
		console.log($(this).data('index'));
        etiquetas_table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
	
// end etiquetas 	
	$(".persona-inscripto").click(function(){
		var self = this;
		var id = $(this).data("id");
		var ins = $(this).data("ins");

		$.ajax({
			type: "POST",
			url: "../ajax/inscriptos.php",
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
					}else{
						$(self).addClass('circle-red');
						$(self).data('ins', 1);
					}
				}
				
			},
			error: function(e) {
				alert(e.responseText);
			},
			async: !0
		})
	}).css('cursor','pointer');
	
});

jQuery.fn.DataTable.ext.type.search.string = function ( data ) {
    return ! data ?
        '' :
        typeof data === 'string' ?
            data
                .replace( /έ/g, 'ε' )
                .replace( /[ύϋΰ]/g, 'υ' )
                .replace( /ό/g, 'ο' )
                .replace( /ώ/g, 'ω' )
                .replace( /ά/g, 'α' )
                .replace( /[ίϊΐ]/g, 'ι' )
                .replace( /ή/g, 'η' )
                .replace( /\n/g, ' ' )
                .replace( /á/g, 'a' )
                .replace( /é/g, 'e' )
                .replace( /í/g, 'i' )
                .replace( /ó/g, 'o' )
                .replace( /ú/g, 'u' )
                .replace( /ê/g, 'e' )
                .replace( /î/g, 'i' )
                .replace( /ô/g, 'o' )
                .replace( /è/g, 'e' )
                .replace( /ï/g, 'i' )
                .replace( /ü/g, 'u' )
                .replace( /ã/g, 'a' )
                .replace( /õ/g, 'o' )
                .replace( /ç/g, 'c' )
                .replace( /ì/g, 'i' ) :
            data;
};
