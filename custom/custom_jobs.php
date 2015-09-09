<?php

  $genericDAO = new GenericDAO;

//******************************************************************************
// Cancel all transactions older than interval set on config
  $limit = new DateTime();
  $limit->sub(new DateInterval(TRANSACTION_CANCEL_INTERVAL));

  $transaction = new Transaction();
  $transaction->set('status', 3);

  $result = $genericDAO->updateWithFields($transaction, array('status'), "status = 0 AND dt_transaction < '".$limit->format('Y-m-d H:i:s')."'");

//******************************************************************************
// Confirm all transaction payments that have transaction confirmed
  $transactionPayment = new TransactionPayment();
  $transactionPayment->set('status', 1);

  $result = $genericDAO->updateWithFields($transactionPayment, array('status'), "(SELECT COUNT(t.status) FROM transaction t WHERE t.id = id_transaction AND t.status = 1) > 0");

//******************************************************************************
// Cancel all transaction payments older than 3 days
  $limit = new DateTime();
  $limit->sub(new DateInterval('P5D'));

  $transactionPayment = new TransactionPayment();
  $transactionPayment->set('status', 3);

  $result = $genericDAO->updateWithFields($transactionPayment, array('status'), "status = 0 AND (SELECT COUNT(t.status) FROM transaction t WHERE t.id = id_transaction AND (t.status = 0 OR t.status = 3)) > 0 AND dt_payment < '".$limit->format('Y-m-d H:i:s')."'");

//******************************************************************************
// Confirm all transactions approved on edital
  $transaction = new Transaction();
  $transaction->set('status', 1);

  $result = $genericDAO->updateWithFields($transaction, array('status'), "total_value = 0 AND value_exemption > 0");

?>