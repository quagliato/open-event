<?php

class RespostaEdital extends GenericClass{

    protected static $sys_tablename = "resposta_edital";

    protected $id;
    protected $id_edital;
    protected $id_user;
    protected $dt_inicio_resposta;
    protected $dt_fim_resposta;
    protected $status;

    protected $sys_type = array(
        'id' => 'int',
        'id_edital' => 'int',
        'id_user' => 'int',
        'dt_inicio_resposta' => 'date',
        'dt_fim_resposta' => 'date',
        'status' => 'int',
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS resposta_edital (
        id INT NOT NULL AUTO_INCREMENT,
        id_edital INT NOT NULL,
        id_user INT NOT NULL,
        dt_inicio_resposta TIMESTAMP NOT NULL,
        dt_fim_resposta TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
      );
      ALTER TABLE resposta_edital ADD COLUMN status INT NOT NULL DEFAULT 0 AFTER dt_fim_resposta;
    ";
}
?>
