<?php

class TransactionTransfer extends GenericClass{

    protected static $sys_tablename = "transaction_transfer";

    protected $id;
    protected $id_transaction;
    protected $id_user_origin;
    protected $id_user_destiny;

    protected $sys_type = array(
        'id' => 'int',
        'id_transaction' => 'int',
        'id_user_origin' => 'int',
        'id_user_destiny' => 'int',
    );

    // protected static $createSQL = "
        // CREATE TABLE IF NOT EXISTS transaction_transfer (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     id_transaction INT NULL,
        //     id_user_origin INT NULL,
        //     id_user_destiny INT NULL,
        //     PRIMARY KEY (id)
        // ) ENGINE=InnoDB;
    // ";
}
?>
