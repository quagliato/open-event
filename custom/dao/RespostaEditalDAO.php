<?php

class RespostaEditalDAO extends GenericDAO {

    function __contruct() {
    }

    public function hasAnsweredEdital($idUser, $idEdital) {
        if (!isset($idUser) || !$idUser || !isset($idEdital) || !$idEdital) {
            return false;
        }

        $editais = $this->selectAll("RespostaEdital", "id_user = $idUser AND id_edital = $idEdital");
        if ($editais) {
            if (is_array($editais)) return $editais[sizeof($editais) - 1];
            else return $editais;
        }

        return false;
    }

    public function getAverageTime($idEdital) {
        if (!isset($idEdital) || !$idEdital) {
            return false;
        }

        $answeringCount = 1;
        $answeringTime = 0;
        $respostasEdital = $this->selectAll("RespostaEdital", "id_edital = $idEdital");
        if ($respostasEdital) {
            if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);

            foreach ($respostasEdital as $respostaEdital) {
                $begin = new DateTime($respostaEdital->get('dt_inicio_resposta'));
                $end = new DateTime($respostaEdital->get('dt_fim_resposta'));

                $diff = $end->diff($begin);
                if (intval($diff->format("%h")) > 1) $answeringTime += intval($diff->format("%h") * 60;
                $answeringTime += intval($diff->format("%i"));

                $answeringCount++;
            }
        }

        return intval($answeringTime / $answeringCount);
    }
}
?>
