$(document).ready(function(e) {
	var array_tls = new Array();
    $("#btn_search_tl").click(function(){
		b = $("#resultTlajax");
		$.ajax({
			type: "POST",
			url: "busquedaTrabajosLibres_ajax.php",
			cache: !0,
			data: "tl_trabajo="+$("#search_tl").val(),
			beforeSend: function() {
				b.html('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Cargando...</h1>');
			},
			success: function(a) {
				b.css({
					opacity: "0.0"
				}).html(a).delay(50).animate({
					opacity: "1.0"
				}, 300), a = null, b = null;
				//Sortable
				 $( "#ul_tl li" ).draggable({
					appendTo: "body",
					helper: "clone"
				 });
				 
				//Droppable
				//var prevent_drop = false;
				 $( ".div_drop_tl" ).droppable({
					activeClass: "ui-state-default",
					hoverClass: "ui-state-hover",
					accept: ":not(.ui-sortable-helper)",
					drop: function( event, ui ) {
						value_input = ui.draggable.find("input").val();
						prevent_drop = false;
						$(".div_drop_tl input").each(function(index, element) {
							if($(this).val()==value_input){
									prevent_drop = true;							
							}
                        });
						
						if(!prevent_drop){							
							$( this ).find( ".placeholder" ).remove();							
							$( "<div class='sortable_tl'></div>" ).html( "<div class='row'><div class='col-xs-11'>"+ui.draggable.html()+"</div><div class='col-xs-1'><img class='delete_tl' src='imagenes/delete.png' width='22'> <a href='altaTrabajosLibres.php?id="+value_input+"' target='_blank'><img src='imagenes/edit.png' width='17' style='margin-top:0px'></a></div></div>" ).appendTo( this );
						}
					}
					}).sortable({
						items: ".sortable_tl",
						revert: true,
						sort: function() {
						// gets added unintentionally by droppable interacting with sortable
						// using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
						$( this ).removeClass( "ui-state-default" );
					}
				}); 
				 
			},
			error: function() {
				b.html('<h4 class="ajax-loading-error"><i class="fa fa-warning txt-color-orangeDark"></i> Error 404! Pagina no encontrada.</h4>')
			},
			async: !0
		})
	})
	
	$(document).on("click",".div_drop_tl .delete_tl",function(){ 
    	$(this).closest(".sortable_tl").slideUp("slow",function(){
			$(this).remove();
		})
	})
	
	$(document).on("click","#cerrar_result_tl",function(){
		$("#resultTlajax").html("");
		$("#search_tl").val("");
	})
	
});