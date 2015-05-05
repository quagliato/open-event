<?php

class Product extends GenericClass{

    protected static $sys_tablename = "product";

    protected $id;
    protected $id_father;
    protected $dt_begin;
    protected $dt_end;
    protected $description;
    protected $price;

    protected $sys_type = array(
        'id' => 'int',
        'id_father' => 'int',
        'dt_begin' => 'date',
        'dt_end' => 'date',
        'description' => 'str',
        'price' => 'float'
    );

    // protected static $createSQL = "
        // CREATE TABLE IF NOT EXISTS product (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     id_father INT NULL,
        //     dt_begin TIMESTAMP NOT NULL,
        //     dt_end TIMESTAMP NOT NULL,
        //     description VARCHAR(500) NOT NULL,
        //     price FLOAT NOT NULL DEFAULT 0,
        //     PRIMARY KEY (id)
        // );
    // ";
}
?>
