<?php
    $user = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $productFather = DataBinder::bind($_POST, "ProductFather");

    if ($productFather->get('id_father') == $productFather->get('id_product')) {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Os pacotes pai e filho devem ser diferentes."
        );

        echo json_encode($return);
        exit();
    }

    if ($genericDAO->update($productFather, array("id"), "id = ".$productFather->get('id'))) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pacote pai alterado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao alterar o pacotes pai."
        );
    endif;

    echo json_encode($return);
?>
