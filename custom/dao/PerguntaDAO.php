<?php

class PerguntaDAO extends GenericDAO {

    function __contruct() {
    }

    public function getPerguntaById($idPergunta) {
        return $this->selectAll("Pergunta", "id = $idPergunta");
    }

    public function getPerguntaByEdital($idEdital) {
        if (!isset($idEdital) || is_null($idEdital) || $idEdital == "") {
            return false;
        }

        if (!$this->selectAll("Edital", NULL)) {
            return false;
        }

        return $this->selectAll("Pergunta", "id_edital = $idEdital ORDER BY ordem_exibicao");
    }
    
}
?>
