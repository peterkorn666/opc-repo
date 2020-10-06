// JavaScript Document
Event.observe(window, 'load',
function() {  
    //initEditor($("editor_titulo_tl"), $("div_titulo_tl"), $("titulo_tl"), false);
    
});

function initEditor(form, div_editor, textarea, styleWithCSS) {

    var buttons = form.select('button[data-ed]');
    
    buttons.each(function(button) {

        var query = button.readAttribute('data-ed').toQueryParams();
        var command = query.cmd;

        button.disabled = true;

        if (command) {
            setInterval(function() {
                if (isSupported(command))
                button.disabled = false;
                else
                button.disabled = true;
            },
            500);
            switch (command) {
            case 'bold':
                Event.observe(button, 'click',
                function() {
                    document.execCommand('bold', null, null);
					setBtnActive(button);
                });
                break;
            case 'italic':
                Event.observe(button, 'click',
                function() {
                    document.execCommand('italic', null, null);
					setBtnActive(button);
                });
                break;
			case 'underline':
                Event.observe(button, 'click',
                function() {
                    document.execCommand('underline', null, null);
					setBtnActive(button);
                });
                break;
            case 'subscript':
                Event.observe(button, 'click',
                function() {
                    document.execCommand('subscript', null, null)
					setBtnActive(button);
                });
                break;
            case 'superscript':
                Event.observe(button, 'click',
                function() {
                    document.execCommand('superscript', null, null);
					setBtnActive(button);
                });
                break;              
            default:
                break;
            }
        }
    });


    function isSupported(s) {
        try
        {
            return (document.queryCommandEnabled(s));
        } catch(e) {
            return false;
            //querycommand... function not supported
        }
    }
	
	function setBtnActive(button)
	{
		if($(button).hasClassName("btnActive"))
			$(button).removeClassName("btnActive");
		else
			$(button).addClassName("btnActive");
	}
	
	$(textarea).value = $(div_editor).innerHTML;
	$(div_editor).observe("keyup", function() {
      $(textarea).value = $(div_editor).innerHTML;
    });
	$$('.btn').invoke('observe', "click", function() {
      $(textarea).value = $(div_editor).innerHTML;
    });

}