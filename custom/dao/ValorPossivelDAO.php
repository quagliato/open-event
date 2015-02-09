<?php

class ValorPossivelDAO extends GenericDAO {

    function __contruct() {
    }

    public function getValorPossivelByPergunta($idPergunta) {
        if (!isset($idPergunta) || is_null($idPergunta) || $idPergunta == "") {
            return false;
        }

        if (!$this->selectAll("Pergunta", NULL)) {
            return false;
        }

        return $this->selectAll("ValorPossivel", "id_pergunta = $idPergunta");
    }

    public function getEditalPergunta($idValorPossivel) {
        $valorPossivel = $this->selectAll("ValorPossivel", "id = $idValorPossivel");

        if ($valorPossivel) {
            $pergunta = $this->selectAll("Pergunta", "id = ".$valorPossivel->get('id_pergunta'));
            if ($pergunta) {
                $edital = $this->selectAll("Edital", "id = ".$pergunta->get('id_edital'));
                if ($edital) {
                    return $edital->get('id')." - ".$edital->get('nome')." / ".$pergunta->get('id')." - ".$pergunta->get('titulo');
                }
            }
        }
        return false;
    }

    public function getHigherValue($idPergunta) {
        $higherValue = $this->selectAll("ValorPossivel", "id_pergunta = $idPergunta ORDER BY valor DESC LIMIT 1");
        if ($higherValue && is_array($higherValue)) {
            return $higherValue[0]->get('valor');
        }
        return $higherValue->get('valor');
    }

    public function getLowestValue($idPergunta) {
        $lowestValue = $this->selectAll("ValorPossivel", "id_pergunta = $idPergunta ORDER BY valor LIMIT 1");
        if ($lowestValue && is_array($lowestValue)) {
            return $lowestValue[0]->get('valor');
        }
        return $lowestValue->get('valor');
    }

    public function getValorPossivel($idValorPossivel) {
        return $this->selectAll("ValorPossivel", "id = $idValorPossivel");
    }
}
?>
