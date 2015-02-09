<?php
    $usuario = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $valorPossivel = DataBinder::bind($_POST, "ValorPossivel");

    if ($genericDAO->insert($valorPossivel)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Valor Possível cadastrado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar valor possível."
        );
    endif;

    echo json_encode($return);
?>
