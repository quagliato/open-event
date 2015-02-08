<?php

class GenericClass {

    public function set($prop, $value) {
        if (!property_exists($this, $prop)) {
            throw new Exception("The property $prop does not exist on class $this.");
        }
        $this->$prop = $value;
    }

    public function get($prop) {
        if (!property_exists($this, $prop)) {
            throw new Exception("The property $prop does not exist on class $this.");
        }
        return $this->$prop;
    }

    public function type($prop) {
        $type_prop = "sys_type";
        if (!property_exists($this, $type_prop)) {
            throw new Exception ("The property $type_prop does not exist on class $this.");
        }

        $types = $this->$type_prop;
        if (array_key_exists($prop, $types)) {
            return $types[$prop];
        }
        return 'none';
    }

    public function props() {
        return get_object_vars($this);
    }

    public static function tablename() {
        return static::$sys_tablename;
    }
}
?>
