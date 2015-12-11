<?php
    $user = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $edital = DataBinder::bind($_POST, "Edital");
    $edital->set('dt_abertura', Utils::brFormat2SQLTimestamp($edital->get('dt_abertura')));
    $edital->set('dt_fechamento', Utils::brFormat2SQLTimestamp($edital->get('dt_fechamento')));

    if ($genericDAO->insert($edital)) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Edital cadastrado com sucesso. <a href=\"".APP_URL."/admin/edital\">Cadastre um novo</a> ou <a href=\"".APP_URL."/admin/edital/action/list\">Veja todos.</a>"
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar edital."
        );
    endif;

    echo json_encode($return);
?>
