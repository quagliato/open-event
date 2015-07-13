<?php

class TransactionItem extends GenericClass{

    protected static $sys_tablename = "transaction_item";

    protected $id;
    protected $id_transaction;
    protected $id_product;
    protected $vl_exemption;
    protected $vl_item;

    protected $sys_type = array(
        'id' => 'int',
        'id_transaction' => 'int',
        'id_product' => 'int',
        'vl_exemption' => 'float',
        'vl_item' => 'float',
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS transaction_item (
        id INT NOT NULL AUTO_INCREMENT,
        id_transaction INT NULL,
        id_product INT NULL,
        vl_exemption FLOAT NOT NULL DEFAULT 0,
        vl_item FLOAT NOT NULL DEFAULT 0,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB AUTO_INCREMENT=40000;
    ";
}
?>
