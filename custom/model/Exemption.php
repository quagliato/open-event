<?php

class Exemption extends GenericClass{

    protected static $sys_tablename = "exemption";

    protected $id;
    protected $id_edital;
    protected $id_product;
    protected $modifier;

    protected $sys_type = array(
        'id' => 'int',
        'id_edital' => 'int',
        'id_product' => 'int',
        'modifier' => 'float',
    );

    // protected static $createSQL = "
        // CREATE TABLE IF NOT EXISTS exemption (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     id_edital INT NOT NULL,
        //     id_product INT NOT NULL,
        //     modifier FLOAT NOT NULL DEFAULT 1,
        //     PRIMARY KEY (id)
        // );
    // ";
}
?>