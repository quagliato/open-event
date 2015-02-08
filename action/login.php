<?php

    $usuario = DataBinder::bind($_POST, 'Usuario');
    $senha = md5($usuario->get('senha'));

    $usuario_dao = new UsuarioDAO;

    $usuario = $usuario_dao->getUserByEmail(trim($usuario->get('email')));

    $return = array();
    if (!$usuario) {
        $return[] = array(
            'Action' => 'Error',
            'Error' => 'Seu e-mail não está cadastrado em nosso sistema.'
        );
    } else {
        if ($usuario->get('senha') == $senha) {

            session_start();
            $_SESSION['user_id'] = $usuario->get('id');

            $strdate = date('Y-m-d H:i:s');
            $usuario->set('dt_ultimo_login', $strdate);
            $usuario_dao->updateWithFields($usuario, array('dt_ultimo_login'), ("id = ".$usuario->get('id')));

            $return[] = array(
                'Action' => 'Redir',
                'Redir' => '/dashboard'
            );

        } else {
            $return[] = array(
                'Action' => 'Error',
                'Error' => 'Senha inválida.'
            );
        }
    }

    echo json_encode($return);
?>
