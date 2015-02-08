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
}
?>
