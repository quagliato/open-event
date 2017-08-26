<?php
  $user = Structure::verifyAdminSession();
  Structure::header('nude');

  $result = array();

  $genericDAO = new GenericDAO;

  $auxProducts = array();
  $products = $genericDAO->selectAll("Product", "1=1");
  if (!$products) throw new Exception('No product found.');
  if (!is_array($products)) $products = array($products);
  for ($i = 0; $i < sizeof($products); $i++) {
    $auxProducts[$products[$i]->get('id')] = $products[$i];
  }
  $products = $auxProducts;

  $auxEditais = array();
  $editais = $genericDAO->selectAll("Edital", "1=1");
  if (!$editais) throw new Exception('No edital found.');
  if (!is_array($editais)) $editais = array($editais);
  for ($i = 0; $i < sizeof($editais); $i++) {
    $auxEditais[$editais[$i]->get('id')] = $editais[$i];
  }
  $editais = $auxEditais;

  $people = $genericDAO->selectAll("User", "1=1 ORDER BY nome");

  $filename = "export-".date('YmdHisv').".csv";
  $filepath = FILES_DIR.$filename;
  $file_url = FILES_URL.$filename;

  $count = 1;
  $firstLine = "\"Contagem\", \"Nome\", \"CPF\", \"Data Nasc.\", \"Deficiência\", \"E-mail\", \"Facebook\", \"Tel. Residencial\", \"Tel. Celular\", \"Instituição de Ensino\", \"Curso\", \"Período\", \"Logradouro\", \"Número\", \"Complemento\", \"Bairro\", \"Cidade\", \"Estado\", \"CEP\", \"Emergência - Nome\", \"Emergência - Telefone\", \"Alergias\", \"Medicação Contínua\", \"Plano de Saúde\", \"Tipo de Alimentação\", \"Restrição Alimentar\", \"Editais\"\n";

  file_put_contents($filepath, $firstLine, FILE_APPEND);


  foreach ($people as $person) {

    $transactions = $genericDAO->selectAll("Transaction", "status = 1 AND id_user = ".$person->get('id'));
    if ($transactions) continue;

    $editaisAprovados = "";
    $respostasEdital = $genericDAO->selectAll("RespostaEdital", "status = 1 AND id_user = ".$person->get('id'));
    if ($respostasEdital) {
      if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
      for ($i = 0; $i < sizeof($respostasEdital); $i++) {
        $respostaEdital = $respostasEdital[$i];
        if (strlen($editaisAprovados) > 0) $editaisAprovados .= ', ';
        $editaisAprovados .= $editais[$respostaEdital->get('id_edital')]->get('nome');
      }
    }

    $line = "";
    $line .= "\"".$count."\",";
    $line .= "\"".mb_strtoupper($person->get('nome'))."\",";
    $line .= "\"".$person->get('cpf')."\",";
    $line .= "\"".$person->get('data_nasc')."\",";
    $line .= "\"".$person->get('deficiencia')."\",";
    $line .= "\"".$person->get('email')."\",";
    $line .= "\"".$person->get('facebook')."\",";
    $line .= "\"".$person->get('telefone_residencial')."\",";
    $line .= "\"".$person->get('telefone_celular')."\",";
    $line .= "\"".$person->get('inst_ens')."\",";
    $line .= "\"".$person->get('curso')."\",";
    $line .= "\"".$person->get('periodo')."\",";
    $line .= "\"".$person->get('end_logradouro')."\",";
    $line .= "\"".$person->get('end_numero')."\",";
    $line .= "\"".$person->get('end_complemento')."\",";
    $line .= "\"".$person->get('end_bairro')."\",";
    $line .= "\"".$person->get('end_cidade')."\",";
    $line .= "\"".$person->get('end_estado')."\",";
    $line .= "\"".$person->get('end_cep')."\",";
    $line .= "\"".$person->get('responsavel_nome')."\",";
    $line .= "\"".$person->get('responsavel_telefone')."\",";
    $line .= "\"".$person->get('alergias')."\",";
    $line .= "\"".$person->get('medicacao_continua')."\",";
    $line .= "\"".$person->get('plano_saude')."\",";
    $line .= "\"".$person->get('tipo_alimentacao')."\",";
    $line .= "\"".$person->get('restricao_alimentar')."\",";
    $line .= "\"".$editaisAprovados."\",";
    $line .= "\n";

    file_put_contents($filepath, $line, FILE_APPEND);

    $count++;
  }

  echo "<p><a href=\"".$file_url."\" target=\"_blank\">Clique aqui</a></p>";
