<?php

class Filler {

    // name......: fill
    // params....: mixed $rs, string $classname
    // desc      : This function gets the resultset ($rs) of a mysql query
    //             VO-property pattern and bind its value to a new object
    //             created using $classname.
    public static function fill($rs, $classname) {
        $array = array();

        while ($field_data = mysql_fetch_array($rs)) { 
            $obj = new $classname;
            // Iterate resultset columns.
            for ($i = 0; $i < mysql_num_fields($rs); $i++) {
                // Gets the name of the column.
                $field = mysql_fetch_field($rs, $i);
                
                // Sets the value from the resultset to the property with the
                // same name.
                $obj->set($field->name,$field_data[$field->name]);
            }
            $array[] = $obj;
        }
        return $array;
    }
}
?>
