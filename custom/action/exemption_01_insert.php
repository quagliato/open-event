<?php
    $usuario = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $exemption = DataBinder::bind($_POST, "Exemption");

    if ($genericDAO->insert($exemption)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Isenção cadastrada com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar valor possível."
        );
    endif;

    echo json_encode($return);
?>
