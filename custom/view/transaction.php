<?php
    $user = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $user = false;
    $transactions = false;
    $editais = false;
    if (array_key_exists('idUser', $_GET) && !is_null($_GET['idUser']) && $_GET['idUser'] != "") {
      $user = $genericDAO->selectAll("User", "id = {$_GET['idUser']}");
      if (!$user) {
        // error
      } else {
        $transactions = $genericDAO->selectAll("Transaction", "id_user = {$user->get('id')} ORDER BY id ASC");
        if (!$transactions) {
          // error
        } else {
          if (!is_array($transactions)) $transactions = array($transactions);
        }
      }
    }

    if ($user) {
      $respostasEdital = $genericDAO->selectAll("RespostaEdital", "id_user = {$user->get('id')}");
      if ($respostaEdital) {
        if (!is_array($respostasEdital)) $respostasEdital = array($respostasEdital);
        $aux = array();
        foreach ($respostasEdital as $respostaEdital) {
          $edital = $genericDAO->selectAll("Edital", "id = {$respostaEdital->get('id_edital')}");
          if ($edital) {
            $aux[] = $edital;
          }
        }
      }

      $editais = $aux;
    }
?>
        <main>
          <header class="center">
            <h1>Credenciamento</h1>
          </header>

          <section class="wrapper center">
            <div class="input_line">
              <div class="input_container full">
                <label>Nome</label>
                <h1><?=$user->get('nome')?></h1>
              </div>
            </div>
            <div class="input_line">
              <div class="input_container fourth">
                <label>CPF</label>
                <p><?=$user->get('cpf')?></p>
              </div>
              <div class="input_container fourth">
                <label>Data de Nascimento</label>
                <p><?=$user->get('data_nasc')?></p>
              </div>

              <div class="input_container fourth">
                <label>Contato de Emergência</label>
                <p><?=$user->get('responsavel_nome')?></p>
              </div>

              <div class="input_container fourth last">
                <label>Contato de Emergência - Telefone</label>
                <p><?=$user->get('responsavel_telefone')?></p>
              </div>
              
            </div>
            <div class="input_line">
              <div class="input_container fourth">
                <label>Deficiência</label>
                <p><?=strlen($user->get('deficiencia')) == 0 ? "---" : $user->get('deficiencia')?></p>
              </div>
              <div class="input_container fourth">
                <label>Alergia</label>
                <p><?=strlen($user->get('alergias')) == 0 ? "---" : $user->get('alergias')?></p>
              </div>
              <div class="input_container fourth">
                <label>Medicação Contínua</label>
                <p><?=strlen($user->get('medicacao_continua')) == 0 ? "---" : $user->get('medicacao_continua')?></p>
              </div>
              <div class="input_container fourth last">
                <label>Plano de Saúde</label>
                <p><?=strlen($user->get('plano_saude')) == 0 ? "---" : $user->get('plano_saude')?></p>
              </div>
            </div>
            <div class="input_line">
              <div class="input_container fourth">
                <label>Alimentação</label>
                <p><?=$user->get('tipo_alimentacao')?></p>
              </div>
              <div class="input_container fourth">
                <label>E-mail</label>
                <p><?=$user->get('email')?></p>
              </div>
              <div class="input_container fourth">
                <label>Telefone Residencial</label>
                <p><?=$user->get('telefone_residencial')?></p>
              </div>
              <div class="input_container fourth last">
                <label>Telefone Celular</label>
                <p><?=$user->get('telefone_celular')?></p>
              </div>
            </div>

            <?php if (sizeof($editais) > 0) : ?>
            <hr>
            <h2 class="center">Editais</h2>
            <div class="input_line mt10">
              <div class="input_container full">
              <?php
                $editaisStr = "";
                foreach ($editais as $edital) :
                  if (strlen($editaisStr) > 0) $editaisStr .= ", ";
                  $editaisStr .= $edital->get('nome');
                endforeach;
              ?>
              <p><strong>Selecionado em:</strong> <?=$editaisStr?></strong></p>
              </div>
            </div>
            <?php endif; ?>

            <?php if (sizeof($transactions) > 0) : ?>
            <hr>
            <h2 class="center">Transações</h2>
            <?php
            $hasConfirmed = false;
            $hasCredenciado = false;
            foreach ($transactions as $transaction) :
              if ($transaction->get('status') == 1) $hasConfirmed = true;
              if ($transaction->get('status') == 2) $hasCredenciado = true;

              $itensStr = "";
              $transactionItems = $genericDAO->selectAll("TransactionItem", "id_transaction = {$transaction->get('id')}");
              if ($transactionItems) {
                if (!is_array($transactionItems)) $transactionItems = array($transactionItems);
                foreach ($transactionItems as $transactionItem) {
                  $product = $genericDAO->selectAll("Product", "id = {$transactionItem->get('id_product')}");
                  if ($product && $product->get('price') > 0) {
                    if (strlen($itensStr) > 0) $itensStr .= "<br>";
                    $itensStr .= "- ";
                    if (strlen($product->get('description')) > 60) {
                      $itensStr .= substr($product->get('description'), 0, 20);
                      $itensStr .= "...";
                      $itensStr .= substr($product->get('description'), (strlen($product->get('description')) - 8));
                    } else {
                      $itensStr .= $product->get('description');
                    }
                  } else {
                    // error
                  }
                }
              } else {
                // error
              }
            ?>
            <div class="input_line">
              <div class="input_container tenth">
                <label>Código</label>
                <p><?=$transaction->get('id')?></p>
              </div>
              <div class="input_container eigth">
                <label>Data</label>
                <p><?=Utils::sqlTimestamp2BrFormat($transaction->get('dt_transaction'))?></p>
              </div>
              <div class="input_container sixth">
                <label>Status</label>
                <p><?=$transaction->get('status') == 1 ? "Confirmada" : ($transaction->get('status') == 0 ? "Pagamento Pendente" : ($transaction->get('status') == 3 ? "Cancelada" : ($transaction->get('status') == 2 ? "Credenciado" : "")))?></p>
              </div>
              <div class="input_container tenth">
                <label>Valor Total</label>
                <p>R$ <?=$transaction->get('total_value')?></p>
              </div>
              <div class="input_container eighth">
                <label>Total da Isenção</label>
                <p>R$ <?=$transaction->get('value_exemption')?></p>
              </div>
              <div class="input_container fourth last">
                <label>Itens da Transação</label>
                <p><?=$itensStr?></p>
              </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <form method="POST" action="<?=APP_URL?>/admin/transaction/action/confirm" class="new_submit">
              <input type="hidden" name="idUser" value="<?=$user->get('id')?>">
              <div class="input_line submit_line center">
                <a class="submit negative cancel" href="#">Voltar</a>
                <?php if ($hasConfirmed && !$hasCredenciado) : ?>
                <input type="submit" name="credenciar" value="Credenciar" class="positive">
                <?php endif; ?>
              </div>
            </form>
          </section>
        </main>
<?php Structure::footer(); ?>
