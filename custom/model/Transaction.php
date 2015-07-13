<?php

class Transaction extends GenericClass{

    protected static $sys_tablename = "transaction";

    protected $id;
    protected $id_user;
    protected $dt_transaction;
    protected $total_value;
    protected $value_exemption;
    protected $id_last_payment;
    protected $status;

    protected $sys_type = array(
        'id' => 'int',
        'id_user' => 'int',
        'dt_transaction' => 'date',
        'total_value' => 'float',
        'value_exemption' => 'float',
        'id_last_payment' => 'int',
        'status' => 'int',
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS transaction (
        id INT NOT NULL AUTO_INCREMENT,
        id_user INT NULL,
        dt_transaction TIMESTAMP NOT NULL,
        total_value FLOAT NOT NULL DEFAULT 0,
        value_exemption FLOAT NOT NULL DEFAULT 0,
        id_last_payment INT NULL,
        status INT NOT NULL DEFAULT 0,
        PRIMARY KEY (id)
      ) ENGINE=InnoDB AUTO_INCREMENT=30000;
    ";
}
?>
