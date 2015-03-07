<?php

class RespostaEditalStatus extends GenericClass{

    protected static $sys_tablename = "resposta_edital_status";

    protected $id;
    protected $id_resposta_edital;
    protected $id_user;
    protected $dt_update;
    protected $status;

    protected $sys_type = array(
        'id' => 'int',
        'id_resposta edital' => 'int',
        'id_user' => 'int',
        'dt_update' => 'date',
        'status' => 'int',
    );

    public static function getTextStatus($status) {
        switch ($status) {
            case 1: return "Aprovado";
            case 2: return "Negado";
            case 3: return "Pré-selecionado";
            case 0: return "Não-auditado";
        }
    }

    // protected static $createSQL = "
    //     CREATE TABLE IF NOT EXISTS resposta_edital_status (
    //         id INT NOT NULL AUTO_INCREMENT,
    //         id_resposta_edital INT NOT NULL,
    //         id_user INT NOT NULL,
    //         dt_update TIMESTAMP NOT NULL,
    //         status INT NOT NULL DEFAULT 0,
    //         PRIMARY KEY (id)
    //     );
    // ";
}
?>
