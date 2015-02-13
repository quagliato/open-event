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

    public function maxOrdemExibicaoByEdital($idEdital) {
        if (!isset($idEdital) || !$idEdital) {
            return 1;
        }

        $respostasPegunta = $this->selectAll("Pergunta", "id_edital = $idEdital ORDER BY ordem_exibicao DESC");
        if ($respostasPegunta) {
            if (!is_array($respostasPegunta)) {
                return $respostasPegunta->get('ordem_exibicao') + 1;
            }
            return $respostasPegunta[0]->get('ordem_exibicao') + 1;
        }

        return 1;
    }
}
?>
