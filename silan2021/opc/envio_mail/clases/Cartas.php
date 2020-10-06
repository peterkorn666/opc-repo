<?php

class Cartas
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    //SELECT
        public function getConfig(){
            return $this->_bd->get("config", ["id", "=", 1])->first();
        }

        public function getCartaByID($idCarta){
            return $this->_bd->get("cartas", ["idCarta", "=", $idCarta])->first();
        }

        public function getCartas(){
            return $this->_bd->query("SELECT * FROM cartas ORDER BY idCarta")->results();
        }
        public function getCartasContactosTrabajo(){
            return $this->_bd->query("SELECT * FROM cartas WHERE destinatarios = 1 ORDER BY idCarta")->results();
        }
        public function getCartasAutoresTrabajos(){
            return $this->_bd->query("SELECT * FROM cartas WHERE destinatarios = 2 ORDER BY idCarta")->results();
        }
        public function getCartasConferencistas(){
            return $this->_bd->query("SELECT * FROM cartas WHERE destinatarios = 3 ORDER BY idCarta")->results();
        }
        public function getCartasInscriptos(){
            return $this->_bd->query("SELECT * FROM cartas WHERE destinatarios = 4 ORDER BY idCarta")->results();
        }
        public function getCartasEvaluadores(){
            return $this->_bd->query("SELECT * FROM cartas WHERE destinatarios = 5 ORDER BY idCarta")->results();
        }

        public function getCartasDestinatarios(){
            return $this->_bd->query("SELECT * FROM cartas_destinatarios WHERE enabled = 1 ORDER BY orden")->results();
        }
        public function getDestinatariosByID($id_destinatario){
            return $this->_bd->get("cartas_destinatarios", ["id_destinatario", "=", $id_destinatario])->first();
        }

    //INSERT
        public function crearCarta($campos){
            return $this->_bd->insert("cartas", $campos);
        }

        public function insertCartaEnviada($campos){
            $result = $this->_bd->insert("cartas_enviadas", $campos);
            if($result){
                return $this->_bd->lastID();
            } else {
                return $result;
            }
        }
        public function insertCartaEnviadaPersonas($campos){
            return $this->_bd->insert("cartas_enviadas_personas", $campos);
        }

    //EDIT
        public function editarCarta($id_carta, $campos){
            return $this->_bd->update("cartas", "idCarta = ".$id_carta, $campos);
        }

    //DELETE
        public function eliminarCarta($id_carta){
            return $this->_bd->delete("cartas", ["idCarta", "=", $id_carta]);
        }
}