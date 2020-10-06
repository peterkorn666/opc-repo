$(document).ready(function(e) {
	$("input[name='search_congreso']").keyup(function(){
        var search = $("input[name='search_congreso']").val();
        var opt = $("input[name='option-search']:checked").val();

       	if(opt==undefined || search=="")
        	return false;
            
        $.ajax({
			datatype : "html",
			type: "POST",
			url: "searchDropDay.php",
			cache: !0,
			data: "search="+search+"&opt="+opt,
			beforeSend: function() {
				$("#result_search_congreso").html('<h1 class="ajax-loading-animation"><i class="fa fa-cog fa-spin"></i> Cargando...</h1>');
			},
			success: function(a) {
				$("#result_search_congreso").css({
					opacity: "0.0"
				}).html(a).delay(50).animate({
					opacity: "1.0"
				}, 300), a = null;
     
                 //Droppable             
                 //var c = {};
                $("#table-search-result tr").draggable({
                        helper: "clone",
						scroll: false,
                        start: function(event, ui) {
                        	$(".casillero-drop").css("display","block");
                            
                            var p = 0;
                            $(".casillero-drop").droppable({
                                drop: function(event, ui) {
                                    if(p==0)
                                    {
                                        var opt = $("input[name='option-search']:checked").val();
                                        var key = ui.draggable.data("id");
                                        var casillero = $(this).data("id");
										var hora_inicio = $(this).data("hora_inicio");
                                       // alert("key="+key+"&opt="+opt+"&casillero="+casillero);
                                        $.ajax({
                                            type: "POST",
                                            url: "updateCasilleroAjax.php",
                                            cache: !0,
                                            data: "key="+key+"&opt="+opt+"&casillero="+casillero+"&hora_inicio="+hora_inicio,
                                            success: function(a) {
												//alert(a);
												cargarCrono(dia_,sala_);
                                                /*$(c.tr).remove();
                                                $(c.helper).remove();*/
                                            },
                                            error: function(e) {
                                                alert(e.responseText);
                                            },
                                            async: !0
                                        })
                                     }
                                     p++;
                                }
                            });                            
                            
                           /* c.tr = this;
                            c.helper = ui.helper;*/
                        },
                        stop: function(){
                            $(".casillero-drop").css("display","none");
                        }
                });		 
			},
			error: function(e) {
            	alert(e.responseText);
				$("#result_search_congreso").html('<h4 class="ajax-loading-error"><i class="fa fa-warning txt-color-orangeDark"></i> Error 404! Pagina no encontrada.</h4>')
			},
			async: !0
		})
    })
	
	
    $("#toggle-sidebar").click(function(e){
    	e.preventDefault();
        if($("#container-sidebar").css("left")=="-330px")
        {
            $("#container-sidebar").animate({
                left:0
            })
            
            $("#congreso").animate({
                left:+300
            })
        }else{
        	$("#container-sidebar").animate({
                left:-330
            })
            $("#congreso").animate({
                left:0
            })
        }
    })
});

$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
   if(scroll==0)
    	$("#container-sidebar").css("top","");
   else
   	$("#container-sidebar").css("top",0);
});