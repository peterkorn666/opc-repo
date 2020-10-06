
function mostrarPanelAyuda(e, msg) {
  if ( typeof pnlAyuda == "undefined" || !pnlAyuda.ready ) return;
  pnlAyuda.show(e, msg);
}

function ocultarPanelAyuda() {
  if ( typeof pnlAyuda == "undefined" || !pnlAyuda.ready ) return;
  pnlAyuda.hide();
}

var pnlAyuda = {
    followMouse: true,
    offX: 8,
    offY: 12,
    tipID: "pnlAyudaDiv",
    showDelay: 50,
    hideDelay: 100,
	ready:false,
	timer:null,
	tip:null,
	visible:false,
	init:function(){if(document.createElement&&document.body&&typeof document.body.appendChild!="undefined"){if(!document.getElementById(this.tipID)){var el=document.createElement("DIV");el.id=this.tipID;document.body.appendChild(el);}this.ready=true;};},
	show:function(e,msg){if(this.timer){clearTimeout(this.timer);this.timer=0;}this.tip=document.getElementById(this.tipID);if(this.followMouse)dw_event.add(document,"mousemove",this.trackMouse,true);this.writeTip("");this.writeTip(msg);viewport.getAll();this.positionTip(e);this.timer=setTimeout("pnlAyuda.toggleVis('"+this.tipID+"', 'visible')",this.showDelay);this.visible=true;},
	writeTip:function(msg){if(this.tip&&typeof this.tip.innerHTML!="undefined")this.tip.innerHTML=msg;},
	positionTip:function(e){if(this.tip&&this.tip.style){var x=e.pageX?e.pageX:e.clientX+viewport.scrollX;var y=e.pageY?e.pageY:e.clientY+viewport.scrollY;if(x+this.tip.offsetWidth+this.offX>viewport.width+viewport.scrollX){x=x-this.tip.offsetWidth-this.offX;if(x<0)x=0;}else x=x+this.offX;if(y+this.tip.offsetHeight+this.offY>viewport.height+viewport.scrollY){y=y-this.tip.offsetHeight-this.offY;if(y<viewport.scrollY)y=viewport.height+viewport.scrollY-this.tip.offsetHeight;}else y=y+this.offY;this.tip.style.left=x+"px";this.tip.style.top=y+"px";}},
	hide:function(){if(this.timer){clearTimeout(this.timer);this.timer=0;}this.timer=setTimeout("pnlAyuda.toggleVis('"+this.tipID+"', 'hidden')",this.hideDelay);if(this.followMouse)dw_event.remove(document,"mousemove",this.trackMouse,true);this.tip=null;this.visible=false;},
	toggleVis:function(id,vis){var el=document.getElementById(id);if(el)el.style.visibility=vis;},
	trackMouse:function(e){e=dw_event.DOMit(e);pnlAyuda.positionTip(e);}
};


function mostrarPanelAvisos(msg) {
  if ( typeof pnlAvisos == "undefined" || !pnlAvisos.ready ) return;
  pnl="<a href='#' onClick='ocultarPanelAvisos();return false;'><p align='right'><b>Cerrar [X]</b></a></p>";
  pnlAvisos.show(pnl + msg);
}

function ocultarPanelAvisos() {
  if ( typeof pnlAvisos == "undefined" || !pnlAvisos.ready ) return;
  pnlAvisos.hide();
}

var pnlAvisos = {
    followMouse: true,
    offX: 8,
    offY: 12,
    tipID: "pnlAvisosDiv",
    showDelay: 50,
    hideDelay: 100,
	ready:false,
	timer:null,
	tip:null,
	visible:false,
	init:function(){if(document.createElement&&document.body&&typeof document.body.appendChild!="undefined"){if(!document.getElementById(this.tipID)){var el=document.createElement("DIV");el.id=this.tipID;document.body.appendChild(el);}this.ready=true;};},
	show:function(msg){if(this.timer){clearTimeout(this.timer);this.timer=0;}this.tip=document.getElementById(this.tipID);if(this.followMouse)dw_event.add(window,"scroll",this.trackMouse,true);this.writeTip("");this.writeTip(msg);viewport.getAll();this.positionTip();this.timer=setTimeout("pnlAvisos.toggleVis('"+this.tipID+"', 'visible')",this.showDelay);this.visible=true;},
	writeTip:function(msg){if(this.tip&&typeof this.tip.innerHTML!="undefined")this.tip.innerHTML=msg;},
	positionTip:function(){	
		if(this.tip&&this.tip.style){		
			viewport.getScrollY();
			y=viewport.scrollY;
			x=viewport.width-this.tip.offsetWidth;
			this.tip.style.left=x+"px";
			this.tip.style.top=y+"px";
		}
	},
	hide:function(){if(this.timer){clearTimeout(this.timer);this.timer=0;}this.timer=setTimeout("pnlAvisos.toggleVis('"+this.tipID+"', 'hidden')",this.hideDelay);if(this.followMouse)dw_event.remove(window,"scroll",this.trackMouse,true);this.tip=null;this.visible=false;},
	toggleVis:function(id,vis){var el=document.getElementById(id);if(el)el.style.visibility=vis;},
	trackMouse:function(e){e=dw_event.DOMit(e);pnlAvisos.positionTip(e);}
};



