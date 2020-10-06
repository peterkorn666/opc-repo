// JavaScript Document
$(function() {

  transition_timeout = 40;
  old = "";
  $('.title_items').click(function() {

    current = $("#"+$(this).data("item")).find('li');
	current_id = $(this).data("item");
	if(current_id!=old)
	{
		$(".filter ul li").removeClass("visible");
		$(".filter p").removeClass('active');
	}	
    $(this).toggleClass('active');
    current.toggleClass('visible');	
    if ($(this).hasClass('active')) {
      for (i = 0; i <= current.length; i++) {
        $(current[i]).css('transition-delay', transition_timeout * i + 'ms');
      }
    } else {
      for (i = current.length, j = -1; i >= 0; i--, j++) {
        $(current[i]).css('transition-delay', transition_timeout * j + 'ms');
      }
    }
	old = current_id;
 });
 $(".filter_opt").click(function()
 {
	 $(".title").removeClass("active_title");
	 $(".filter ul li").removeClass("visible");
	 $(".filter p").removeClass('active');
	 $(".title_items").toggle("fast",function(){
		setTimeout(function(){
			if($(".title_items").is(":visible"))
			{
				$(".title").addClass("active_title");
			} 
		},100)
	 });
	 
 })
 
});