<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $id = $_POST['id'];

    if ($genericDAO->delete("ProductFather", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pacote pai excluído com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao excluir o pacote pai."
        );
    endif;

    echo json_encode($return);
?>
