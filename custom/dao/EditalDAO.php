<?php

class EditalDAO extends GenericDAO {

    function __contruct() {
    }

    public function getOpenEdital() {
        $now = date("Y-m-d H:i:s");
        return $this->selectAll("Edital", "dt_abertura < '$now' AND dt_fechamento > '$now'");
    }
    
}
?>
