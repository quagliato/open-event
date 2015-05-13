<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $exemption = DataBinder::bind($_POST, "Exemption");

    if ($genericDAO->update($exemption, array("id"), "id = ".$exemption->get('id'))) :
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
