<?php
  $user = Structure::verifyAdminSession();

  $return = array();

  $genericDAO = new GenericDAO;

  $idUser = false;
  if (array_key_exists('idUser', $_POST) && !is_null($_POST['idUser']) && $_POST['idUser'] != '') {
    $transactions = $genericDAO->selectAll("Transaction", "id_user = {$_POST['idUser']}");
    if ($transactions) {
      if (!is_array($transactions)) $transactions = array($transactions);
      $credenciado = false;
      foreach ($transactions as $transaction) {
        if ($transaction->get('status') == 1) {
          $transaction->set('status', 2);
          $result = $genericDAO->update($transaction, array(), "id = {$transaction->get('id')}");
          if ($result) $credenciado = true;
        }
      }
      if ($credenciado) {
        $return[] = array(
          'Action' => 'Alert',
          'Alert' => 'Inscrição credenciada.'
        );

        $return[] = array(
          'Action' => 'Redir',
          'Redir' => '/admin/transaction/search'
        );
      } else {
        $return[] = array(
          'Action' => 'Alert',
          'Alert' => 'ERR_C001 - Inscrição não credenciada, procure casos especiais.'
        );
      }
    } else {
      $return[] = array(
        'Action' => 'Alert',
        'Alert' => 'ERR_C002 - Inscrição não credenciada, procure casos especiais.'
      );
    }
  } else {
    $return[] = array(
      'Action' => 'Alert',
      'Alert' => 'ERR_C003 - Inscrição não credenciada, procure casos especiais.'
    );
  }

  echo json_encode($return);

?>