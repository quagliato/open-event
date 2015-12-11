<?php

    $return = array();

    if (!isset($_POST['email']) || is_null($_POST['email'])) {
        Structure::redirWithMessage("E-mail não informado.\nPor favor, tente novamente.", "lost_password");
        $return[] = array(
            'Action' => 'Error',
            'Error' => 'Por favor, informe um endereço de e-mail válido.'
        );
    } else {
        $email = $_POST['email'];

        $userDAO = new UserDAO;

        $user = $userDAO->getUserByEmail($email);

        if (!$user) {
            $return[] = array(
                'Action' => 'Error',
                'Error' => 'O e-mail informado não foi encontrado em nosso sistema.'
            );
        } else {
            $hash1 = md5($user->get('email'));
            $hash2 = md5(date("U"));
            $hash3 = md5($hash1.$hash2);

            $request = new Request;
            $request->set('code', $hash3);
            $request->set('id_user', $user->get('id'));
            $request->set('email_sent', $user->get('email'));
            $request->set('sent_time', date("U"));
            $request->set('status', '0');

            $dao = new GenericDAO;

            $insert_result = $dao->insert($request);

            if (!$insert_result) {
                $return[] = array(
                    'Action' => 'Error',
                    'Error' => 'Não conseguimos gerar seu pedido de restauração. Por favor, tente novamente.'
                );
            } else {
                $restore_link = APP_URL."/restore?code=$hash3";

                $to = $user->get('email');
                $message = "<p>$restore_link</p>";
                $notification = new Notification;
                $mail_result = $notification->sendEmailRestorePassword($to, $message);

                if (!$mail_result) {
                    $return[] = array(
                        'Action' => 'Error',
                        'Error' => 'Não conseguimos gerar seu pedido de restauração. Por favor, tente novamente.'
                    );

                    $request->set('status','-1');
                    $dao->updateWithFields($request, array('status'), "code = '".$request->get('code')."'");

                } else {
                    $return[] = array(
                        'Action' => 'Message',
                        'Message' => 'Seu pedido de restauração foi criado.<br />Verifique sua caixa de entrada (e a de spam) para maiores informações.'
                    );
                }
            }
        }
    }

    echo json_encode($return);
?>
