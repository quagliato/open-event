<?php
    $user = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $id = $_POST['id'];

    if ($genericDAO->delete("ExemptionEmail", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Isenção excluída com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao excluir a isenção."
        );
    endif;

    echo json_encode($return);
?>
