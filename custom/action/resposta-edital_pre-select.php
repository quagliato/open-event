<?php
    $usuario = Structure::verifyAdminSession();
    $genericDAO = new GenericDAO;
    $return = array();

    $idRespostaEdital = false;
    if (array_key_exists('id', $_POST) &&
        !is_null($_POST['id']) &&
        $_POST['id'] != '') {
        $idRespostaEdital = $_POST['id'];
    }

    $respostaEdital = $genericDAO->selectAll('RespostaEdital', "id = $idRespostaEdital");

    if ($respostaEdital) {
        if ($respostaEdital->get('status') == 3) {

            $respostaEditalStatuses = $genericDAO->selectAll('RespostaEditalStatus', "id_resposta_edital = $idRespostaEdital AND status = 3 AND id_user = ".$usuario->get('id'));
            if ($respostaEditalStatuses) {
                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Você já pré-selecionou essa submissão."
                );
            } else {
                $respostaEditalStatuses = $genericDAO->selectCount('RespostaEditalStatus', 'id', "id_resposta_edital = $idRespostaEdital AND status = 3");

                $respostaEditalStatus = new RespostaEditalStatus;
                $respostaEditalStatus->set('id_resposta_edital', $idRespostaEdital);
                $respostaEditalStatus->set('id_user', $usuario->get('id'));
                $respostaEditalStatus->set('dt_update', date('Y-m-d H:i:s'));
                $respostaEditalStatus->set('status', 3);

                if ($genericDAO->insert($respostaEditalStatus)) {
                    $return[] = array(
                        "Action" => "Message",
                        "Message" => "Você e mais $respostaEditalStatuses pessoa(s) pré-selecionaram essa submissão."
                    );
                }
            }
            
        } else {
            $respostaEdital->set('status', 3);
            if ($genericDAO->update($respostaEdital, array(), "id = $idRespostaEdital")) {
                $respostaEditalStatus = new RespostaEditalStatus;
                $respostaEditalStatus->set('id_resposta_edital', $idRespostaEdital);
                $respostaEditalStatus->set('id_user', $usuario->get('id'));
                $respostaEditalStatus->set('dt_update', date('Y-m-d H:i:s'));
                $respostaEditalStatus->set('status', 3);

                if ($genericDAO->insert($respostaEditalStatus)) {
                    $return[] = array(
                        "Action" => "Message",
                        "Message" => "Submissão pré-selecionada."
                    );
                }

            } else {
                $return[] = array(
                    "Action" => "Error",
                    "Error" => "Não foi possível pré-selecionar essa submissão. Por favor, tente novamente."
                );
            }
        }
    } else {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Não foi possível pré-selecionar a submissão. Por favor, tente novamente."
        );
    }

    echo json_encode($return);
?>
