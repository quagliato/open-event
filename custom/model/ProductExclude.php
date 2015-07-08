<?php

class ProductExclude extends GenericClass{

    protected static $sys_tablename = "product_exclude";

    protected $id;
    protected $id_product1;
    protected $id_product2;

    protected $sys_type = array(
        'id' => 'int',
        'id_product1' => 'int',
        'id_product2' => 'int'
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS product_exclude (
        id INT NOT NULL AUTO_INCREMENT,
        id_product1 INT NOT NULL,
        id_product2 INT NOT NULL,
        PRIMARY KEY (id)
      );
    ";
}
?>
