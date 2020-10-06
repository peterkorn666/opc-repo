$(document).ready(function(e) {
    $('#listado-inscriptos').DataTable( {
		"language": {
			"url": "../js/dataTables.spanish.lang"
		},
		"order": [[ 0, "desc" ]],
		"pageLength": 50
	} );
	
	
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
