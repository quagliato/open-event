<?php
  $user = Structure::verifyAdminSession();

  $return = array();

  $genericDAO = new GenericDAO;

  $inscricoes = array();

  if (array_key_exists('id', $_POST) && !is_null($_POST['id']) && $_POST['id'] != '') {
    $transaction = $genericDAO->selectAll("Transaction", "id = {$_POST['id']}");
    if ($transaction) {
      if (is_array($transaction)) $error = 1; // error
      $return[] = array(
        'Action' => 'Message',
        'Message' => 'Inscrição encontrada.'
      );

      $return[] = array(
        'Action' => 'Redir',
        'Redir' => '/admin/transaction?id='.$_POST['id']
      );
    } else {
      $return[] = array(
        'Action' => 'Error',
        'Error' => 'Inscrição não encontrada.'
      );
    }

  } else if (array_key_exists('cpf', $_POST) && !is_null($_POST['cpf']) && $_POST['cpf'] != '') {
    $usuario = $genericDAO->selectAll("Usuario", "cpf = '{$_POST['cpf']}'");
    if ($usuario) {
      if (is_array($usuario)) $usuario = $usuario[0];
      $return[] = array(
        'Action' => 'Message',
        'Message' => 'Usuário encontrada.'
      );

      $return[] = array(
        'Action' => 'Redir',
        'Redir' => '/admin/transaction?idUser='.$usuario->get('id')
      );
    } else {
      $return[] = array(
        'Action' => 'Error',
        'Error' => 'Usuário não encontrado.'
      );
    }

  } else if (array_key_exists('email', $_POST) && !is_null($_POST['email']) && $_POST['email'] != '') {
    $usuario = $genericDAO->selectAll("Usuario", "email = '{$_POST['email']}'");
    if ($usuario) {
      if (is_array($usuario)) $usuario = $usuario[0];
      $return[] = array(
        'Action' => 'Message',
        'Message' => 'Usuário encontrada.'
      );

      $return[] = array(
        'Action' => 'Redir',
        'Redir' => '/admin/transaction?idUser='.$usuario->get('id')
      );
    } else {
      $return[] = array(
        'Action' => 'Error',
        'Error' => 'Usuário não encontrado.'
      );
    }
  }

  echo json_encode($return);
?>