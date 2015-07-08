<?php

class ExemptionEmail extends GenericClass{

    protected static $sys_tablename = "exemption_email";

    protected $id;
    protected $email;
    protected $id_product;
    protected $modifier;

    protected $sys_type = array(
        'id' => 'int',
        'email' => 'str',
        'id_product' => 'int',
        'modifier' => 'float',
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS exemption_email (
        id INT NOT NULL AUTO_INCREMENT,
        email VARCHAR(150) NOT NULL,
        id_product INT NOT NULL,
        modifier FLOAT NOT NULL DEFAULT 1,
        PRIMARY KEY (id)
      );
    ";
}
?>
