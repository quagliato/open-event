<?php

class Product extends GenericClass{

    protected static $sys_tablename = "product";

    protected $id;
    protected $dt_begin;
    protected $dt_end;
    protected $max_quantity;
    protected $description;
    protected $price;

    protected $sys_type = array(
        'id' => 'int',
        'dt_begin' => 'date',
        'dt_end' => 'date',
        'max_quantity' => 'int',
        'description' => 'str',
        'price' => 'float'
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS product (
        id INT NOT NULL AUTO_INCREMENT,
        dt_begin TIMESTAMP NOT NULL,
        dt_end TIMESTAMP NOT NULL,
        max_quantity INT NOT NULL DEFAULT 1,
        description VARCHAR(500) NOT NULL,
        price FLOAT NOT NULL DEFAULT 0,
        PRIMARY KEY (id)
      );
    ";
}
?>
