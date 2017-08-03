<?php
  $user = Structure::verifyAdminSession();
  Structure::header('nude');
?>
<style>
@media print
{
  table { page-break-after:always }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
}
</style>
<?php

  function removeAccents($str) {
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
    return str_replace($a, $b, $str);
  }

  echo "<h1>Lista de Credenciamento</h1>";

  $result = array();

  $status = false;
  if (array_key_exists('status', $_GET) && $_GET['status'] != "" && !is_null($_GET['status'])) {
    $status = $_GET['status'];
    $str = "- Status: $status - ";
    switch($status) {
      case 0:
        $str .= "pendentes pagamento"; break;
      case 1:
        $str .= "confirmadas"; break;
      case 2:
        $str .= "credenciadas"; break;
      case 3:
        $str .= "canceladas"; break;
    }

    $str = "<p>$str</p>";
    echo "$str";
  }

  $show_edital = false;
  if (array_key_exists('show_edital', $_GET) && $_GET['show_edital'] != "" && !is_null($_GET['show_edital'])) {
    $only_edital = intval($_GET['show_edital']);
    echo "<p>- Selecionados em edital</p>";
  }

  $show_exempted = false;
  if (array_key_exists('show_exempted', $_GET) && $_GET['show_exempted'] != "" && !is_null($_GET['show_exempted'])) {
    $only_exempted = intval($_GET['show_exempted']);
    echo "<p>- Inscritos com isenção</p>";
  }

  $only_edital = false;
  if (array_key_exists('only_edital', $_GET) && $_GET['only_edital'] != "" && !is_null($_GET['only_edital'])) {
    $only_edital = intval($_GET['only_edital']);
    if ($only_edital === 1) $show_edital = 1;
    echo "<p>- Somente selecionados em edital</p>";
  }

  $only_exempted = false;
  if (array_key_exists('only_exempted', $_GET) && $_GET['only_exempted'] != "" && !is_null($_GET['only_exempted'])) {
    $only_exempted = intval($_GET['only_exempted']);
    if ($only_exempted === 1) $show_exempted = 1;
    echo "<p>- Somente inscritos com isenção</p>";
  }

  $genericDAO = new GenericDAO;

  $auxProducts = array();
  $products = $genericDAO->selectAll("Product", "1=1");
  if (!$products) throw new Exception('No product found.');
  for ($i = 0; $i < sizeof($products); $i++) {
    $auxProducts[$products[$i]->get('id')] = $products[$i];
  }
  $products = $auxProducts;

  $auxEditais = array();
  $editais = $genericDAO->selectAll("Edital", "1=1");
  if (!$editais) throw new Exception('No edital found.');
  for ($i = 0; $i < sizeof($editais); $i++) {
    $auxEditais[$editais[$i]->get('id')] = $editais[$i];
  }
  $editais = $auxEditais;

  $people = $genericDAO->selectAll("User", "1=1 ORDER BY nome");

  $count = 1;

  $letter = "";
  foreach ($people as $person) {

    $where = "id_user = ".$person->get('id');
    if ($status !== false) {
      $where .= " AND status = $status";
    }

    $transactions = $genericDAO->selectAll("Transaction", $where);
    if (!$transactions) continue;

    $isencaoTotal = 0;
    $transactionIdsStr = "";
    if (!is_array($transactions)) $transactions = array($transactions);
    for ($i = 0; $i < sizeof($transactions); $i++) {
      $transaction = $transactions[$i];
      if (strlen($transactionIdsStr) > 0) $transactionIdsStr .= ", ";
      $transactionIdsStr .= $transaction->get('id');
      $isencaoTotal += $transaction->get('value_exemption');
    }

    if ($only_exempted === 1 && $isencaoTotal === 0) continue;
    if ($isencaoTotal > 0 && $show_exempted !== 1) continue;

    $pacotes = "";
    $transactionItems = $genericDAO->selectAll("TransactionItem", "id_transaction IN (".$transactionIdsStr.")");
    if (!$transactionItems) continue;
    if (!is_array($transactionItems)) $transactionItems = array($transactionItems);
    $pacotes .= "<ul>";
    for ($i = 0; $i < sizeof($transactionItems); $i++) {
      $transactionItem = $transactionItems[$i];
      $pacotes .= "<li>&nbsp;&#8226;&nbsp;".$products[$transactionItem->get('id_product')]->get('description');

      if ($transactionItem->get('vl_exemption') > 0) {
        $pacotes .= " <b>(R$ ".$transactionItem->get('vl_exemption').")</b>";
      }

      $pacotes .= "</li>";
    }
    $pacotes .= "</ul>";

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

    if ($only_edital === 1 && $editaisAprovados === "") continue;
    if ($editaisAprovados !== "" && $show_edital !== 1) continue;

    $newLetter = removeAccents(Normalizer::normalize(mb_substr($person->get('nome'), 0, 1), Normalizer::FORM_C));
    if (urlencode(strtoupper($newLetter)) !== urlencode(strtoupper($letter))) {
      if ($count > 1) {
        echo "</tbody></table>";
      }

      echo "<h2 style=\"margin-top: 30px;\">$newLetter</h2>";
      echo "<table style=\"border:none; font-size:10px; width:auto!important;\">";
      echo "<thead>";
      echo "<tr>";
      echo "<td></td>";
      echo "<td>Credenciado</td>";
      echo "<td>Nome</td>";
      echo "<td>CPF</td>";
      echo "<td>Data Nasc.</td>";
      echo "<td>Deficiência</td>";
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

      $letter = "$newLetter";
    }

    if ($count % 2 === 0) {
      echo "<tr style=\"background-color:#CCCCCC;\">";
    } else {
      echo "<tr>";
    }
    
    echo "<td>$count</td>";  
    echo "<td>&nbsp;&nbsp;&nbsp</td>";
    echo "<td>".mb_strtoupper($person->get('nome'))."</td>";
    echo "<td>".$person->get('cpf')."</td>";
    echo "<td>".$person->get('data_nasc')."</td>";
    echo "<td>".$person->get('deficiencia')."</td>";
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
