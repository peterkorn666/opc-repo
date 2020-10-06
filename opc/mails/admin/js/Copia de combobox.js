
function ComboBox(nombreCampo,divPanel,funcionCargarDatos,funcionOnEnter) {
	this.campoTexto= nombreCampo;
	this.campoValor= "";
	this.listadoPanel="";
	this.funcionCargarDatos= funcionCargarDatos;
	this.funcionOnEnter= funcionOnEnter;
	this.cantidadOpciones= 0;
	this.active= 0;
	this.valores= [];
	this.textos= [];
	this.otrosDatos = [];
    this.offX= 0;
    this.offY= 0;
    this.tipID= divPanel;
	this.ready=false;
	this.tip=null;
	this.visible=false;
	this.overPanel=false;

	this.init=function(){if ($(nombreCampo).type=="text") {if(document.createElement&&document.body&&typeof document.body.appendChild!="undefined"){if(!document.getElementById(this.tipID)){var el=document.createElement("DIV");el.id=this.tipID;document.body.appendChild(el);}  $(this.campoTexto).onkeyup=this.levantarTecla;$(this.campoTexto).onblur=this.perderFoco;$(this.tipID).onmouseover=this.mouseOverPanel;$(this.tipID).onmouseout=this.mouseOutPanel; $(this.tipID).combo=this;$(this.campoTexto).combo=this;this.ready=true;}} else {this.ready=false}; };
	this.show=function(){this.visible=true;this.tip=document.getElementById(this.tipID);this.writeTip("");this.writeTip(this.listadoPanel);viewport.getAll();this.positionTip();this.toggleVis(this.tipID, 'visible');};
	this.writeTip=function(msg){if(this.tip&&typeof this.tip.innerHTML!="undefined")this.tip.innerHTML=msg;};
	this.positionTip=function(){ x=this.offX;y=this.offY;this.tip.style.left=x+"px";this.tip.style.top=y+"px";};	
	
	this.hide=function(){this.visible=false;this.toggleVis(this.tipID, 'hidden');this.tip=null;};
	this.toggleVis=function(id,vis){var el=document.getElementById(id);if(el)el.style.visibility=vis;};
	

	this.cantidad=function(c) {
		this.cantidadOpciones=c;
	};

	this.seleccionarPrimero=function() {
		if (this.cantidadOpciones>0) {
			this.activar(1);
		} else {
			this.activar(0);
		}
	};

	this.seleccionarNinguno=function() {
		this.activar(0);
	};

	this.seleccionarAnterior=function() {
		if (this.active>1) {
			this.activar(this.active-1);
		}
	};

	this.seleccionarSiguiente=function() {
		if (this.active<this.cantidadOpciones) {
			this.activar(this.active+1);
		}
	};

	this.activar=function(nuevo) {
		anterior=this.active;
		if (anterior!=nuevo) {
			this.active=nuevo;
			a=$("ComboBox_" + this.campoTexto + "_" + anterior);
			if (a) {
				a.setStyle("background-color: transparent");
			}
		}
		n=$("ComboBox_" + this.campoTexto + "_"+ nuevo);
		if (n) {
			n.setStyle("background-color: #FF0000");
		}
	};

	this.valorActivo=function() {return this.valores[this.active];};
	
	this.textoActivo=function() {return this.textos[this.active];};
	
	this.otrosDatosActivo=function() {return this.otrosDatos[this.active];};
	
	this.levantarTecla=function(e){
		if (!e) var e=event;
		c=$(this).getValue();
				
		tecla=eventKey(e);
		codigo=e.keyCode;
		
		aceptados="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@._-,; ������������";
		tecla_valida= (aceptados.indexOf(tecla) != -1);
		if (codigo==27) { //scape
			this.combo.hide();
		}
		if (codigo==13) { // enter
			if (this.combo.visible) {
				c=this.combo.valores[this.combo.active];
			} 
			eval(this.combo.funcionOnEnter + "(c,this.combo)");
			this.combo.hide();
		}
		if (codigo==38) { // cursor arriba
			this.combo.seleccionarAnterior();
		}
		if (codigo==40) { // cursor abajo
			this.combo.seleccionarSiguiente();
		}
		if (c!="" && (tecla_valida || codigo==8) ) {
			eval(this.combo.funcionCargarDatos + "(this.combo)");
		} 
		
		if (c=="") {
			eval(this.combo.funcionOnEnter + "(c,this.combo)");
		}
	};
	
	this.cargarDatos=function(){
		eval(this.funcionCargarDatos + "(this)");
	};
	
	this.perderFoco=function(e) {	
		if (!this.combo.overPanel){
			this.combo.hide();
		}
	};
	
	this.mouseOverPanel=function(e) {
		this.combo.overPanel=true;
	};
	
	this.mouseOutPanel=function(e) {
		this.combo.overPanel=false;
	};
	
	this.cargarDatosJSON=function(datos) {	
		valorActivo=this.valorActivo();
		activoActual=this.active;
		activoNuevo=0;
		this.valores=[];
		this.textos=[];
		this.otrosDatos=[];
		this.listadoPanel="";
		for (var i=0; i<datos.length;i++)
		{
			this.valores[i+1]=datos[i].valor;
			this.textos[i+1]=datos[i].texto;
			this.otrosDatos[i+1]=datos[i].otrosDatos;
			if (valorActivo==datos[i].valor) {
				activoNuevo=i+1;
			}
			this.listadoPanel+="<span id='ComboBox_" + this.campoTexto + "_" + (i+1) + "'><a href='#' onclick='javascript:" + this.funcionOnEnter + "(\"" + datos[i].valor + "\",$(\"" + this.campoTexto +"\").combo );$(\"" + this.campoTexto +"\").combo.hide();return false;'>" + datos[i].texto + "</a></span><br/>";			
		}

		this.cantidad(i);
		
		c=$(this.campoTexto); vo=c.positionedOffset(); 

		this.offX=vo.left; this.offY=vo.top+c.getHeight(); 
		if (this.listadoPanel=="") {
			this.hide(); 
		} else {

			this.show();

			if (activoNuevo!=0) {
				this.activar(activoNuevo);
			} else {
				this.seleccionarPrimero();
			}
		}
	};
	
	this.init();
}


