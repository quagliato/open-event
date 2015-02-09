<?php

class RespostaPergunta extends GenericClass{

    protected static $sys_tablename = "resposta_pergunta";

    protected $id;
    protected $id_resposta_edital;
    protected $id_pergunta;
    protected $vl_resposta;

    protected $sys_type = array(
        'id' => 'int',
        'id_resposta_edital' => 'int',
        'id_pergunta' => 'int',
        'vl_resposta' => 'str',
    );

    // protected static $createSQL = "
    //     CREATE TABLE IF NOT EXISTS resposta_pergunta (
    //         id INT NOT NULL AUTO_INCREMENT,
    //         id_resposta_edital INT NOT NULL,
    //         id_pergunta INT NOT NULL,
    //         vl_resposta VARCHAR(10000) NOT NULL,
    //         PRIMARY KEY (id)
    //     );";
}
?>
