<?php

class StrGenerator {
    public static function generateInsert($obj) {
        $tablename = $obj->tablename();
        $array_props = $obj->props(); //recebe o array de propriedades da classe
        $sql = "INSERT INTO $tablename(";

        $added_props = array(); //array que armazenara as propriedades usadas no insert;
        foreach($array_props as $key => $val) { //itera a lista de propriedades
            if (!is_null($val) && !is_array($val) && strlen($val) > 0 && strpos($key, 'sys_') === false) {

                $sql .= "$key,"; //adiciona nome da propriedade na string
                $added_props[] = $key; //adiciona propriedade no array de propriedades adicionadas
            }
        }

        $sql = substr($sql, 0, (strlen($sql) - 1)); //remove o ultimo caracter
        $sql .= ") VALUES(";

        foreach($added_props as $key) { //itera as propriedades adicionadas
            $particle = $obj->get($key); //define a particula (valor daquela propriedade)
            if (!is_null($particle) && strlen($particle) > 0) { //verifica se o valor não é nulo
                if (in_array($obj->type($key), array('str','date'))) { //se o valor for string
                    $particle = str_replace("'", "\'", $particle);
                    $particle = "'$particle'"; //adiciona apostrofo no começo e no fim
                }

                $sql .= "$particle,"; //adiciona o valor na string
            }
        }
        $sql = substr($sql, 0, (strlen($sql) - 1)); //remove o ultimo caracter
        $sql .= ");";
        return $sql;
    }

    public static function generateSelect($classname, $fields, $where) {
        $obj = new $classname; //instancia a classe
        $tablename = $obj->tablename();
        unset($obj);

        $sql = "SELECT ";

        foreach($fields as $field) { //itera a lista de propriedades
            $sql .= "$field,"; //adiciona nome da propriedade na string
        }

        $sql = substr($sql, 0, (strlen($sql) - 1)); //remove o ultimo caracter
        $sql .= " FROM $tablename";

        if (isset($where) && !is_null($where)) { //se tiver where parametrizado, adiciona
            $sql .= " WHERE $where";
        }

        $sql .= ";";
        return $sql;
    }

    public static function generateSelectSum($classname, $field, $where) {
        $obj = new $classname; //instancia a classe
        $tablename = $obj->tablename();
        unset($obj);

        if (!isset($field) || is_null($field)) return null;

        $sql = "SELECT ";
        $sql .= "SUM($field) AS value_sum"; //adiciona nome da propriedade na string
        $sql .= " FROM $tablename";

        if (isset($where) && !is_null($where)) { //se tiver where parametrizado, adiciona
            $sql .= " WHERE $where";
        }

        $sql .= ";";
        return $sql;
    }

    public static function generateSelectCount($classname, $field, $where) {
        $obj = new $classname; //instancia a classe
        $tablename = $obj->tablename();
        unset($obj);

        if (!isset($field) || is_null($field)) return null;

        $sql = "SELECT ";
        $sql .= "COUNT($field) AS count"; //adiciona nome da propriedade na string
        $sql .= " FROM $tablename";

        if (isset($where) && !is_null($where)) { //se tiver where parametrizado, adiciona
            $sql .= " WHERE $where";
        }

        $sql .= ";";
        return $sql;
    }

    public static function generateSelectAll($classname, $where) {
        $obj = new $classname; //instancia a classe
        $tablename = $obj->tablename();
        $array_props = $obj->props(); //recebe o array de propriedades da classe
        unset($obj);

        $sql = "SELECT ";

        foreach($array_props as $key => $val) { //itera a lista de propriedades
            if (strpos($key, 'sys_') === false) {
                $sql .= "$key,"; //adiciona nome da propriedade na string
            }
        }

        $sql = substr($sql, 0, (strlen($sql) - 1)); //remove o ultimo caracter
        $sql .= " FROM $tablename";

        if (isset($where) && !is_null($where)) { //se tiver where parametrizado, adiciona
            $sql .= " WHERE $where";
        }

        $sql .= ";";
        return $sql;
    }

    public static function generateUpdate($obj, $exception_fields, $where) {
        $tablename = $obj->tablename();

        $sql = "UPDATE $tablename SET ";

        $array_props = $obj->props();
        foreach($array_props as $key => $val) { //itera a lista de propriedades
            if (!is_null($val) && !is_array($val) && strlen($val) > 0 && strpos($key, 'sys_') === false && !in_array($key,$exception_fields)) {

                $sql .= "$key = "; //adiciona nome da propriedade na string

                $particle = $obj->get($key); //define a particula (valor daquela propriedade)
                if (!is_null($particle) && strlen($particle) > 0) { //verifica se o valor não é nulo
                    if (in_array($obj->type($key), array('str','date'))) { //se o valor for string
                        $particle = str_replace("'", "\'", $particle);
                        $particle = "'$particle'"; //adiciona apostrofo no começo e no fim
                    }
                    $sql .= "$particle,"; //adiciona o valor na string
                }
            }
        }

        $sql = substr($sql, 0, (strlen($sql) - 1)); //remove o ultimo caracter

        if (isset($where) && !is_null($where)) { //se tiver where parametrizado, adiciona
            $sql .= " WHERE $where";
        }

        $sql .= ";";
        return $sql;
    }

    public static function generateUpdateWithFields($obj, $fields, $where) {
        $tablename = $obj->tablename();

        $sql = "UPDATE $tablename SET ";

        $array_props = $obj->props();
        foreach($array_props as $key => $val) { //itera a lista de propriedades
            if (!is_null($val) && !is_array($val) && strlen($val) > 0 && in_array($key, $fields)) {
                $sql .= "$key = "; //adiciona nome da propriedade na string

                $particle = $obj->get($key); //define a particula (valor daquela propriedade)
                if (!is_null($particle) && strlen($particle) > 0) { //verifica se o valor não é nulo
                    if (in_array($obj->type($key), array('str','date'))) { //se o valor for string
                        $particle = str_replace("'", "\'", $particle);
                        $particle = "'$particle'"; //adiciona apostrofo no começo e no fim
                    }
                    $sql .= "$particle,"; //adiciona o valor na string
                }
            }
        }

        $sql = substr($sql, 0, (strlen($sql) - 1)); //remove o ultimo caracter

        if (isset($where) && !is_null($where)) { //se tiver where parametrizado, adiciona
            $sql .= " WHERE $where";
        }

        $sql .= ";";
        return $sql;
    }
}
?>
