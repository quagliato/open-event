<?php
    $usuario = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $id = $_POST['id'];

    if ($genericDAO->delete("Edital", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Edital excluído com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao excluir o edital."
        );
    endif;

    echo json_encode($return);
?>
