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
        if ($respostaEdital->get('status') == 2) {
            $respostaEditalStatusDAO = new RespostaEditalStatusDAO;
            $respostaEditalStatus = $respostaEditalStatusDAO->getLastStatus(2);
            if ($respostaEditalStatus) {
                $user = $genericDAO->selectAll('Usuario', 'id = '.$respostaEditalStatus->get('id_user'));
                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Essa submissão já está negada por ".$user->get('nome')."."
                );
            } else {
                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Essa submissão já está negada."
                );
            }
            
        } else {
            $respostaEdital->set('status', 2);
            if ($genericDAO->update($respostaEdital, array(), "id = $idRespostaEdital")) {
                $respostaEditalStatus = new RespostaEditalStatus;
                $respostaEditalStatus->set('id_resposta_edital', $idRespostaEdital);
                $respostaEditalStatus->set('id_user', $usuario->get('id'));
                $respostaEditalStatus->set('dt_update', date('Y-m-d H:i:s'));
                $respostaEditalStatus->set('status', 2);

                if ($genericDAO->insert($respostaEditalStatus)) {
                    $return[] = array(
                        "Action" => "Message",
                        "Message" => "Submissão negada."
                    );
                }

            } else {
                $return[] = array(
                    "Action" => "Error",
                    "Error" => "Não foi possível negar esse edital. Por favor, tente novamente."
                );
            }
        }
    } else {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Não foi possível negar esse edital. Por favor, tente novamente."
        );
    }

    echo json_encode($return);
?>
