<?php

    $return = array();

    session_start();
    if(isset($_SESSION['user_id'])) {
        unset($_SESSION['user_id']);
        $return[] = array(
            "Action" => "Error",
            "Error" => "Já existe usuário logado. Tente novamente, por favor. Por favor, tente novamente."
        );

    }

    $usuario_dao = new UsuarioDAO;
    $usuario = DataBinder::bind($_POST, 'Usuario');
    $usuario->set('senha', md5($usuario->get('senha')));
    $usuario->set('dt_registro', date('Y-m-d H:i:s'));
    $usuario->set('dt_ultimo_login', date('Y-m-d H:i:s'));

    $blacklist_dao = new BlacklistDAO;

    if ($blacklist_dao->isBlacklisted($usuario->get('email'))) {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Blacklist."
        );
    } else {

        $usuario_dao = new UsuarioDAO;

        $result = $usuario_dao->getUserByEmail(trim($usuario->get('email')));
        if ($result) {
            $return[] = array(
                "Action" => "Error",
                "Error" => "Seu e-mail já está cadastrado em nosso sistema."
            );
        } else {
            if ($usuario->get('email') == ADMIN_EMAIL) {
                $usuario->set('privilegio', 'ADM');
            }

            $result = $usuario_dao->insert($usuario);
            if (!$result) {
                $return[] = array(
                    "Action" => "Error",
                    "Error" => "Problemas ao realizar seu cadastro. Por favor, tente novamente."
                );
            } else {
                $user_id = $usuario_dao->select("Usuario",array('id'),"email = '".$usuario->get('email')."'");
                $user_id = $user_id->get('id');
                $_SESSION['user_id'] = $user_id;

                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Parabéns, voce esta cadastrado!"
                );

                $return[] = array(
                    "Action" => "Redir",
                    "Redir" => "/dashboard"
                );
            }
        }
    }

    echo json_encode($return);
?>
