<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $exemptionEmail = DataBinder::bind($_POST, "ExemptionEmail");

    if ($genericDAO->insert($exemptionEmail)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Isenção cadastrada com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar isenção."
        );
    endif;

    echo json_encode($return);
?>
