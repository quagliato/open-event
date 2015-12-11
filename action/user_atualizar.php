<?php
    $userOld = Structure::verifySession();
    $return = array();

    $user = DataBinder::bind($_POST, 'User');

    $blacklistDAO = new BlacklistDAO;

    if ($blacklistDAO->isBlacklisted($user->get('email'))) {
         $return[] = array(
            "Action" => "Error",
            "Error" => "O e-mail escolhido não pode ser utilizado nesse sistema. ".Structure::dashboardLink()
        );
    } else {
        $os_que_mudaram = array();
        foreach($userOld->props() as $key => $val) {
            if (!in_array($key, array('sys_type', 'sys_tablename', 'sys_validation', 'id', 'password', 'dt_last_login', 'dt_register'))) {
                if ($val != $user->get($key)) {
                    $os_que_mudaram[] = $key;
                }
            }
        }

        if ($_POST['User-password'] != "") {
            $os_que_mudaram[] = 'password';
            $user->set('password', md5($user->get('password')));
        }

        $userDAO = new UserDAO;

        if (sizeof($os_que_mudaram) > 0) {
            $result = $userDAO->updateWithFields($user, $os_que_mudaram, ('id = '.$userOld->get('id')));
             if (!$result) {
                $return[] = array(
                    "Action" => "Error",
                    "Error" => "Ocorreram problemas na atualização do seu cadastro. ".Structure::dashboardLink()
                );

             } else {
                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Cadastro alterado com sucesso. ".Structure::dashboardLink()
                );
             }
        } else {
            $return[] = array(
                "Action" => "Message",
                "Message" => "Nenhum campo alterado. ".Structure::dashboardLink()
            );
        }
    }

    echo json_encode($return);
?>
