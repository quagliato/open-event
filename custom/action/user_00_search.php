<?php
  $user = Structure::verifyAdminSession();

  $return = array();
  $return['status'] = 0;

  $genericDAO = new GenericDAO;

  $term = $_POST['term'];

  $result = $genericDAO->selectAll("User", "nome LIKE '%$term%' OR cpf LIKE '%$term%' OR email LIKE '%$term%'");
  if ($result) {
    if (!is_array($result)) $result = array($result);
    $users = array();
    foreach ($result as $item) {
      $users[] = array(
        "id" => $item->get('id'),
        "nome" => $item->get('nome'),
        "cpf" => $item->get('cpf'),
        "email" => $item->get('email')
      );
    }
    $return['status'] = 1;
    $return['users'] = $users;
  }

  echo json_encode($return);
?>