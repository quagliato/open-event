<?php
    $user = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $productExclude = DataBinder::bind($_POST, "ProductExclude");

    if ($productExclude->get('id_product1') == $productExclude->get('id_product2')) {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Os pacotes excludentes não podem ser o mesmo produto."
        );

        echo json_encode($return);
        exit();
    }

    if ($genericDAO->insert($productExclude)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pacotes excludentes cadastrados com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar os pacotes excludentes."
        );
    endif;

    echo json_encode($return);
?>
