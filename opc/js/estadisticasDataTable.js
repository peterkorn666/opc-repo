$(document).ready(function(e) {
	
	/*$('#planilla-inscriptos tfoot th').each( function (i) {
        var title = $(this).text();
		if(title!='')
	        $(this).html( '<input type="text" style="width:100px;" data-index="'+i+'" />' );	
    } );*/
	$('#planilla-inscriptos thead').append($('#planilla-inscriptos tfoot th'));
	
	var inscriptos_table = $('#planilla-inscriptos').DataTable({
		"language": {
			"url": "js/dataTables.spanish.lang"
		},
		"order": [[ 0, "desc" ]],
		"pageLength": 100
	});
	
	/*$('#planilla-inscriptos input').keyup( function () {
		table
		.search(
			jQuery.fn.DataTable.ext.type.search.string( this.value )
		)
		.draw()
	} );*/
	
	$( inscriptos_table.table().container() ).on( 'keyup', 'thead input', function () {
		console.log($(this).data('index'));
        inscriptos_table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
	
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
