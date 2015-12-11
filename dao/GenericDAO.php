<?php

class GenericDAO {

    public function insert($obj) {
        if (!isset($obj) ||
            is_null($obj) ||
            !is_object($obj)) { //verifica se os valores foram inseridos
            return false;
        }

        $db = new DBStuff; //instancia a classe de conexao

        //chama o StrGenerator pra criar a string de insert;
        $sql = StrGenerator::generateInsert($obj);

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        if (!$db->execute($sql)) { //executa o SQL e testa o retorno
            return false;
        }
        return true;
    }

    public function select($classname, $fields, $where) {
            if (!isset($classname) ||
            is_null($classname) ||
            !isset($fields) ||
            is_null($fields)) { //verifica se os valores foram inseridos
            return false;
        }

        $db = new DBStuff; //instancia a classe de conexao

        //chama o StrGenerator pra criar a string de insert;
        $sql = StrGenerator::generateSelect($classname, $fields, $where);

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        $rs = $db->execute($sql); //executa a string

        if ($rs) { //se nao der erro
            //chama o filler pra popular os objetos com o resultado
            //do resultset
            $array = Filler::fill($rs, $classname);
            if (sizeof($array) == 1) { //se tiver apenas um objeto
                return $array[0]; //retorna ele
            }
            return $array; //senao retorna o array mesmo
        }
        return false; //se der algum erro, retorna falso
    }

    public function selectSum($classname, $field, $where) {
            if (!isset($classname) ||
            is_null($classname) ||
            !isset($field) ||
            is_null($field)) { //verifica se os valores foram inseridos
            return false;
        }

        $db = new DBStuff; //instancia a classe de conexao

        //chama o StrGenerator pra criar a string de insert;
        $sql = StrGenerator::generateSelectSum($classname, $field, $where);

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        $rs = $db->execute($sql); //executa a string

        if ($rs) { //se nao der erro
            $row = $rs->fetch_row(); //pega a linha
            return $row[0]; //retorna a soma
        }
        return false; //se der algum erro, retorna falso
    }

    public function selectCount($classname, $field, $where) {
            if (!isset($classname) ||
            is_null($classname) ||
            !isset($field) ||
            is_null($field)) { //verifica se os valores foram inseridos
            return false;
        }

        $db = new DBStuff; //instancia a classe de conexao

        //chama o StrGenerator pra criar a string de insert;
        $sql = StrGenerator::generateSelectCount($classname, $field, $where);

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        $rs = $db->execute($sql); //executa a string

        if ($rs) { //se nao der erro
            $row = $rs->fetch_row(); //pega a linha
            return $row[0]; //retorna a soma
        }
        return false; //se der algum erro, retorna falso
    }

    public function selectAll($classname, $where) {
        if (!isset($classname) ||
            is_null($classname)) { //verifica se os valores foram inseridos
            return false;
        }

        $db = new DBStuff; //instancia a classe de conexao

        //chama o StrGenerator pra criar a string de insert;
        $sql = StrGenerator::generateSelectAll($classname, $where);

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        $rs = $db->execute($sql); //executa a string

        if ($rs) { //se nao der erro
            //chama o filler pra popular os objetos com o resultado
            //do resultset
            $array = Filler::fill($rs, $classname);
            if (sizeof($array) == 1) { //se tiver apenas um objeto
                return $array[0]; //retorna ele
            }
            return $array; //senao retorna o array mesmo
        }
        return false; //se der algum erro, retorna falso
    }

    public function update($obj, $exception_fields, $where) {
        if (!isset($obj) ||
            is_null($obj) ||
            !is_object($obj)) { //verifica se os valores foram inseridos
            return false;
        }

        if (is_null($exception_fields) || !is_array($exception_fields)) $exception_fields = array();

        $db = new DBStuff; //instancia a classe de conexao

        //chama o StrGenerator pra criar a string de insert;
        $sql = StrGenerator::generateUpdate($obj, $exception_fields, $where);

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        if (!$db->execute($sql)) { //executa o SQL e testa o retorno
            return false;
        }
        return true;
    }

    public function updateWithFields($obj, $fields, $where) {
        if (!isset($obj) ||
            is_null($obj) ||
            !is_object($obj) ||
            is_null($fields) ||
            !is_array($fields)) { //verifica se os valores foram inseridos
            return false;
        }

        $db = new DBStuff; //instancia a classe de conexao

        //chama o StrGenerator pra criar a string de insert;
        $sql = StrGenerator::generateUpdateWithFields($obj, $fields, $where);

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        if (!$db->execute($sql)) { //executa o SQL e testa o retorno
            return false;
        }
        return true;
    }

    public function delete($classname, $where) {
        if (!isset($classname) || is_null($classname)) { //verifica se os valores foram inseridos
            return false;
        }

        $db = new DBStuff; //instancia a classe de conexao
        $obj = new $classname;

        $sql = "DELETE FROM ".$obj->tablename();

        if (!is_null($where) && $where != "") {
            $sql .= " WHERE ".$where;
        }

        if (!isset($sql) || is_null($sql)) { //verifica se a string foi criada
            return false;
        }

        $rs = $db->execute($sql); //executa a string

        if ($rs) { //se nao der erro
            return true;
        }
        return false; //se der algum erro, retorna falso
    }
}
?>
