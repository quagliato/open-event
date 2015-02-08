<?php
    $usuario = Structure::verifyAdminSession();

    $return = array();

    $blacklist = DataBinder::bind($_POST, "Blacklist");

    $blacklist_dao = new BlacklistDAO;

    if ($blacklist_dao->update($blacklist, NULL, "id = ".$blacklist->get('id'))) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "E-mail editado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao editar o e-mail."
        );
    endif;

    echo json_encode($return);
?>
