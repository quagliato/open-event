<?php
  $genericDAO = new GenericDAO;

  $id = false;
  $id = $_POST['id'];

  if ($id) {
    $transaction = $genericDAO->selectAll("Transaction", "id = $id AND status = 1");
    if ($transaction) {
      $user = $genericDAO->selectAll("User", "id = ".$transaction->get('id_user'));
      if (user) {
        echo json_encode(array("status" => "CONFIRMADA", "name" => $user->get('nome')));
      }
    } else {
      echo json_encode(array("status" => "NÃO CONFIRMADA", "name" => ""));
    }
  }
?>