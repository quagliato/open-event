<?php

class Usuario extends GenericClass{

    protected static $sys_tablename = "usuario";

    protected $id;
    protected $nome;
    protected $cpf;
    protected $data_nasc;
    protected $deficiencia;
    protected $senha;
    protected $email;
    protected $telefone_residencial;
    protected $telefone_celular;
    protected $inst_ens;
    protected $curso;
    protected $periodo;
    protected $end_logradouro;
    protected $end_numero;
    protected $end_complemento;
    protected $end_bairro;
    protected $end_cidade;
    protected $end_estado;
    protected $end_cep;
    protected $responsavel_nome;
    protected $responsavel_telefone;
    protected $alergias;
    protected $medicacao_continua;
    protected $plano_saude;
    protected $dt_registro;
    protected $dt_ultimo_login;
    protected $privilegio;

    protected $sys_type = array(
        'id' => 'int',
        'nome' => 'str',
        'cpf' => 'str',
        'data_nasc' => 'date',
        'deficiencia' => 'str',
        'senha' => 'str',
        'email' => 'str',
        'telefone_residencial' => 'str',
        'telefone_celular' => 'str',
        'inst_ens' => 'str',
        'curso' => 'str',
        'periodo' => 'str',
        'end_logradouro' => 'str',
        'end_numero' => 'str',
        'end_complemento' => 'str',
        'end_bairro' => 'str',
        'end_cidade' => 'str',
        'end_estado' => 'str',
        'end_cep' => 'str',
        'responsavel_nome' => 'str',
        'responsavel_telefone' => 'str',
        'alergias' => 'str',
        'medicacao_continua' => 'str',
        'plano_saude' => 'str',
        'dt_registro' => 'date',
        'dt_ultimo_login' => 'date',
        'privilegio' => 'str'
    );

    protected static $createSQL = "
      CREATE TABLE IF NOT EXISTS usuario (
        id int(11) NOT NULL AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        cpf VARCHAR(14) NOT NULL,
        data_nasc VARCHAR(10) NOT NULL,
        deficiencia VARCHAR(200),
        senha VARCHAR(64) NOT NULL,
        email VARCHAR(100) NOT NULL,
        telefone_residencial VARCHAR(16),
        telefone_celular VARCHAR(16),
        inst_ens VARCHAR(100) NOT NULL,
        curso VARCHAR(100) NOT NULL,
        periodo VARCHAR(4) NOT NULL,
        end_logradouro VARCHAR(200) NOT NULL,
        end_numero VARCHAR(10) NOT NULL,
        end_complemento VARCHAR(50),
        end_bairro VARCHAR(50) NOT NULL,
        end_cidade VARCHAR(100) NOT NULL,
        end_estado VARCHAR(2) NOT NULL,
        end_cep VARCHAR(9) NOT NULL,
        responsavel_nome VARCHAR(100) NOT NULL,
        responsavel_telefone VARCHAR(16) NOT NULL,
        alergias VARCHAR(200),
        medicacao_continua VARCHAR(200),
        plano_saude VARCHAR(100),
        dt_registro timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        dt_ultimo_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
        privilegio VARCHAR(3) NOT NULL DEFAULT 'USR',
        PRIMARY KEY (id)
      );
    ";
}

?>
