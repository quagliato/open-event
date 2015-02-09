<?php

class ValorPossivel extends GenericClass{

    protected static $sys_tablename = "valor_possivel";

    protected $id;
    protected $id_pergunta;
    protected $valor;
    protected $label;

    protected $sys_type = array(
        'id' => 'int',
        'id_pergunta' => 'int',
        'valor' => 'str',
        'label' => 'str',
    );

    // protected static $createSQL = "
    //     CREATE TABLE IF NOT EXISTS ".self::sys_tablename." (
    //         id INT NOT NULL AUTO_INCREMENT,
    //         id_pergunta INT NOT NULL,
    //         valor VARCHAR(200) NOT NULL,
    //         label VARCHAR(500) NOT NULL,
    //         PRIMARY KEY (id)
    //     );";
}
?>
