<?php
    $usuario = Structure::verifySession();
    $genericDAO = new GenericDAO;
    $return = array();

    $pergunta = DataBinder::bind($_POST, "Pergunta");

    if (in_array($pergunta->get('tipo_resposta', Pergunta::getTypesWithSize()))) {
        $pergunta->set('tamanho_resposta', 0);
        $pergunta->set('exemplo', NULL);
    }

    if ($genericDAO->update($pergunta, array("id"), "id = ".$pergunta->get('id'))) :
        $return[] = array(
            "Action" => "Message",
            "Message" => "Pergunta alterada com sucesso."
        );
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao alterar a pergunta."
        );
    endif;

    echo json_encode($return);
?>
