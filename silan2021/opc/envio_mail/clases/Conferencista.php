<?php

class Conferencista
{
    private $_bd;
    public function __construct()
    {
        $this->_bd = \DB::getInstance();
    }

    public function getConferencistasConMail(){
        return $this->_bd->query("SELECT * FROM conferencistas WHERE email IS NOT NULL AND email<>'' ORDER BY apellido, nombre, email")->results();
    }

    public function getConferencistaByID($id_conf){
        return $this->_bd->get("conferencistas", ["id_conf", "=", $id_conf])->first();
    }

    public function getCronoByConfID($id_conf){
        return $this->_bd->query("SELECT c.id_crono, c.start_date, c.end_date, c.section_id, c.tipo_actividad, c.titulo_actividad, s.name FROM cronograma c JOIN salas s ON c.section_id=s.salaid JOIN crono_conferencistas cc ON c.id_crono=cc.id_crono WHERE cc.id_conf = ? ORDER BY SUBSTRING(c.start_date,1,10), s.orden, SUBSTRING(c.start_date,12,5)", [$id_conf])->results();
    }

    public function getRolesConf($id_conf){
        $ids_roles = array();
        $cronos_confs = $this->_bd->query("SELECT en_calidad FROM crono_conferencistas WHERE id_conf = ?", [$id_conf])->results();
        if(count($cronos_confs) > 0){
            foreach($cronos_confs as $cc){
                $ids_roles[] = $cc["en_calidad"];
            }
        }
        return $ids_roles;
    }

    //TEMPLATE
    public function programaExtendidoMail($crono, $dia_, $sala_, $helper, $trabajos = false)
    {
        date_default_timezone_set("America/Montevideo");
        setlocale(LC_TIME, 'es_ES');
        $html = "";
        $dia_inicio = substr($crono["start_date"], 0, 10);
        if($dia_inicio != $dia_ || $crono['section_id'] != $sala_):
            //CONTAINER DATA END
            if($helper!=0){
                $html .= "</div>";
            }
        endif;

        //CONTAINER DIA SALA
        $html .= "<div class='extendido_container_dia_sala'>";
        //DIA
        if($dia_inicio != $dia_):
            //CONTAINER DATA
            //%A %d de %B %Y
            $html .=  "<br><span class='extendido_dia_sala'><strong>".ucfirst(utf8_encode(strftime("%A %d de %B",strtotime($dia_inicio))))."</strong></span>".PHP_EOL;
        endif;
        //SALA
        if($dia_inicio != $dia_ || $crono['section_id'] != $sala_):
            if($dia_inicio == $dia_ && $crono['section_id'] != $sala_)
                $html .= '<br>';
            else
                $html .= ' - ';
            $html .=  "<span class='extendido_dia_sala'><strong>".$crono["name"]."</strong></span>";
        endif;
        //CONTAINER DIA SALA END
        $html .= "</div>";

        if($dia_inicio == $dia_ && ($helper != 0) && ($dia_inicio == $dia_ && ($crono['section_id'] == $sala_)))
            $html .= '<br>';

        if(($dia_inicio != $dia_) || ($crono['section_id'] != $sala_)):
            $html .= "<div class='clear'></div>";
            //CONTAINER DATA
            $html .= "<div class='container_data'>";
        endif;

        //HORA / TIPO ACTIVIDAD
        //
        $tipo_actividad = $this->_bd->get("tipo_de_actividad", ["id_tipo_actividad", "=", $crono["tipo_actividad"]])->first();

        $html .=  "<div class='extendido_hora_actividad' style='border-top: 4px solid ".$tipo_actividad["color_actividad"]."; padding: 2px;'>";
        $html .= "<span>";
        $hora_inicio = substr($crono["start_date"],-8,-3);
        $hora_fin = substr($crono["end_date"],-8,-3);
        $html .= $hora_inicio." - ".$hora_fin;
        $html .= "</span>";
        if($tipo_actividad["tipo_actividad"])
            $html .=  " <i>".$tipo_actividad["tipo_actividad"]."</i>";
        if($crono["titulo_actividad"])
            $html .= " - <b>".$crono["titulo_actividad"]."</b>";
        $html .=  "</div>";
        //CONFERENCISTAS
        $getCronoConf = $this->_bd->get("crono_conferencistas", ["id_crono", "=", $crono["id_crono"]])->results();
        foreach($getCronoConf as $cronoConf):
            $html .= $this->templateConfTXTMail($cronoConf);
        endforeach;
        //TRABAJOS LIBRES
        /*if($trabajos){
            $getCronoTL = $this->_bd->get("trabajos_libres", ["id_crono", "=", $crono["id_crono"]])->results();
            foreach($getCronoTL as $cronoTL):
                $html .= $this->templateTlTXT($cronoTL, $tipo_actividad["color_actividad"], true);
            endforeach;
        }*/
        $html .= "<div class='clear'></div>";
//		$html .= "<div class='casillero_pie titulo_conf'>".$crono["casillero_pie"]."</div>";
        return $html;
    }

    public function templateConfTXTMail($data)
    {
        $getConf = $this->_bd->get("conferencistas", ["id_conf", "=", $data["id_conf"]])->first();
        $getRol = $this->_bd->get("calidades_conferencistas", ["ID_calidad", "=", $data["en_calidad"]])->first();
        $txt = "";
        if($data["titulo_conf"])
            $txt .= "<div class='titulo_conf'><strong>".$data["titulo_conf"]."</strong></div>";
        if($this->hiddenConf($getConf["nombre"], $getConf["apellido"]))
        {
            $txt .= "<div style='margin-left:15px'>";
            if($getRol["calidad"])
                $txt .= $getRol["calidad"].": ";
            $txt .= "".$getConf["profesion"]." ".$getConf["nombre"]." ".$getConf["apellido"];
            if($getConf["institucion"]){
                $institucion = $this->_bd->get("instituciones", ["ID_Instituciones", "=", $getConf["institucion"]])->first();
                $txt .= " <i> - ".$institucion["Institucion"]."</i>";
            }
            if($getConf["pais"] && $getConf["pais"]!=247){
                $pais = $this->_bd->get("paises", ["ID_Paises", "=", $getConf["pais"]])->first();
                $txt .= " <i>(".$pais["Pais"].")</i>";
            }
            $txt .= "</div>";
        }
        return $txt;
    }

    public function hiddenConf($nombre, $apellido){
        if(($nombre=="sin" && $apellido=="nombre") || ($nombre=="nombre" && $apellido=="sin"))
            return false;
        if($_SESSION["admin"] && $nombre=="a" && $apellido=="definir")
            return true;
        else if(!$_SESSION["admin"] && $nombre=="a" && $apellido=="definir")
            return false;

        return true;
    }
}