<?php
    $user = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $edital = DataBinder::bind($_POST, "Edital");
    $edital->set('dt_abertura', Utils::brFormat2SQLTimestamp($edital->get('dt_abertura')));
    $edital->set('dt_fechamento', Utils::brFormat2SQLTimestamp($edital->get('dt_fechamento')));

    if ($genericDAO->update($edital, array("id"), "id = ".$edital->get('id'))) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Edital alterado com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao alterar edital."
        );
    endif;

    echo json_encode($return);
?>