var viewport = {
  getWinWidth: function () {
    this.width = 0;
    if (window.innerWidth) this.width = window.innerWidth - 18;
    else if (document.documentElement && document.documentElement.clientWidth) 
  		this.width = document.documentElement.clientWidth;
    else if (document.body && document.body.clientWidth) 
  		this.width = document.body.clientWidth;
  },
  
  getWinHeight: function () {
    this.height = 0;
    if (window.innerHeight) this.height = window.innerHeight - 18;
  	else if (document.documentElement && document.documentElement.clientHeight) 
  		this.height = document.documentElement.clientHeight;
  	else if (document.body && document.body.clientHeight) 
  		this.height = document.body.clientHeight;
  },
  
  getScrollX: function () {
    this.scrollX = 0;
  	if (typeof window.pageXOffset == "number") this.scrollX = window.pageXOffset;
  	else if (document.documentElement && document.documentElement.scrollLeft)
  		this.scrollX = document.documentElement.scrollLeft;
  	else if (document.body && document.body.scrollLeft) 
  		this.scrollX = document.body.scrollLeft; 
  	else if (window.scrollX) this.scrollX = window.scrollX;
  },
  
  getScrollY: function () {
    this.scrollY = 0;    
    if (typeof window.pageYOffset == "number") this.scrollY = window.pageYOffset;
    else if (document.documentElement && document.documentElement.scrollTop)
  		this.scrollY = document.documentElement.scrollTop;
  	else if (document.body && document.body.scrollTop) 
  		this.scrollY = document.body.scrollTop; 
  	else if (window.scrollY) this.scrollY = window.scrollY;
  },
  
   setScrollY: function (n) {
    this.scrollY = n;    
    if (typeof window.pageYOffset == "number") window.pageYOffset = n;
    else if (document.documentElement && document.documentElement.scrollTop)
  		document.documentElement.scrollTop = n;
  	else if (document.body && document.body.scrollTop) 
  		document.body.scrollTop = n; 
  	else if (window.scrollY) window.scrollY = n;
  },
  
  getAll: function () {
    this.getWinWidth(); this.getWinHeight();
    this.getScrollX();  this.getScrollY();
  }
  
}
