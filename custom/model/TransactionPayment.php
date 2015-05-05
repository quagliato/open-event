<?php

class TransactionPayment extends GenericClass{

    protected static $sys_tablename = "transaction_payment";

    protected $id;
    protected $id_transaction;
    protected $dt_payment;
    protected $type;
    protected $info;
    protected $obs;
    protected $total_value;
    protected $status;

    protected $sys_type = array(
        'id' => 'int',
        'id_transaction' => 'int',
        'dt_payment' => 'date',
        'type' => 'str',
        'info' => 'str',
        'obs' => 'str',
        'total_value' => 'float',
        'status' => 'int',
    );

    // protected static $createSQL = "
//         CREATE TABLE IF NOT EXISTS transaction_payment (
//             id INT NOT NULL AUTO_INCREMENT,
//             id_transaction INT NULL,
//             dt_payment TIMESTAMP NOT NULL,
//             type VARCHAR(10) NOT NULL,
//             info VARCHAR(500) NOT NULL,
//             obs VARCHAR(4000) NULL,
//             total_value FLOAT NOT NULL DEFAULT 0,
//             status INT NOT NULL DEFAULT 0,
//             PRIMARY KEY (id)
//         );
    // ";
}
?>
