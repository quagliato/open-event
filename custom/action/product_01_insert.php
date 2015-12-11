<?php
    $user = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $product = DataBinder::bind($_POST, "Product");
    $product->set('dt_begin', Utils::brFormat2SQLTimestamp($product->get('dt_begin')));
    $product->set('dt_end', Utils::brFormat2SQLTimestamp($product->get('dt_end')));

    if ($genericDAO->insert($product)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pacote cadastrado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar pacote."
        );
    endif;

    echo json_encode($return);
?>
