<?php

class ProductFather extends GenericClass{

    protected static $sys_tablename = "product_father";

    protected $id;
    protected $id_father;
    protected $id_product;

    protected $sys_type = array(
        'id' => 'int',
        'id_father' => 'int',
        'id_product' => 'int'
    );

    // protected static $createSQL = "
        // CREATE TABLE IF NOT EXISTS product_father (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     id_father INT NULL,
        //     id_product INT NULL,
        //     PRIMARY KEY (id)
        // );
    // ";
}
?>
