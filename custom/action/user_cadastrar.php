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
    $user->set('data_nasc', Utils::brFormat2SQLDate($user->get('data_nasc')));
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
                $userId = $userDAO->select("User",array('id'),"email = '".$user->get('email')."'");
                $userId = $userId->get('id');
                setcookie('user_id',$userId,0,'/');

                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Parabéns, você está cadastrado!"
                );

                if (array_key_exists("noisy-cricket_goto", $_COOKIE) && isset($_COOKIE["noisy-cricket_goto"]) && !is_null($_COOKIE["noisy-cricket_goto"])) {
                    $return[] = array(
                        'Action' => 'Redir',
                        'Redir' => $_COOKIE["noisy-cricket_goto"]
                    );
                } else {
                    $return[] = array(
                        'Action' => 'Redir',
                        'Redir' => '/dashboard'
                    );
                }
            }
        }
    }

    echo json_encode($return);
?>
