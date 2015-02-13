<?php

class EditalDAO extends GenericDAO {

    function __contruct() {
    }

    public function getOpenEdital($idEdital = false) {
        $now = date("Y-m-d H:i:s");
        $where = "dt_abertura < '$now' AND dt_fechamento > '$now'";
        if ($idEdital) {
        	$where .= " AND id = $idEdital";
        }
        return $this->selectAll("Edital", $where);
    }

    public function countAnswersPerEdital($idEdital = false) {
        if (!$idEdital) {
            $auxResult = array();
            $editais = $this->selectAll("Edital");
            foreach ($editais as $edital) {
                $countAnswers = $this->selectCount("RespostaEdital", "id", "id_edital = {$edital->get('id')}");
                $auxResult[$edital->get('id')] = $countAnswers;
            }
            return $auxResult;
        }

        if ($idEdital !== false && $idEdital !== true) {
            $idEdital = intval($idEdital);
        }
        $result = $this->selectCount("RespostaEdital", "id", "id_edital = $idEdital");
    }
}
?>
