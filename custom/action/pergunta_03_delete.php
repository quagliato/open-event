<?php
    $usuario = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $id = $_POST['id'];

    if ($genericDAO->delete("Pergunta", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pergunta excluída com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao excluir pergunta."
        );
    endif;

    echo json_encode($return);
?>
