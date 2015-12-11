<?php

class Filler {

    // name......: fill
    // params....: mixed $rs, string $classname
    // desc      : This function gets the resultset ($rs) of a mysql query
    //             VO-property pattern and bind its value to a new object
    //             created using $classname.
    public static function fill($rs, $classname) {
        $array = array();

        // Creates a array of all the fields on that resultset.
        $fields = array();
        while ($field = $rs->fetch_field()) {
            $fields[] = $field->name;
        }

        while ($field_data = $rs->fetch_array()) {
            $obj = new $classname;
            // Iterate resultset columns.
            foreach ($fields as $field) {
                // Sets the value from the resultset to the property with the
                // same name.
                if (UTF8ENCODED === true) {
                    $obj->set($field, utf8_encode($field_data[$field]));
                } else {
                    $obj->set($field, $field_data[$field]);
                }
            }
            $array[] = $obj;
        }
        return $array;
    }
}
?>
