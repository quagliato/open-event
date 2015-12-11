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

    if ($genericDAO->insert($productFather)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pacote pai cadastrado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar o pacote pai."
        );
    endif;

    echo json_encode($return);
?>
