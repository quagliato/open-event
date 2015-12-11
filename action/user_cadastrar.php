<?php

    $return = array();

    if(isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', (time()-1000), '/');
        $return[] = array(
            "Action" => "Error",
            "Error" => "Já existe usuário logado. Tente novamente, por favor. Por favor, tente novamente."
        );
    }

    $userDAO = new UserDAO;
    $user = DataBinder::bind($_POST, 'User');
    $user->set('password', md5($user->get('password')));
    $user->set('dt_register', date('Y-m-d H:i:s'));
    $user->set('dt_last_login', date('Y-m-d H:i:s'));

    $blacklist_dao = new BlacklistDAO;

    if ($blacklist_dao->isBlacklisted($user->get('email'))) {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Blacklist."
        );
    } else {

        $userDAO = new UserDAO;

        $result = $userDAO->getUserByEmail(trim($user->get('email')));
        if ($result) {
            $return[] = array(
                "Action" => "Error",
                "Error" => "Seu e-mail já está cadastrado em nosso sistema."
            );
        } else {
            if ($user->get('email') == ADMIN_EMAIL) {
                $user->set('role', 'ADM');
            }

            $result = $userDAO->insert($user);
            if (!$result) {
                $return[] = array(
                    "Action" => "Error",
                    "Error" => "Problemas ao realizar seu cadastro. Por favor, tente novamente."
                );
            } else {
                $user_id = $userDAO->select("User",array('id'),"email = '".$user->get('email')."'");
                $user_id = $user_id->get('id');
                setcookie('user_id',$user_id,0,'/');

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
