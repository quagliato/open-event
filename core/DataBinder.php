<?php

class DataBinder {

    // name......: bind
    // params....: array $__POST, string $classname
    // desc      : This function gets $__POST ($_POST) content searching for
    //             VO-property pattern and bind its value to a new objected
    //             created using $classname.
    public static function bind($__POST, $classname) {
        $obj = new $classname;
        $obj_props = $obj->props();

        foreach ($__POST as $key => $value) {

            $dashpos = strpos($key, '-');
            $keylen = strlen($key);

            if ($dashpos > -1) {

                $obj_name = substr($key, 0, $dashpos);
                $prop_name = substr($key, $dashpos + 1, $keylen - $dashpos);

                if ($obj_name == $classname && array_key_exists($prop_name, $obj_props)) {
                    $obj->set($prop_name, $value);
                }
            }
        }
        return $obj;
    }
}
?>
