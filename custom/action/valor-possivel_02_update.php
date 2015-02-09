<?php
    $usuario = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $valorPossivel = DataBinder::bind($_POST, "ValorPossivel");

    if ($genericDAO->update($valorPossivel, array("id"), "id = ".$valorPossivel->get('id'))) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Valor Possível alterado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao alterar valor possível."
        );
    endif;

    echo json_encode($return);
?>
