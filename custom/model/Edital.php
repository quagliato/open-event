<?php

class Edital extends GenericClass{

    protected static $sys_tablename = "edital";

    protected $id;
    protected $nome;
    protected $dt_abertura;
    protected $dt_fechamento;
    protected $desc_resumida;
    protected $desc_completa;
    protected $tempo_preenchimento;

    protected $sys_type = array(
        'id' => 'int',
        'nome' => 'str',
        'dt_abertura' => 'date',
        'dt_fechamento' => 'date',
        'desc_resumida' => 'str',
        'desc_completa' => 'str',
        'tempo_preenchimento' => 'int',
    );

    // protected static $createSQL = "
    //     CREATE TABLE IF NOT EXISTS ".self::sys_tablename." (
    //         id INT NOT NULL AUTO_INCREMENT,
    //         nome VARCHAR(100) NOT NULL,
    //         dt_abertura TIMESTAMP NOT NULL,
    //         dt_fechamento TIMESTAMP NOT NULL,
    //         desc_resumida VARCHAR(500) NOT NULL,
    //         desc_completa VARCHAR(2000) NOT NULL,
    //         tempo_preenchimento INT NOT NULL,
    //         PRIMARY KEY (id)
    //     );";
}
?>
