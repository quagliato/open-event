<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $id = $_POST['id'];

    if ($genericDAO->delete("Product", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pacote excluído com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao excluir o pacote."
        );
    endif;

    echo json_encode($return);
?>
