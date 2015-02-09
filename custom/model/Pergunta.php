<?php

class Pergunta extends GenericClass{

    protected static $sys_tablename = "pergunta";

    protected $id;
    protected $id_edital;
    protected $titulo;
    protected $descricao;
    protected $exemplo;
    protected $tipo_resposta;
    protected $tamanho_resposta;
    protected $ordem_exibicao;

    protected $sys_type = array(
        'id' => 'int',
        'id_edital' => 'int',
        'titulo' => 'str',
        'descricao' => 'str',
        'exemplo' => 'str',
        'tipo_resposta' => 'str',
        'tamanho_resposta' => 'int',
        'ordem_exibicao' => 'int',
    );

    // protected static $createSQL = "
    //     CREATE TABLE IF NOT EXISTS ".self::sys_tablename." (
    //         id INT NOT NULL AUTO_INCREMENT,
    //         id_edital INT NOT NULL,
    //         titulo VARCHAR(200) NOT NULL,
    //         descricao VARCHAR(500) NOT NULL,
    //         exemplo VARCHAR(500) NOT NULL,
    //         tipo_resposta VARCHAR(20) NOT NULL,
    //         tamanho_resposta INT NOT NULL,
    //         ordem_exibicao INT NOT NULL,
    //         PRIMARY KEY (id)
    //     );";
}
?>
