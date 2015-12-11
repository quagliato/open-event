<?php

class UserDAO extends GenericDAO {

    function __contruct() {
    }

    public function getUserByEmail($email) {
        if (is_null($email) || !isset($email)) return false;
        $obj = $this->selectAll("User","email = '$email'");
        return $obj;
    }

    public function getUserByCPF($cpf) {
        if (is_null($cpf) || !isset($cpf)) return false;
        $obj = $this->selectAll("User","cpf= '$cpf'");
        if (is_array($obj)) return false;
        return $obj;
    }

    public function getUserById($id) {
        if (is_null($id) || !isset($id)) return false;
        $obj = $this->selectAll("User","id= $id");
        if (is_array($obj)) return false;
        return $obj;
    }

}
?>