function mostrarPanelOtrasAyudas(msg) {
  if ( typeof pnlOtrasAyudas == "undefined" || !pnlOtrasAyudas.ready ) return;
  pnl="<a href='#' onClick='ocultarPanelOtrasAyudas();return false;'><p align='right'><b>Cerrar [X]</b></a></p>";
  pnlOtrasAyudas.show(pnl + msg);
}

function ocultarPanelOtrasAyudas() {
  if ( typeof pnlOtrasAyudas == "undefined" || !pnlOtrasAyudas.ready ) return;
  pnlOtrasAyudas.hide();
}

var pnlOtrasAyudas = {
    followMouse: true,
    offX: 8,
    offY: 12,
    tipID: "pnlOtrasAyudasDiv",
    showDelay: 50,
    hideDelay: 100,
	ready:false,
	timer:null,
	tip:null,
	visible:false,
	init:function(){if(document.createElement&&document.body&&typeof document.body.appendChild!="undefined"){if(!document.getElementById(this.tipID)){var el=document.createElement("DIV");el.id=this.tipID;document.body.appendChild(el);}this.ready=true;};},
	show:function(msg){if(this.timer){clearTimeout(this.timer);this.timer=0;}this.tip=document.getElementById(this.tipID);if(this.followMouse)dw_event.add(window,"scroll",this.trackMouse,true);this.writeTip("");this.writeTip(msg);viewport.getAll();this.positionTip();this.timer=setTimeout("pnlOtrasAyudas.toggleVis('"+this.tipID+"', 'visible')",this.showDelay);this.visible=true;},
	writeTip:function(msg){if(this.tip&&typeof this.tip.innerHTML!="undefined")this.tip.innerHTML=msg;},
	positionTip:function(){	
		if(this.tip&&this.tip.style){		
			viewport.getScrollY();						
			y=viewport.height+viewport.scrollY-this.tip.offsetHeight;
			//alert(viewport.height + " + " + viewport.scrollY  + "  - " + this.tip.offsetHeight + " = " + y);
			x=viewport.width-this.tip.offsetWidth;
			this.tip.style.left=x+"px";
			this.tip.style.top=y+"px";
		}
	},
	hide:function(){if(this.timer){clearTimeout(this.timer);this.timer=0;}this.timer=setTimeout("pnlOtrasAyudas.toggleVis('"+this.tipID+"', 'hidden')",this.hideDelay);if(this.followMouse)dw_event.remove(window,"scroll",this.trackMouse,true);this.tip=null;this.visible=false;},
	toggleVis:function(id,vis){var el=document.getElementById(id);if(el)el.style.visibility=vis;},
	trackMouse:function(e){e=dw_event.DOMit(e);pnlOtrasAyudas.positionTip(e);}
};

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

var dw_event = {
  
  add: function(obj, etype, fp, cap) {
    cap = cap || false;
    if (obj.addEventListener) obj.addEventListener(etype, fp, cap);
    else if (obj.attachEvent) r=obj.attachEvent("on" + etype, fp);
  }, 

  remove: function(obj, etype, fp, cap) {
    cap = cap || false;
    if (obj.removeEventListener) obj.removeEventListener(etype, fp, cap);
    else if (obj.detachEvent) obj.detachEvent("on" + etype, fp);
  }, 

  DOMit: function(e) { 
    e = e? e: window.event;
    e.tgt = e.srcElement? e.srcElement: e.target;
    
    if (!e.preventDefault) e.preventDefault = function () { return false; }
    if (!e.stopPropagation) e.stopPropagation = function () { if (window.event) window.event.cancelBubble = true; }
        
    return e;
  }
  
}


function s() {
	alert("scroll");
}