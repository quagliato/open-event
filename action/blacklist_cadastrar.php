<?php
    $user = Structure::verifyAdminSession();

    $return = array();

    $blacklist = DataBinder::bind($_POST, "Blacklist");

    $blacklist_dao = new BlacklistDAO;

    if ($blacklist_dao->insert($blacklist)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "E-mail cadastrado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar e-mail."
        );
    endif;

    echo json_encode($return);
?>
