$(document).ready(function(e) {
	
	/*$('#conferencistas tfoot th').each( function (i) {
        var title = $(this).text();
		if(title!='')
			$(this).html( '<input type="text" style="width:60px;" data-index="'+i+'" />' );
		
    } );*/
	
	$('#conferencistas thead').append($('#conferencistas tfoot th'));
	
    var table = $('#conferencistas').DataTable( {
		"language": {
			"url": "js/dataTables.spanish.lang"
		},
		"order": [[ 0, "desc" ]],
		
		"pageLength": 100
	} );
	/*  
	"dom": "<'row'<'col-sm-4'l><'col-sm-3'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>",
	*/
	
	// Remove accented character from search input as well
	$('#conferencistas input').keyup( function () {
		table
		.search(
			jQuery.fn.DataTable.ext.type.search.string( this.value )
		)
		.draw()
	} );
	
	$("select[name='grupos_de_trabajo'],select[name='salas_filtro']").change( function() {
        table.draw();
		//window.location.href = '?page=listadoCompleto&GT=' + $(this).val();
    } );

	/*$( table.table().container() ).on( 'keyup', 'thead input', function () {
		console.log($(this).data('index'));
        table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );*/
	
	/*$("#conferencistas a").click(function(e){
		e.preventDefault();
		var index = $(this).data("modal");
		$("#target-modal-"+index).show();
	})*/
	
	$(".modal .close").click(function(){
		$(".modal").hide();
	})
	
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