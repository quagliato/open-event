<?php
    $genericDAO = new GenericDAO;
    $return = array();

    if (!isset($_POST['notificationCode']) && isset($_POST['notificationType'])) {
      $return[] = array(
          "Action" => "Error",
          "Error" => "Problemas ocorreram ao cadastrar a notificação."
      );
      echo json_encode($return);
      return;
    }

    $now = new DateTime();

    $pagSeguroNotification = new PagSeguroNotification();
    $pagSeguroNotification->set('dt_notification', $now->format('Y-m-d H:i:s'));
    $pagSeguroNotification->set('notification_code', $_POST["notificationCode"]);
    $pagSeguroNotification->set('notification_type', $_POST["notificationType"]);

    if ($genericDAO->insert($pagSeguroNotification)) :

      $pagSeguroEmail = PAGSEGURO_EMAIL;
      $pagSeguroToken = PAGSEGURO_TOKEN;

      $url = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/{$pagSeguroNotification->get('notification_code')}?email={$pagSeguroEmail}&token={$pagSeguroToken}";

      $curlPagSeguro = curl_init($url);
      $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
      );

      curl_setopt_array($curlPagSeguro, $options);

      $curlResult = curl_exec($curlPagSeguro);

      curl_close($curlPagSeguro);

      if ($curlResult === false) {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar a notificação."
        );
        echo json_encode($return);
        return;
      }

      $xml = simplexml_load_string($curlResult);

      if ($xml === false) {
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas carregar XML."
        );
      } else {

        if ($xml->status != 3) {
          $pagSeguroNotification->set('status', 1);
          $genericDAO->updateWithFields($pagSeguroNotification, array("status"), "notification_code = {$_POST['notification_code']}");

          $return[] = array(
            "Action" => "Message",
            "Message" => "Transação ainda não confirmada."
          );
        } else {
          $transactionId = intval($xml->reference);

          $transaction = new Transaction;
          $transaction->set('status', 1);

          if ($genericDAO->updateWithFields($transaction, array("status"), "id = $transactionId")) {
            $return[] = array(
              "Action" => "Message",
              "Message" => "Notificação salva com sucesso e transação confirmada."
            );

            $pagSeguroNotification->set('status', 1);

            $genericDAO->update($pagSeguroNotification, array("status"), "notification_code = {$_POST['notificationCode']}");

          } else {
            $return[] = array(
              "Action" => "Error",
              "Message" => "Problemas ao confirmar a transação"
            );
          }
        }
      }
    else :
        $return[] = array(
            "Action" => "Error",
            "Error" => "Problemas ocorreram ao cadastrar a notificação."
        );
    endif;

    echo json_encode($return);
?>
