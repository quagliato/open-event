<?php
  $usuario = Structure::verifyAdminSession();
  Structure::header('nude');

  $result = array();

  $status = false;
  if (array_key_exists('status', $_GET) && $_GET['status'] != "" && !is_null($_GET['status'])) {
    $status = $_GET['status'];
  }

  $genericDAO = new GenericDAO;

  $transactionItemsStr = "";
  $transactionItems = $genericDAO->selectAll("TransactionItem", "id_product IN (1, 7, 8)");
  foreach ($transactionItems as $TransactionItem) {
    if (strlen($transactionItemsStr) > 0) $transactionItemsStr .= ', ';
    $transactionItemsStr .= $TransactionItem->get('id_transaction');
  }


  $usersStr = "";
  $transactions = $genericDAO->selectAll("Transaction", "status = $status AND id IN ($transactionItemsStr)");
  foreach ($transactions as $transaction) {
    if (strlen($usersStr) > 0) $usersStr .= ", ";
    $usersStr .= $transaction->get('id_user');
  }

  $people = $genericDAO->selectAll("Usuario", "id IN ($usersStr) ORDER BY nome");

  $count = 0;
  $lastFirstLetter = "";
  foreach ($people as $person) {
    if (mb_substr(mb_strtoupper($person->get('nome')), 0, 1) != $lastFirstLetter) {
      $lastFirstLetter = mb_substr(mb_strtoupper($person->get('nome')), 0, 1);
      echo "</table>";
      echo "<h1>$lastFirstLetter</h1>";
      echo "<table style=\"border:none; width:100%;\">";
      echo "<tr>";
      echo "<td style=\"border: 1px solid #000000; font-size:8px; width:5%;\">Count</td>";
      echo "<td style=\"border: 1px solid #000000; font-size:8px; width:5%;\">ID</td>";
      echo "<td style=\"border: 1px solid #000000; font-size:8px; width:40%;\">Nome</td>";
      echo "<td style=\"border: 1px solid #000000; font-size:8px; width:25%;\">CPF</td>";
      echo "<td style=\"border: 1px solid #000000; font-size:8px; width:25%;\">E-mail</td>";
      echo "</tr>";
    }
    echo "<tr>";
    echo "<td style=\"border: 1px solid #000000; font-size:8px; \">$count</td>";  
    echo "<td style=\"border: 1px solid #000000; font-size:8px; \">".$person->get('id')."</td>";
    echo "<td style=\"border: 1px solid #000000; font-size:8px; \">".mb_strtoupper($person->get('nome'))."</td>";
    echo "<td style=\"border: 1px solid #000000; font-size:8px; \">".$person->get('cpf')."</td>";
    echo "<td style=\"border: 1px solid #000000; font-size:8px; \">".$person->get('email')."</td>";
    echo "</tr>";
    $count++;
  }
