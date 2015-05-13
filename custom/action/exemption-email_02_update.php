<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $exemptionEmail = DataBinder::bind($_POST, "ExemptionEmail");

    if ($genericDAO->update($exemptionEmail, array("id"), "id = ".$exemptionEmail->get('id'))) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Isenção alterada com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao alterar isenção."
        );
    endif;

    echo json_encode($return);
?>
