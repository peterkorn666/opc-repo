<?php
class Inscripcion{
	private $_bd, $_render, $_id_cliente;
    public function __construct()
    {
        $this->_bd = DB::getInstance();
		
    }
	
	public function getConfig(){
		return $this->_bd->get("config",["id","=",1])->first();
	}
	
	public function litado(){
		return $this->_bd->query("SELECT * FROM inscriptos ORDER BY id DESC")->results();
	}
	
	public function listadoInscriptos(){
		return $this->_bd->query("SELECT * FROM inscriptos ORDER BY id ASC")->results();
	}
	
	public function get($id)
	{
		return $this->_bd->get("inscriptos",["id","=",$id])->first();
	}
	
	public function getRecibos($id_inscripto)
	{
		return $this->_bd->get("inscriptos_recibo", ["id_inscripto","=", $id_inscripto])->results();
	}

	
	public function getRecibo($id)
	{
		return $this->_bd->get("inscriptos_recibo",["id","=",$id])->first();
	}
	
	public function obtenerDocRecibos()
	{
		return $this->_bd->query("SELECT documento FROM inscriptos_recibo ORDER BY id ASC LIMIT 5")->results();
	}
	
	public function getPais($id)
	{
		return $this->_bd->get("paises",["ID_Paises","=",$id])->first();
	}
	
	public function estaPago($id_inscripto)
	{
		$pago = $this->_bd->query("SELECT id FROM inscriptos_recibos_pagos WHERE id_inscripto=?", [$id_inscripto])->first();
		return (count($pago) > 0);
	}
	
	public function getPagosAprobadosInscripto($id_inscripto)
	{
		return $this->_bd->query("SELECT * FROM inscriptos_recibo WHERE pago=1 AND id_inscripto=?", [$id_inscripto])->results();
	}
	
	public function getMontoInscripto($id_inscripto){
		$recibos_aprobados = $this->getPagosAprobadosInscripto($id_inscripto);
		$monto = 0;
		foreach($recibos_aprobados as $recibo_aprobado){
			$importe_recibo = str_replace(",",".",$recibo_aprobado["importe"]);
			$descuento_recibo = str_replace(",",".",$recibo_aprobado["descuento"]);
			$valor_recibo = round($importe_recibo-$descuento_recibo, 2);
			$monto = round($monto + $valor_recibo, 2);
		}
		return $monto;
	}
	
	//Inscripción general
	public function getPrecios() {
		return $this->_bd->query("SELECT * FROM inscripcion_costos")->results();
	}
	
	public function getPreciosHabilitados() {
		return $this->_bd->query("SELECT * FROM inscripcion_costos WHERE habilitado=1")->results();
	}
	
	public function getOpcionPrecioByID($id_precio) {
		return $this->_bd->get("inscripcion_costos", ["id", "=", $id_precio])->first();
	}
	
	//Formas de pago
	public function getFormasPago() {
		return $this->_bd->query("SELECT * FROM inscripcion_formas_pago")->results();
	}
	
	public function getFormasPagoHabilitadas() {
		return $this->_bd->query("SELECT * FROM inscripcion_formas_pago WHERE habilitado=1")->results();
	}
	
	public function getOpcionFormaPagoByID($id_forma_pago) {
		return $this->_bd->get("inscripcion_formas_pago", ["id", "=", $id_forma_pago])->first();
	}
	
	public function esBeca($id_costo) {
		$es_beca = false;
		$result = $this->_bd->query("SELECT id, nombre FROM inscripcion_costos WHERE id=?", [$id_costo])->first();
		if(count($result) > 0){
			if($result["nombre"] === 'Beca'){
				$es_beca = true;
			}
		}
		return $es_beca;
	}
	
	public function esFormaPagoConComprobante($id_forma_pago) {
		$tiene_comprobante = false;
		$result = $this->_bd->query("SELECT id, lleva_comprobante FROM inscripcion_formas_pago WHERE id=?", [$id_forma_pago])->first();
		if(count($result) > 0) {
			if($result["lleva_comprobante"] == 1){
				$tiene_comprobante = true;
			}
		}
		return $tiene_comprobante;
	}
	
	public function calcularPrecio($id_inscripto) {
		
		$precio_costo_congreso = 0;
		$inscripto = $this->getInscripto($id_inscripto);
		if(count($inscripto) > 0){
			if($inscripto["costos_inscripcion"] != NULL){
				$rowCostoInscripcion = $this->getOpcionPrecioByID($inscripto["costos_inscripcion"]);
				$precio_costo_congreso = (int)$rowCostoInscripcion["precio"];
			}
		}
		return $precio_costo_congreso;
	}
}