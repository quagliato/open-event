<?php
    $usuario = Structure::verifySession();
    Structure::header();

    $genericDAO = new GenericDAO;

    if (!array_key_exists('subject', $_POST) || $_POST['subject'] == "") {
        Structure::redirWithMessage("Assunto é um campo obrigatório.", "/admin/send-email");
    }
    $subject = $_POST['subject'];

    if (!array_key_exists('message', $_POST) || $_POST['message'] == "") {
        Structure::redirWithMessage("Mensagem é um campo obrigatório.", "/admin/send-email");
    }
    $message = $_POST['message'];

    if (!array_key_exists('criteria', $_POST) || $_POST['criteria'] == "") {
        Structure::redirWithMessage("Critério é um campo obrigatório.", "/admin/send-email");
    }
    $criteria = $_POST['criteria'];
    $specific = $_POST['specific'];

    $emails = array();

    if ($criteria == "all") {
        $users = $genericDAO->selectAll("Usuario", NULL);
        if ($users) {
            if (!is_array($users)) $users = array($users);
            foreach ($users as $user) {
                $email = $user->get('email');
                $email = trim($email);
                $email = strtolower($email);
                if ($email != "" && !in_array($email, $emails)) {
                    $emails[] = $email;
                }
            }
        }
    } elseif ($criteria == "buyers") {
        $transactions = $genericDAO->selectAll("Transaction", NULL);
        if ($transactions) {
            if (!is_array($transactions)) $transactions = array($transactions);
            foreach ($transactions as $transaction) {
                $users = $genericDAO->selectAll("Usuario", "id = ".$transaction->get('id_user'));
                if ($users) {
                    if (!is_array($users)) $users = array($users);
                    foreach ($users as $user) {
                        $email = $user->get('email');
                        $email = trim($email);
                        $email = strtolower($email);
                        if ($email != "" && !in_array($email, $emails)) {
                            $emails[] = $email;
                        }
                    }
                }
            }
        }
    } elseif ($criteria == "edital") {
        $respostasEdital = $genericDAO->selectAll("RespostaEdital", NULL);
        if ($respostasEdital) {
            if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
            foreach ($respostasEdital as $respostaEdital) {
                $users = $genericDAO->selectAll("Usuario", "id = ".$respostaEdital->get('id_user'));
                if ($users) {
                    if (!is_array($users)) $users = array($users);
                    foreach ($users as $user) {
                        $email = $user->get('email');
                        $email = trim($email);
                        $email = strtolower($email);
                        if ($email != "" && !in_array($email, $emails)) {
                            $emails[] = $email;
                        }
                    }
                }
            }
        }
    } elseif ($criteria == "edital_approved") {
        $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1");
        if ($respostasEdital) {
            if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
            foreach ($respostasEdital as $respostaEdital) {
                $users = $genericDAO->selectAll("Usuario", "id = ".$respostaEdital->get('id_user'));
                if ($users) {
                    if (!is_array($users)) $users = array($users);
                    foreach ($users as $user) {
                        $email = $user->get('email');
                        $email = trim($email);
                        $email = strtolower($email);
                        if ($email != "" && !in_array($email, $emails)) {
                            $emails[] = $email;
                        }
                    }
                }
            }
        }
    } elseif ($criteria == "edital_approved_not_buyers") {
      $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1");
      if ($respostasEdital) {
        if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
        foreach ($respostasEdital as $respostaEdital) {
          $users = $genericDAO->selectAll("Usuario", "id = ".$respostaEdital->get('id_user'));
          if ($users) {
            if (!is_array($users)) $users = array($users);
            foreach ($users as $user) {
              if (!$genericDAO->selectAll("Transaction", "id_user = {$user->get('id')} AND status = 1")) {
                $email = $user->get('email');
                $email = trim($email);
                $email = strtolower($email);
                if ($email != "" && !in_array($email, $emails)) {
                  $emails[] = $email;
                }
              }
            }
          }
        }
      }
      $exemptionsEmail = $genericDAO->selectAll("ExemptionEmail");
      if ($exemptionsEmail) {
        if (!is_array($exemptionsEmail)) $exemptionsEmail = array($exemptionsEmail);
        foreach ($exemptionsEmail as $exemptionEmail) {
          $users = $genericDAO->selectAll("Usuario", "email = '{$exemptionEmail->get('email')}'");
          if ($users) {
            if (!is_array($users)) $users = array($users);
            foreach ($users as $user) {
              if (!$genericDAO->selectAll("Transaction", "id_user = {$user->get('id')} AND status = 1")) {
                $email = $user->get('email');
                $email = trim($email);
                $email = strtolower($email);
                if ($email != "" && !in_array($email, $emails)) {
                  $emails[] = $email;
                }
              }
            }
          /*  
          } else {
            $email = $exemptionEmail->get('email');
            $email = trim($email);
            $email = strtolower($email);
            if ($email != "" && !in_array($email, $emails)) {
              $emails[] = $email;
            }
          */
          }
        }
      }
    } elseif ($criteria == "edital_with_exemption_approved") {
      $exemptions = $genericDAO->selectAll("Exemption", NULL);
      if ($exemptions) {
        if (!is_array($exemptions)) $exemptions = array($exemptions);
        foreach ($exemptions as $exemption) {
          $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1 AND id_edital = ".$exemption->get('id_edital'));
          if ($respostasEdital) {
            if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
            $userIDs = "";
            foreach ($respostasEdital as $respostaEdital) {
              if (strlen($userIDs) > 0) $userIDs .= ", ";
              $userIDs .= $respostaEdital->get('id_user');
            }

            $usuarios = $genericDAO->selectAll("Usuario", "id IN ($userIDs)");
            if ($usuarios) {
              if (!is_array($usuarios)) $usuarios = array($usuarios);
              foreach ($usuarios as $usuario) {
                $email = trim($usuario->get('email'));
                $email = strtolower($email);
                if ($email != "" && !in_array($email, $emails)) {
                  $emails[] = $email;
                }
              }
            }
          }
        }
      }
    } elseif ($criteria == "exemptions") {
        $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1");
        if ($respostasEdital) {
            if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
            foreach ($respostasEdital as $respostaEdital) {
                $users = $genericDAO->selectAll("Usuario", "id = ".$respostaEdital->get('id_user'));
                if ($users) {
                    if (!is_array($users)) $users = array($users);
                    foreach ($users as $user) {
                        $email = $user->get('email');
                        $email = trim($email);
                        $email = strtolower($email);
                        if ($email != "" && !in_array($email, $emails)) {
                            $emails[] = $email;
                        }
                    }
                }
            }
        }

        $exemptionsEmail = $genericDAO->selectAll("ExemptionEmail", NULL);
        if ($exemptionsEmail) {
            if (!is_array($exemptionsEmail)) $exemptionsEmail = array($exemptionsEmail);
            foreach ($exemptionsEmail as $exemptionEmail) {
                $email = $exemptionEmail->get('email');
                $email = trim($email);
                $email = strtolower($email);
                if ($email != "" && !in_array($email, $emails)) {
                    $emails[] = $email;
                }
            }
        }
    } elseif ($criteria == "transaction_less") {
        $transactions = $genericDAO->selectAll("Transaction", "id < ".$specific);
        if ($transactions) {
            if (!is_array($transactions)) $transactions = array($transactions);
            foreach ($transactions as $transaction) {
                $users = $genericDAO->selectAll("Usuario", "id = ".$transaction->get('id_user'));
                if ($users) {
                    if (!is_array($users)) $users = array($users);
                    foreach ($users as $user) {
                        $email = $user->get('email');
                        $email = trim($email);
                        $email = strtolower($email);
                        if ($email != "" && !in_array($email, $emails)) {
                            $emails[] = $email;
                        }
                    }
                }
            }
        }
    }
