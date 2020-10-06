function mOvr(src,clrOver) { 
	if(clrOver=='') {clrOver = '#B9D7EA'} defaultColor = src.bgColor; src.bgColor = clrOver; } 

function mOut(src) { src.bgColor = defaultColor; }

function activarMenu(n) {
	var nombreMenu;
	nombreMenu = "Menu"+n;
	var menu;
	if (document.all)
		menu = document.all(nombreMenu);
	else
		menu = document.getElementById(nombreMenu);
	if (menu) 
		menu.className='menuActivo';	
}

function abrirVentana(url, ancho, alto){        str = "toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width="+ancho+",height="+alto;        ventana = window.open(url,"",str);}function irA(url, ancho, alto){        location.href=url;}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
alert("cargando");
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


 function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
 }

 function abrirSelector(elementos,campo,lista) {
  window.open('selector.php?texto=A&elementos=' + elementos + '&campo=' + campo + '&list=' + lista,'Selector','width=580, height=470,  menubar=no, status=yes, location=no, toolbar=no, scrollbars=no, resizable=yes');
 return false;
 }

 function abrirVentana(url,nombre,ancho,alto) {
  window.open(url,nombre,'width=' + ancho + ', height=' + alto + ',  menubar=no, status=yes, location=no, toolbar=no, scrollbars=no, resizable=yes');
 return false;
 }

