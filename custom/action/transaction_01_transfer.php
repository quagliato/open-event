<?php
  $user = Structure::verifyAdminSession();

  $return = array();

  $genericDAO = new GenericDAO;

  $originUser = false;
  $originUserId = $_POST['origin_user_id'];
  $destinyUser = false;
  $destinyUserId = $_POST['destiny_user_id'];
  $transactionsToTransfer = array();

  foreach ($_POST['product_transfer'] as $transactionId) {
    $transaction = $genericDAO->selectAll("Transaction", "id = ".$transactionId);
    $transactionsToTransfer[] = $transaction;
  }

  $originUser = $genericDAO->selectAll("User", "id = ".$originUserId);
  $destinyUser = $genericDAO->selectAll("User", "id = ".$destinyUserId);

  if (sizeof($transactionsToTransfer) > 0 && $originUser && $destinyUser) {
    foreach ($transactionsToTransfer as $transaction) {
        $transaction->set('id_user', $destinyUser->get('id'));
        $result = $genericDAO->update($transaction, array(), "id = ".$transaction->get('id'));

        if ($result) {
            $transactionTransfer = new TransactionTransfer();
            $transactionTransfer->set('id_transaction', $transaction->get('id'));
            $transactionTransfer->set('id_user_origin', $originUser->get('id'));
            $transactionTransfer->set('id_user_destiny', $destinyUser->get('id'));
            $result = $genericDAO->insert($transactionTransfer);

            if ($result) {
                $return[] = array(
                    "Action" => "Message",
                    "Message" => "Inscrição transferida com sucesso."
                );

                $return[] = array(
                    "Action" => "Redir",
                    "Redir" => "/dashboard"
                );
            } else {
                $return[] = array(
                    "Action" => "Error",
                    "Error" => "Não foi possível transferir a inscrição."
                );
            }
        } else {
            $return[] = array(
                "Action" => "Error",
                "Error" => "Não foi possível transferir a inscrição."
            );
        }
    }
  } else {
    $return[] = array(
        "Action" => "Error",
        "Error" => "Não foi possível transferir a inscrição."
    );
  }

  echo json_encode($return);
?>