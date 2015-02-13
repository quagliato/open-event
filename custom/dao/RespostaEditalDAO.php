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
}
?>