?>
        <main>
            <header class="center">
                <h1>E-mails</h1>
            </header>
            <section class="wrapper">
            <?php
                if ($emails && sizeof($emails) > 0) :
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                  <thead>
                    <td style="width:10%; text-align:center;">Sequência</td>
                    <td style="width:60%; text-align:left;">E-mail</td>
                    <td style="width:20%; text-align:left;">Data/Hora do Envio</td>
                    <td style="width:10%; text-align:left;">Status</td>
                  </thead>
                    <?php
                        $count = 0;
                        $notification = new Notification;
                        foreach ($emails as $email) :
                          $emailMessage = new EmailMessage;
                          $emailMessage->set('email', $email);
                          $emailMessage->set('subject', $subject);
                          $emailMessage->set('message', $message);

                          $status = 0;
                          if ($notification->sendEmail($email, $subject, $message)) {
                            $status = 1;
                            $emailMessage->set('status', $status);
                          }

                          $genericDAO->insert($emailMessage);
                    ?>
                    <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                      <td style="text-align:center;"><?=$count?></td>
                      <td style="text-align:left;"><?=$email?></td>
                      <td style="text-align:left;"><?=date('d/m/Y H:i:s')?></td>
                      <td style="text-align:left;"><?=$status == 1 ? 'E-mail enviado' : 'E-mail não enviado'?></td>
                    </tr>
                    <?php 
                          $count++;
                        endforeach;
                    ?>
                </table>
            <?php else: ?>
                <h2 class="center">Nenhum e-mail selecionado.</h2>
            <?php endif; ?>
            </section>
        </main>

<?php Structure::footer(); ?>
