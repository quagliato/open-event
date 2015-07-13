<?php
  $usuario = Structure::verifyAdminSession();
  Structure::header('nude');
  
  $idEdital = false;

  if (array_key_exists("id", $_GET) && $_GET['id'] != "" && !is_null($_GET['id'])) {
    $idEdital = $_GET['id'];
  } else {
    echo "error";
    exit(1);
  }
  
  $genericDAO = new GenericDAO;

  if (!$genericDAO->selectAll("Edital", "id = $idEdital")) {
    echo "error";
    exit(1);
  }

  $firstLine = "";
  $lines = array();
  
  $perguntas = $genericDAO->selectAll("Pergunta", "id_edital = $idEdital");
  if ($perguntas) {
    if (!is_array($perguntas)) $perguntas = array($perguntas);
  }

  $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1 AND id_edital = $idEdital");
  if ($respostasEdital) {
    if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
    foreach ($respostasEdital as $respostaEdital) {
      $line = "";
      $user = $genericDAO->selectAll("Usuario", "id = ".$respostaEdital->get('id_user'));
      
      $line .= "{$user->get('id')},";
      $line .= "\"{$user->get('nome')}\",";
      $line .= "\"{$user->get('email')}\",";

      if (sizeof($lines) === 0) {
        $firstLine .= "\"ID Usuário\",";
        $firstLine .= "\"Nome Usuário\",";
        $firstLine .= "\"Email\",";
      }

      foreach ($perguntas as $pergunta) {
        if (sizeof($lines) === 0) {
          $firstLine .= "\"{$pergunta->get('titulo')}\",";
        }

        $answer = "";
        $respostasPergunta = $genericDAO->selectAll("RespostaPergunta", "id_pergunta = {$pergunta->get('id')} AND id_resposta_edital = {$respostaEdital->get('id')}");
        if ($respostasPergunta) {
          if (!is_array($respostasPergunta)) $respostasPergunta = array($respostasPergunta);
          foreach ($respostasPergunta as $respostaPergunta) {
            if (strlen($answer) > 0) $answer .= ",";
            $valoresPossiveis = $genericDAO->selectAll("ValorPossivel", "id_pergunta = ".$respostaPergunta->get('id_pergunta')." AND valor = '".$respostaPergunta->get('vl_resposta')."'");
            if ($valoresPossiveis) {
              if (is_array($valoresPossiveis)) echo "error"; // error
              else $answer .= "{$valoresPossiveis->get('label')}";
            } else {
              $answer .= "{$respostaPergunta->get('vl_resposta')}";
            }
          }
        }

        $line .= "\"$answer\",";
        $answer = "";
      }

      if (sizeof($lines) === 0) $lines[] = $firstLine;

      $lines[] = $line;
      $line = "";
    }
  }

  foreach ($lines as $line) {
    echo strtr($line, array("<br>" => "", "," => ","))."<br>";
  }
?>
