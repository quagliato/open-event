<?php
  $user = Structure::verifyAdminSession();

  $return = array();
  $return['status'] = 0;

  $genericDAO = new GenericDAO;

  $idUser = $_POST['idUser'];

  $result = $genericDAO->selectAll("Transaction", "id_user = $idUser AND status = 1 AND value_exemption = 0;");
  if ($result) {
    if (!is_array($result)) $result = array($result);
    $transactions = array();
    foreach ($result as $item) {
      $transactionItems = array();
      $items = $genericDAO->selectAll("TransactionItem", "id_transaction = ".$item->get('id'));
      if ($items) {
        if (!is_array($items)) $items = array($items);
        foreach ($items as $transactionItem) {
          $product = $genericDAO->selectAll("Product", "id = ".$transactionItem->get('id_product'));
          $transactionItems[] = array(
            "id" =>  $transactionItem->get('id'),
            "id_product" => $product->get('id'),
            "product" => $product->get('description')
          );
        }
      }
      $transactions[] = array(
        "id" => $item->get('id'),
        "items" => $transactionItems
      );
    }
    $return['status'] = 1;
    $return['transactions'] = $transactions;
  }

  echo json_encode($return);
?>