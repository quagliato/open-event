<?php

class RespostaEditalStatusDAO extends GenericDAO {

    function __contruct() {
    }

    public function getLastStatus($status = false) {
        $where = "1=1";
        if ($status) {
            $where = "status = $status";
        }
        $where .= " ORDER BY dt_update DESC";
        $result = $this->selectAll('RespostaEditalStatus', $where);
        if ($result) {
            if (is_array($result)) $result = $result[0];
        }

        return $result;
    }
}
?>
