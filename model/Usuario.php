<?php

class Usuario extends GenericClass{
    protected static $sys_tablename = "usuario";

    protected $id;
    protected $nome;
    protected $senha;
    protected $email;
    protected $dt_registro;
    protected $dt_ultimo_login;
    protected $privilegio;

    protected $sys_type = array(
        'id' => 'int',
        'nome' => 'str',
        'senha' => 'str',
        'email' => 'str',
        'dt_registro' => 'date',
        'dt_ultimo_login' => 'date',
        'privilegio' => 'str'
    );

    // protected static $createSQL = "
    //     CREATE TABLE IF NOT EXISTS ".self::sys_tablename." (
    //         id int(11) NOT NULL AUTO_INCREMENT,
    //         nome VARCHAR(100) NOT NULL,
    //         senha VARCHAR(64) NOT NULL,
    //         email VARCHAR(100) NOT NULL,
    //         dt_registro timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    //         dt_ultimo_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    //         privilegio VARCHAR(3) NOT NULL DEFAULT 'USR',
    //         PRIMARY KEY (id)
    //   );";
}
?>
