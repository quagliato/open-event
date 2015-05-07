<?php
  $user = Structure::verifySession();
  Structure::header();
  
  $idTransaction = $_POST['id_transaction'];
  $paymentMethod = $_POST['payment'];

  $genericDAO = new GenericDAO;
  $transaction = $genericDAO->selectAll("Transaction", "id = $idTransaction");
 ?>
 
          <main>
            <header class="center">
                <h1>Pagamento</h1>
            </header>
            <section class="wrapper">
<?php

  $payment = new Payment;

  if ($paymentMethod == "BOL") :
      if (!PAY_BOLETO) {
          Structure::redirWithMessage("Erro 305\nO metodo de pagamento BOLETO nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
      }
      
      $pagamento = $payment->pay($usuario->get('id'), $transacao->get('id'), $paymentMethod, $valor_final);
      Structure::header();
      echo "<h1>Boleto</h1>";
      echo '<a target="_blank" href="'.$pagamento->get('info').'">Clique aqui para imprimir seu boleto</a>';
      echo "<h3>Guarde sempre o seu comprovante de pagamento.</h3>";
      Structure::footer();

  elseif ($paymentMethod == "DEP") :
      if (!PAY_DEPOSITO) {
          Structure::redirWithMessage("Erro 305\nO metodo de pagamento DEPOSITO nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
      }
      
      $pagamento = $payment->pay($usuario->get('id'), $transacao->get('id'), $paymentMethod, $valor_final);
      if ($pagamento) {
          Structure::header();
          echo "<h1>Depósito</h1>";
          $html = "";
          $html .= "<p><strong>Você escolheu pagar utilizando Depósito Bancário. Por favor, realize o depósito em até 4 dias úteis para a conta abaixo e envie o comprovante para <em>".DEPOSITO_EMAIL."</em>.</strong></h2>";
          $html .= "<h2>Dados Bancários</h2>";
          $html .= "<p>".DEPOSITO_BANCO."<br />";
          $html .= DEPOSITO_NOME."<br />";
          $html .= "CPF ".DEPOSITO_CPF."<br />";
          $html .= "Agência ".DEPOSITO_AGENCIA."<br />";
          $html .= "Conta ".DEPOSITO_CONTA."<br />";
          $html .= '<h3>Valor Total: R$ '.$valor_final.'</h3>';
          echo $html;
          echo "<h3>Guarde sempre o seu comprovante de pagamento.</h3>";
          Structure::footer();
      } else {
          Structure::redirWithMessage("Erro 306\nProblemas ao processar seu pagamento. Tente novamente mais tarde. Sua inscricao esta garantida.", "/dashboard"); //TODO: Adicionar acento
      }

  elseif ($paymentMethod == "PPL") :
      if (!PAY_PAYPAL) {
          Structure::redirWithMessage("Erro 305\nO metodo de pagamento PAYPAL nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
      }

      $pagamento = $payment->pay($usuario->get('id'), $transacao->get('id'), $paymentMethod, $valor_final);
      Structure::header();
      $paypal_html = '<h2>PayPal</h2>';
      $paypal_html .= '<h2>Clique no botão abaixo para realizar o pagamento de sua inscrição.</h2>';
      $paypal_html .= '<h3>Utilize o mesmo e-mail que você utilizou em seu cadastro.</h3>';
      $paypal_html .= '<h3>'.PAYPAL_ITEM_NAME.'</h3>';
      $paypal_html .= '<h3>Valor Total: R$ '.$valor_final.'</h3>';
      echo $paypal_html;
      echo $pagamento->get('obs');
      Structure::footer();


  elseif ($paymentMethod == "PGS") :
      if (!PAY_PAGSEGURO) {
          Structure::redirWithMessage("Erro 305 - O metodo de pagamento PAGSEGURO nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
      }

      $transactionPayment = $payment->pay($user->get('id'), $transaction->get('id'), $paymentMethod, $transaction->get('total_value'));

      if ($transactionPayment) {
          Structure::header();
          $html = '<h2>PagSeguro</h2>';
          $html .= '<p><strong>R$ '.(floatval($transaction->get('total_value')) * PAGSEGURO_MULTIPLIER).'</strong> <a class="submit positive" href="'.$transactionPayment->get('info').'">Pagar</a></p>';
          $html .= '<p><em>Utilize o mesmo e-mail que você utilizou em seu cadastro.</em></p>';
          $html .= '<p><em>Aguarde a confirmação de seu pagamento em até 3 dias úteis.</em></p>';
          echo $html;
          Structure::footer();
      } else {
          Structure::redirWithMessage("Erro 306 - Problemas ao processar seu pagamento. Tente novamente mais tarde. Sua inscricao esta garantida.", "/dashboard"); //TODO: Adicionar acento
      }
  endif;
?>