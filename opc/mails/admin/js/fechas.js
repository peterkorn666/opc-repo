/* en el form va 
<input name="txtFinicio" id="txtFinicio" type="text" size="10" maxlength="10"  onKeyUp = "this.value=formateafecha(this.value)"> */

// JavaScript Document
function IsNumeric(valor) 
{ 
var log=valor.length; var sw="S"; 
for (x=0; x<log; x++) 
{ v1=valor.substr(x,1); 
v2 = parseInt(v1); 
//Compruebo si es un valor numérico 
if (isNaN(v2)) { sw= "N";} 
} 
if (sw=="S") {return true;} else {return false; } 
} 

var primerslapFecha=false; 
var segundoslapFecha=false; 

function formateafecha(fecha) 
{ 
var long = fecha.length; 
var dia; 
var mes; 
var ano; 

if ((long>=2) && (primerslapFecha==false)) { dia=fecha.substr(0,2); 
if ((IsNumeric(dia)==true) && (dia<=31) && (dia!="00")) { fecha=fecha.substr(0,2)+"/"+fecha.substr(3,7); primerslapFecha=true; } 
else { fecha=""; primerslapFecha=false;} 
} 
else 
{ dia=fecha.substr(0,1); 
if (IsNumeric(dia)==false) 
{fecha="";} 
if ((long<=2) && (primerslapFecha=true)) {fecha=fecha.substr(0,1); primerslapFecha=false; } 
} 
if ((long>=5) && (segundoslapFecha==false)) 
{ mes=fecha.substr(3,2); 
if ((IsNumeric(mes)==true) &&(mes<=12) && (mes!="00")) { fecha=fecha.substr(0,5)+"/"+fecha.substr(6,4); segundoslapFecha=true; } 
else { fecha=fecha.substr(0,3);; segundoslapFecha=false;} 
} 
else { if ((long<=5) && (segundoslapFecha=true)) { fecha=fecha.substr(0,4); segundoslapFecha=false; } } 
if (long>=7) 
{ ano=fecha.substr(6,4); 
if (IsNumeric(ano)==false) { fecha=fecha.substr(0,6); } 
else { if (long==10){ if ((ano==0) || (ano<2002) || (ano>2020)) { fecha=fecha.substr(0,6); } } } 
} 

if (long>=10) 
{ 
	fecha=fecha.substr(0,10); 
	dia=fecha.substr(0,2); 
	mes=fecha.substr(3,2); 
	ano=fecha.substr(6,4); 
	// Año no biciesto y es febrero y el dia es mayor a 28 
		if ( (ano%4 != 0) && (mes ==02) && (dia > 28) ) { fecha=fecha.substr(0,2)+"/"; } 
		} 
	return (fecha); 
} 

var primerslapHMS=false; 
var segundoslapHMS=false; 

function formateaHMS(hms) 
{ 
var long = hms.length; 
var hora; 
var minuto; 
var segundo; 

if ((long>=2) && (primerslapHMS==false)) { hora=hms.substr(0,2); 
if ((IsNumeric(hora)==true) && (hora<=24)) { hms=hms.substr(0,2)+":"+hms.substr(3,7); primerslapHMS=true; } 
else { hms=""; primerslapHMS=false;} 
} 
else 
{ hora=hms.substr(0,1); 
if (IsNumeric(hora)==false) 
{hms="";} 
if ((long<=2) && (primerslapHMS=true)) {hms=hms.substr(0,1); primerslapHMS=false; } 
} 
if ((long>=5) && (segundoslapHMS==false)) 
{ minuto=hms.substr(3,2); 
if ((IsNumeric(minuto)==true) &&(minuto<=59)) { hms=hms.substr(0,5)+":"+hms.substr(6,4); segundoslapHMS=true; } 
else { hms=hms.substr(0,3);; segundoslapHMS=false;} 
} 
else { if ((long<=5) && (segundoslapHMS=true)) { hms=hms.substr(0,4); segundoslapHMS=false; } } 
if (long>=7) 
{ segundo=hms.substr(6,4); 
if (IsNumeric(segundo)==false) { hms=hms.substr(0,6); } 
else { if (long==10){ if ((IsNumeric(minuto)==true) && (minuto<=59)) { hms=hms.substr(0,6); } } } 
} 

if (long>=8) 
{ 
	hms=hms.substr(0,8); 
	hora=hms.substr(0,2); 
	minuto=hms.substr(3,2); 
	segundo=hms.substr(6,2); 

} 
return hms;
}


var primerslapHM=false; 

function formateaHM(hm) 
{ 
var long = hm.length; 
var hora; 
var minuto; 

if ((long>=2) && (primerslapHM==false)) { hora=hm.substr(0,2); 
if ((IsNumeric(hora)==true) && (hora<=24)) { hm=hm.substr(0,2)+":"+hm.substr(3,5); primerslapHM=true; } 
else { hm=""; primerslapHM=false;} 
} 
else 
{ hora=hm.substr(0,1); 
if (IsNumeric(hora)==false) 
{hm="";} 
if ((long<=2) && (primerslapHM=true)) {hm=hm.substr(0,1); primerslapHM=false; } 
} 
if ((long>=5) ) 
{ minuto=hm.substr(3,2); 
if ((IsNumeric(minuto)==true) &&(minuto<=59)) { hm=hm.substr(0,5); } 
else { hm=hm.substr(0,3);} 
} 



if (long>=5) 
{ 
	hm=hm.substr(0,8); 
	hora=hm.substr(0,2); 
	minuto=hm.substr(3,2);  
} 
return hm;
}


