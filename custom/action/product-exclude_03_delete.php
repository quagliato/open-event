<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $id = $_POST['id'];

    if ($genericDAO->delete("ProductExclude", "id = $id")) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pacotes excludentes excluídos com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao excluir o pacote excludente."
        );
    endif;

    echo json_encode($return);
?>
