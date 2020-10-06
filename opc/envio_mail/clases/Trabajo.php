<?php

class Trabajo
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getTrabajosMail(){
        return $this->_bd->query("SELECT * FROM trabajos_libres WHERE contacto_mail IS NOT NULL AND contacto_mail<>'' ORDER BY numero_tl")->results();//AND id_crono<>'0' AND estado<>'3'
    }
    public function getTrabajosMailByIDS($ids_trabajos){
        $txt_trabajo = "";
        if(count($ids_trabajos) > 0){
            foreach($ids_trabajos as $id_trabajo){
                $txt_trabajo .= $id_trabajo.", ";
            }
            $txt_trabajo = substr($txt_trabajo, 0, -2);
            return $this->_bd->query("SELECT * FROM trabajos_libres WHERE contacto_mail IS NOT NULL AND contacto_mail<>'' AND id_trabajo IN (".$txt_trabajo.") ORDER BY numero_tl")->results();
        }
    }

    public function getTrabajoByID($id_trabajo){
        return $this->_bd->get("trabajos_libres", ["id_trabajo", "=", $id_trabajo])->first();
    }

    public function getAutoresByTrabajoID($id_trabajo){
        return $this->_bd->query("SELECT p.Nombre, p.Apellidos, p.Institucion, p.Institucion_otro, p.Pais, p.inscripto, tp.lee FROM trabajos_libres t JOIN trabajos_libres_participantes tp ON t.id_trabajo=tp.ID_trabajos_libres JOIN personas_trabajos_libres p ON tp.ID_participante=p.ID_Personas WHERE t.id_trabajo = ?", [$id_trabajo])->results();
    }

    public function getInstitucionByID($id_institucion){
        return $this->_bd->get("instituciones", ["ID_Instituciones", "=", $id_institucion])->first();
    }

    public function getPaisByID($id_pais){
        return $this->_bd->get("paises", ["ID_Paises", "=", $id_pais])->first();
    }

    public function getTemplateAutores($id_trabajo){
        $txt = "";
        $autores = $this->getAutoresByTrabajoID($id_trabajo);
        $instituciones_autores = array();
        $key = 1;
        foreach($autores as $autor){
            $aster = "";
            if($autor["lee"] == 1){
                $aster = "(*)";
            }
            $txt .= $autor["Nombre"]." ".$autor["Apellidos"]." <sup>".$key.$aster."</sup>; ";
            if(!array_key_exists($autor["Institucion"], $instituciones_autores)){
                if($autor["Institucion"] == "Otra"){
                    $instituciones_autores[$autor["Institucion_otro"]] = ["id" => $autor["Institucion_otro"], "key" => $key,
                        "presentador" => $autor["lee"], "pais_autor" => $autor["Pais"]];
                } else {
                    $instituciones_autores[$autor["Institucion"]] = ["id" => $autor["Institucion"], "key" => $key, "presentador" => $autor["lee"], "pais_autor" => $autor["Pais"]];
                }
                $key++;
            }
        }
        $txt = substr($txt, 0, -2);
        $txt .= "<br>";
        foreach($instituciones_autores as $institucion_autor){
            $institucion = $this->getInstitucionByID($institucion_autor["id"]);
            $txt .= $institucion_autor["key"]." - ".$institucion["Institucion"];
            if($institucion_autor["presentador"] == 1){
                $pais_autor = $this->getPaisByID($institucion_autor["pais_autor"]);
                $txt .= " | (*) ".$pais_autor["Pais"];
            }
            $txt .= ". ";
        }
        return $txt;
    }

    public function getTrabajosByCronoID($id_crono){
        return $this->_bd->query("SELECT id_trabajo, titulo_tl, numero_tl, resumen FROM trabajos_libres WHERE id_crono = ? ORDER BY orden, numero_tl", [$id_crono])->results();
    }

    public function getEvaluacionesByNumeroTL($numero_tl){
        return $this->_bd->get("evaluaciones", ["numero_tl", "=", $numero_tl])->results();
    }
}