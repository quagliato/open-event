<?php
  $user = Structure::verifyAdminSession();
  Structure::header('nude');

  $result = array();

  $genericDAO = new GenericDAO;

  $products = $genericDAO->selectAll("Product", "1=1");
  if ($products) {
    if (!is_array($products)) $products = array($products);
    $auxProducts = array();
    for ($i = 0; $i < sizeof($products); $i++) {
      $auxProducts[$products[$i]->get('id')] = $products[$i];
    }
    $products = $auxProducts;
  }

  $auxEditais = array();
  $editais = $genericDAO->selectAll("Edital", "1=1");
  if ($editais) {
    if (!is_array($editais)) $editais = array($editais);
    for ($i = 0; $i < sizeof($editais); $i++) {
      $auxEditais[$editais[$i]->get('id')] = $editais[$i];
    }
  }
  $editais = $auxEditais;

  $people = $genericDAO->selectAll("User", "1=1 ORDER BY nome");

  $count = 1;
  $lastFirstLetter = "";
  echo "<table style=\"border:none; font-size:10px; width:auto!important;\">";
  echo "<thead>";
  echo "<tr>";
  echo "<td>Contagem</td>";
  echo "<td>Nome</td>";
  echo "<td>CPF</td>";
  echo "<td>Data Nasc.</td>";
  echo "<td>Deficiência</td>";
  echo "<td>E-mail</td>";
  echo "<td>Facebook</td>";
  echo "<td>Tel. Residencial</td>";
  echo "<td>Tel. Celular</td>";
  echo "<td>Instituição de Ensino</td>";
  echo "<td>Curso</td>";
  echo "<td>Período</td>";
  echo "<td>Logradouro</td>";
  echo "<td>Número</td>";
  echo "<td>Complemento</td>";
  echo "<td>Bairro</td>";
  echo "<td>Cidade</td>";
  echo "<td>Estado</td>";
  echo "<td>CEP</td>";
  echo "<td>Emergência - Nome</td>";
  echo "<td>Emergência - Telefone</td>";
  echo "<td>Alergias</td>";
  echo "<td>Medicação Contínua</td>";
  echo "<td>Plano de Saúde</td>";
  echo "<td>Tipo de Alimentação</td>";
  echo "<td>Restrição Alimentar</td>";
  echo "<td>Editais</td>";
  echo "<td>Isenção Total</td>";
  echo "<td style=\"min-width:200px\">Pacotes <b>(Isenção)</b></td>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";

  foreach ($people as $person) {
    $isencaoTotal = 0;
    $pacotes = "";
    $editaisAprovados = "";

    $transactions = $genericDAO->selectAll("Transaction", "status = 1 AND id_user = ".$person->get('id'));
    if ($transactions) {

      $transactionIdsStr = "";
      if (!is_array($transactions)) $transactions = array($transactions);
      for ($i = 0; $i < sizeof($transactions); $i++) {
        $transaction = $transactions[$i];
        if (strlen($transactionIdsStr) > 0) $transactionIdsStr .= ", ";
        $transactionIdsStr .= $transaction->get('id');
        $isencaoTotal += $transaction->get('value_exemption');
      }

      $transactionItems = $genericDAO->selectAll("TransactionItem", "id_transaction IN (".$transactionIdsStr.")");
      if ($transactionItems) {
        if (!is_array($transactionItems)) $transactionItems = array($transactionItems);
        for ($i = 0; $i < sizeof($transactionItems); $i++) {
          $transactionItem = $transactionItems[$i];
          if (!$products || !$products[$transactionItem->get('id_product')]) continue;
          if (strlen($pacotes) > 0) $pacotes .= '<br>';
          $pacotes .= $products[$transactionItem->get('id_product')]->get('description');

          if ($transactionItem->get('vl_exemption') > 0) {
            $pacotes .= " <b>(R$ ".$transactionItem->get('vl_exemption').")</b>";
          }
        }
      }
    }

    if ($editais) {
      $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1 AND id_user = ".$person->get('id'));
      if ($respostasEdital) {
        if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
        for ($i = 0; $i < sizeof($respostasEdital); $i++) {
          $respostaEdital = $respostasEdital[$i];
          if (!$editais[$respostaEdital->get('id_edital')]) continue;
          if (strlen($editaisAprovados) > 0) $editaisAprovados .= ', ';
          $editaisAprovados .= $editais[$respostaEdital->get('id_edital')]->get('nome');
        }
      }
    }

    if ($count % 2 === 0) {
      echo "<tr style=\"background-color:#CCCCCC;\">";
    } else {
      echo "<tr>";
    }
    
    echo "<td>$count</td>";  
    echo "<td>".mb_strtoupper($person->get('nome'))."</td>";
    echo "<td>".$person->get('cpf')."</td>";
    echo "<td>".$person->get('data_nasc')."</td>";
    echo "<td>".$person->get('deficiencia')."</td>";
    echo "<td>".$person->get('email')."</td>";
    echo "<td>".$person->get('facebook')."</td>";
    echo "<td>".$person->get('telefone_residencial')."</td>";
    echo "<td>".$person->get('telefone_celular')."</td>";
    echo "<td>".$person->get('inst_ens')."</td>";
    echo "<td>".$person->get('curso')."</td>";
    echo "<td>".$person->get('periodo')."</td>";
    echo "<td>".$person->get('end_logradouro')."</td>";
    echo "<td>".$person->get('end_numero')."</td>";
    echo "<td>".$person->get('end_complemento')."</td>";
    echo "<td>".$person->get('end_bairro')."</td>";
    echo "<td>".$person->get('end_cidade')."</td>";
    echo "<td>".$person->get('end_estado')."</td>";
    echo "<td>".$person->get('end_cep')."</td>";
    echo "<td>".$person->get('responsavel_nome')."</td>";
    echo "<td>".$person->get('responsavel_telefone')."</td>";
    echo "<td>".$person->get('alergias')."</td>";
    echo "<td>".$person->get('medicacao_continua')."</td>";
    echo "<td>".$person->get('plano_saude')."</td>";
    echo "<td>".$person->get('tipo_alimentacao')."</td>";
    echo "<td>".$person->get('restricao_alimentar')."</td>";
    echo "<td>".$editaisAprovados."</td>";
    echo "<td>".$isencaoTotal."</td>";
    echo "<td>".$pacotes."</td>";
    echo "</tr>";
    $count++;
  }
  echo "</tbody>";
  echo "</table>";
