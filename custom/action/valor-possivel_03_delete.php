<?php
    $user = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $id = $_POST['id'];

    if ($genericDAO->delete("ValorPossivel", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Valor Possível excluído com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao excluir o valor possível."
        );
    endif;

    echo json_encode($return);
?>
