$(document).ready(function(e) {
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var modalidad_filtro = $("select[name='modalidad'] option:selected").val();
            var modalidad_tabla = data[10] || 0;
            var modalidad_condicion = (modalidad_filtro === "" || (modalidad_filtro === modalidad_tabla));

            var area_trabajo_filtro = $("select[name='area_tl'] option:selected").val();
            var area_trabajo_tabla = data[11] || 0;
            var area_trabajo_condicion = (area_trabajo_filtro === "" || (area_trabajo_filtro === area_trabajo_tabla));

        	var linea_transversal_filtro = $("select[name='linea_transversal'] option:selected").val();
        	var linea_transversal_tabla = data[12] || 0;
            var linea_transversal_condicion = (linea_transversal_filtro === "" || (linea_transversal_filtro === linea_transversal_tabla));

			if (modalidad_condicion && area_trabajo_condicion && linea_transversal_condicion) {
				return true;
			} else {
				return false;
			}
        }
    );
    $("select[name='modalidad'], select[name='area_tl'], select[name='linea_transversal']").change( function() {
        table.draw();
    });

    $('#listado-evaluaciones thead tr').clone(true).appendTo( '#listado-evaluaciones thead' );
    $('#listado-evaluaciones thead tr:eq(1) th').each( function (i) {
        //Quito la columna de checkbox, la de modalidad, la de area, la de linea transversal y la del botón [Ver]
    	if (i !== 0 && i !== 10 && i !== 11 && i !== 12 && i !== 13){
            //var title = $(this).text();
            var title = $(this).data('nombre_buscador');
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
		} else if (i === 0){
            $(this).html('<a id="marcar_checkboxs" href="javascript:void(0)" class="marcar_todos" data-a_marcar="true">Marcar todos</a>');
		}

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var table = $("#listado-evaluaciones").DataTable({
        "orderCellsTop": true,
        "fixedHeader": true,
		"dom": 'lBfrtip',
		"buttons": [
			{
				extend: 'colvis',
				text: 'Columnas a mostrar'
			},
			{
				extend: 'copy',
				text: 'Copiar a portapapeles'
			},
			{
				extend: 'excel',
				text: 'Descargar excel'
			},
			{
				extend: 'print',
				text: 'Imprimir'
			}
		],
        "columnDefs": [
            {
                "targets": [10, 11, 12],
                "visible": false
            }
        ],
		"language": {
			"decimal": ",",
			"thousands": ".",
			
			"lengthMenu": "Mostrar _MENU_ registros por página",
			"search": "Buscar:",
			"zeroRecords": "No se encontraron registros para la busqueda",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No hay registros disponibles",
			"infoFiltered": "(filtrado de _MAX_ registros en total)",
			"paginate": {
				"next":     "Siguiente",
				"previous": "Anterior"
			},
		},
		"pageLength": 50,
		"order": [[ 1, "desc" ]]
	});

    $("#prerarar_mail").click(function(e){
    	e.preventDefault();
    	var form = $("#formEvaluaciones");
        form.attr("method", "POST");
        //form.attr("action", "../old/envioMail_trabajosLibres.php");
        form.attr("action", "../envio_mail/trabajos/index.php");
        form.submit();
	});

    $("#mover_trabajos").click(function(e){
        e.preventDefault();
        var mover_a = $("select[name='mover_a'] option:selected").val();
        if (mover_a === "" || mover_a === undefined){
			alert("Debe seleccionar el estado al que se mueven los trabajos.");
			return false;
		}
        var checkboxs_trabajos = $("input[name='id_trabajos[]']:checked");
        if(checkboxs_trabajos.length === 0){

            alert("Debe seleccionar al menos un trabajo a mover.");
            return false;
        }

        var form = $("#formEvaluaciones");
        form.attr("method", "POST");
        //form.attr("action", "../old/envioMail_trabajosLibres.php");
        form.attr("action", "actions/moverTL.php");
        form.submit();
    });

    $("#marcar_checkboxs").click(function(){
    	var check = $(this).data("a_marcar");
        marcar(check);
        if(check === true){
            $(this).html("Desmarcar todos");
            $(this).data("a_marcar", false);
		} else {
            $(this).html("Marcar todos");
            $(this).data("a_marcar", true);
		}
    });

});

function marcar(check){
    $(".checkbox_trabajos").each(function(){
        $(this).prop('checked', check);
    });
}
