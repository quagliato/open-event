<?php
    $usuario = Structure::verifyAdminSession();
    $return = array();

    $id = $_POST['id'];

    $dao = new GenericDAO;

    if ($dao->delete("Blacklist", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "E-mail excluído com sucesso."
        );

        $return[] = array(
            "Action" => "Redir",
            "Redir" => "/admin/blacklist/listar"
        );
    else :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Problemas ao excluir o e-mail."
        );
    endif;

    echo json_encode($return);
?>
