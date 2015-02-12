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
}
?>
