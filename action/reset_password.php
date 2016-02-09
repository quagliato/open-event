<?php

    $return = array();

    $code = $_POST['code'];
    $password = $_POST['password'];
    $confirmacao_senha = $_POST['confirmacao_senha'];

    $dao = new GenericDAO;

    $request = $dao->selectAll('Request',"code = '".$code."'");

    if (!$request) {
        $return[] = array(
            'Action' => 'Error',
            'Error' => 'Código de restauração não cadastrado no sistema.'
        );
    } else {
        if ($request->get('status') != 0) {
            $return[] = array(
                'Action' => 'Error',
                'Error' => 'Esse código de restauração já foi utilizado.'
            );
        } else {
            $userDAO = new UserDAO;
            $user = $userDAO->selectAll("User", ("id = ".$request->get('id_user')));
            if (!$user) {
                $return[] = array(
                    'Action' => 'Error',
                    'Error' => 'Não conseguimos localizar seu usuário em nosso sistema. Por favor, tente novamente.'
                );
            } else {
                $user->set('password',md5($_POST['password']));
                if (!$userDAO->updateWithFields($user, array('password'), ("id = ".$user->get('id')))) {
                    $return[] = array(
                        'Action' => 'Error',
                        'Error' => 'Não conseguimos atualizar sua senha. Por favor, tente novamente.'
                    );
                } else {
                    $request->set('status', 1);
                    if (!$dao->updateWithFields($request, array('status'), ("code = '$code'"))) {
                        //TODO: Precisa mesmo dar erro quando não conseguir mudar o stats do request?
                        $return[] = array(
                            'Action' => 'Error',
                            'Error' => 'Não conseguimos localizar seu usuário em nosso sistema. Por favor, tente novamente.'
                        );
                    } else {
                        $return[] = array(
                            'Action' => 'Message',
                            'Message' => 'Sua senha foi alterada com sucesso.'
                        );
                    }
                }
            }
        }
    }
    echo json_encode($return);
?>
