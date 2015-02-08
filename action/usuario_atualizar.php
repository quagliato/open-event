<?php
    $usuario_old = Structure::verifySession();
    $return = array();

    $usuario = DataBinder::bind($_POST, 'Usuario');

    $blacklist_dao = new BlacklistDAO;

    if ($blacklist_dao->isBlacklisted($usuario->get('email'))) {
         $return[] = array(
            "Action" => "Error",
            "Error" => "O e-mail escolhido não pode ser utilizado nesse sistema. ".Structure::dashboardLink()
        );
    } else {
        $os_que_mudaram = array();
        foreach($usuario_old->props() as $key => $val) {
            if (!in_array($key, array('sys_type', 'sys_tablename', 'sys_validation', 'id', 'senha', 'dt_ultimo_login', 'dt_registro'))) {
                if ($val != $usuario->get($key)) {
                    $os_que_mudaram[] = $key;
                }
            }
        }

        if ($_POST['Usuario-senha'] != "") {
            $os_que_mudaram[] = 'senha';
            $usuario->set('senha', md5($usuario->get('senha')));
        }

        $usuario_dao = new UsuarioDAO;

        if (sizeof($os_que_mudaram) > 0) {
            $result = $usuario_dao->updateWithFields($usuario, $os_que_mudaram, ('id = '.$usuario_old->get('id')));
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
