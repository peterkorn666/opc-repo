function agregarCoAutores(){
	
		cantidadAutores = $(".personasTLInput").length;
		if (colorfila == 0){
			var color = "#DDD3E2";
			colorfila=1;
		} else {
			var color = "#D8CCDD";
			colorfila=0;
		}

	
	/*tempSeleccion();*/

	
	
	var tablaAutores = ''
		tablaAutores += '<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="bordePunteadoAbajo">'
		tablaAutores += '<tr>'
		tablaAutores += '<td>'
		tablaAutores += '<table width="740" border="0" align="center" cellpadding="2" cellspacing="0">'
		tablaAutores += '<tr valign="top">'
		tablaAutores += '<td width="100" height="15" valign="top">'
		tablaAutores += '<font size="2">'
		tablaAutores += '<font size="1" color="#9900FF">['+(cantidadAutores+1)+']</font>'
		tablaAutores += ' Co - Autor:</font></td>'
		tablaAutores += '<td width="533" height="15" valign="top"  nowrap="nowrap">'
		tablaAutores += '<div>'
		tablaAutores += '<div id="txt_persona_'+(cantidadAutores)+'" style=" position:relative;  margin-bottom:4px; overflow:hidden; width:450px; display:none; float:left;"></div>'
		tablaAutores += '<input name="persona[]" type="hidden" />'
		tablaAutores += '<input name="persona_'+(cantidadAutores)+'" type="text" class="camposTL personasTLInput" id="persona_'+(cantidadAutores)+'"   style="width:250; color:#999999;" onKeyUp="buscando_personas(\'persona'+(cantidadAutores)+'\', this.value, '+(cantidadAutores)+', \'persona_'+(cantidadAutores)+'\')" onClick="this.value=\'\'" value="Busque un autor en la base de datos...">'
		tablaAutores += ' <a style="font-size:11px; font-weight:normal;" href="altaPersonasTL.php?combo='+cantidadAutores+'&sola=1" title="Agregar una nueva persona en la base de datos" class="linkAgregar tipsy popup"><img src="imagenes/add_person.png" width="20" align="absbottom"> </a></div>'
		tablaAutores += '<div id=\'persona'+(cantidadAutores)+'\'></div>'
		tablaAutores += '</td>'
		tablaAutores += '<td width="95" valign="top"><font size="2">'
		tablaAutores += '<input name="lee_['+(cantidadAutores)+']" type="checkbox" id="lee_[]" value="1" />'
		tablaAutores += ' presentador</font></td>'
		tablaAutores += '</tr>'
		tablaAutores += '</table></td>'
		tablaAutores += '</tr>'
		tablaAutores += '</table><input name="lee[]" type="hidden" />'
     
                
           
        document.getElementById("divCoautores").innerHTML += tablaAutores;

		cantidadAutores = cantidadAutores + 1;
		
		
		/*llenarPersonas();
		seleccionarPersonas();*/
		
}