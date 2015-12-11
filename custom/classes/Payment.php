<?php

use OpenBoleto\Banco\BancoDoBrasil;
use OpenBoleto\Agente;

class Payment {

    private function rollbackTransacaoAndItems($transacao) {
        $transacao_dao = new TransacaoDAO;
        $transacao_item_dao = new TransacaoItemDAO;
        $transacao_item_dao->deleteTransacaoItemByTransacaoId($transacao->get('id')); // Rollback TransacaoItem
        $transacao_dao->deleteTransacaoById($transacao->get('id')); // Rollback Transacao
    }
    
    public function pay($userId, $transacao_id, $payment, $valor_final) {
        if ($payment == "BOL") {
            return $this->payWithBoleto($userId, $transacao_id, $valor_final);
        } elseif ($payment == "PPL") {
            return $this->payWithPayPal($userId, $transacao_id, $valor_final);
        } elseif ($payment == "PGS") {
            return $this->payWithPagSeguro($userId, $transacao_id, $valor_final);
        } elseif ($payment == "DEP") {
            return $this->payWithDeposito($userId, $transacao_id, $valor_final);
        } else {
            return false;
        }
    }

    private function payWithBoleto($userId, $transacao_id, $valor_final) {
        $userDAO = new UserDAO;
        $user = $userDAO->getUserById($userId);

        $transacaoDAO = new TransacaoDAO;
        $transacao = $transacaoDAO->getTransacaoById($transacao_id);

        $sacado = new Agente(
            $user->get('nome'),
            $user->get('cpf'),
            $user->get('end_logradouro')." ".$user->get('end_numero')." ".$user->get('end_complemento')." ".$user->get('end_bairro'),
            $user->get('end_cep'),
            $user->get('end_cidade'),
            $user->get('end_estado')
        );

        $cedente = new Agente(
            CEDENTE_NOME,
            CEDENTE_NR_DOCUMENTO,
            CEDENTE_ENDERECO,
            CEDENTE_CEP,
            CEDENTE_CIDADE,
            CEDENTE_ESTADO
        );

        $venc = new DateTime('now');
        $venc->add(new DateInterval(VENCIMENTO));

        $boleto = new BancoDoBrasil(array(
            // Parâmetros obrigatórios
            'dataVencimento' => $venc,
            'valor' => $valor_final,
            'sequencial' => $transacao->get('id'), // Para gerar o nosso número
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => AGENCIA, // Até 4 dígitos
            'carteira' => CARTEIRA,
            'conta' => CONTA, // Até 8 dígitos
            'convenio' => CONVENIO, // 4, 6 ou 7 dígitos
        ));

        $boleto_output = $boleto->getOutput();

        $pattern2find = '<div class="linha-digitavel">';
        $strpos_start = strpos($boleto_output, $pattern2find) + strlen($pattern2find);
        $linha_digitavel = substr($boleto_output, $strpos_start, 54);

        $pattern2find = '<div class="titulo">Nosso número</div>\n            <div class="conteudo rtl">';
        $strpos_start = strpos($boleto_output, $pattern2find) + strlen($pattern2find);
        $nosso_numero = substr($boleto_output, $strpos_start, 17);

        $obs = str_replace(".", "", str_replace(" ", "", $linha_digitavel));

        $boleto_path = NULL;
        /*
        try {
            $boleto_input = new TempFile($boleto->getOutput());
            $boleto_output = new TempFile();
            $instance = new Converter(new PhantomJS(), $boleto_input, $boleto_output);
            $instance->convert();
            $boleto_path = FILES_DIR.md5(($user->get('id').$transacao->get('id'))).".pdf"; 
            $boleto_output->save($boleto_path);
        } catch (Exception $e) {
        */
            $datahora = new DateTime('now');
            $failsafe_boleto_name = md5(($user->get('id').$transacao->get('id').$datahora->format('Y-m-d H:i:s'))).".html";
            $failsafe_boleto_path = FILES_DIR_FAILSAFE.$failsafe_boleto_name;
            file_put_contents($failsafe_boleto_path, $boleto->getOutput());
            $boleto_path = FILES_URL_FAILSAFE.$failsafe_boleto_name;
        /*
        }
        */

        $pagamento = new Pagamento;
        $pagamento->set('id_transacao', $transacao->get('id'));
        $pagamento->set('metodo_pagto', 'BOL');
        $pagamento->set('info', $boleto_path);
        $pagamento->set('obs', $obs);

        $pagamento_dao = new PagamentoDAO;
        if (!$pagamento_dao->insert($pagamento)) {
            $this->rollbackTransacaoAndItems($transacao);
            Structure::redirWithMessage("Erro304\nProblemas ao criar pagamento. Tente novamente, por favor.", "/dashboard");
        }

        $to = $user->get('email');
        $subject = DEFAULT_EMAIL_SUBJECT;
        $message = DEFAULT_EMAIL_GREETING;
        $message .= "<p>Sua inscrição no N_Goiânia foi realizada.</p>";
        $message .= "<p>O seu boleto vencerá em 3 dias corridos. Após 4 dias, seu pagamento será computado.</p>";
        $message .= "<p>Clique <a href=\"".$boleto_path."\">aqui</a> para visualizar seu boleto.</p>";
        $message .= DEFAULT_EMAIL_SIGN;
        
        $additional_headers = "MIME-Version: 1.0\n";
        $additional_headers .= "Content-type: text/html; utf8";
        $additional_headers .= "From:".DEFAULT_EMAIL_FROM;
        
        mail($to, $subject, $message, $additional_headers);

        return $pagamento;
    }

    private function payWithPayPal($userId, $transacao_id, $valor_final) {
        $valor_final = $valor_final * 1.1;

        $userDAO = new UserDAO;
        $user = $userDAO->getUserByID($userId);

        $transacaoDAO = new TransacaoDAO;
        $transacao = $transacaoDAO->getTransacaoById($transacao_id);

        $paypal_btn = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="margin-top:20px;">';
        $paypal_btn .=  '<input type="hidden" name="cmd" value="_xclick">';
        $paypal_btn .=  '<input type="hidden" name="business" value="'.PAYPAL_EMAIL.'">';
        $paypal_btn .=  '<input type="hidden" name="lc" value="BR">';
        $paypal_btn .=  '<input type="hidden" name="item_name" value="'.PAYPAL_ITEM_NAME.'">';
        $paypal_btn .=  '<input type="hidden" name="item_number" value="'.$transacao->get('id').'">';
        $paypal_btn .=  '<input type="hidden" name="amount" value="'.$valor_final.'">';
        $paypal_btn .=  '<input type="hidden" name="currency_code" value="BRL">';
        $paypal_btn .=  '<input type="hidden" name="button_subtype" value="services">';
        $paypal_btn .=  '<input type="hidden" name="no_note" value="0">';
        $paypal_btn .=  '<input type="hidden" name="tax_rate" value="0.000">';
        $paypal_btn .=  '<input type="hidden" name="shipping" value="0.00">';
        $paypal_btn .=  '<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHostedGuest">';
        $paypal_btn .=  '<input type="image" style="width:auto;" src="https://www.paypalobjects.com/pt_BR/BR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - A maneira fácil e segura de enviar pagamentos online!">';
        $paypal_btn .=  '<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">';
        $paypal_btn .=  '</form>';

        $pagamento = new Pagamento;
        $pagamento->set('id_transacao', $transacao->get('id'));
        $pagamento->set('metodo_pagto', 'PPL');
        $pagamento->set('info', "");
        $pagamento->set('obs', $paypal_btn);

        $pagamento_dao = new PagamentoDAO;
        if (!$pagamento_dao->insert($pagamento)) {
            $this->rollbackTransacaoAndItems($transacao);
            Structure::redirWithMessage("Erro 304\nProblemas ao criar pagamento. Tente novamente, por favor.", "/dashboard");       
        }

        $to = $user->get('email');
        $subject = DEFAULT_EMAIL_SUBJECT;
        $message = DEFAULT_EMAIL_GREETING;
        $message .= "<p>Sua inscrição no ".APP_TITLE." foi realizada.</p>";
        $message .= "<p>Você escolheu pagar utilizando o PayPal. Por favor, aguarde a confirmação da sua incrição via e-mail nos próximos dias.</p>";
        $message .= DEFAULT_EMAIL_SIGN;
        
        $additional_headers = "MIME-Version: 1.0\n";
        $additional_headers .= "Content-type: text/html; utf8";
        $additional_headers .= "From:".DEFAULT_EMAIL_FROM;
        
        mail($to, $subject, $message, $additional_headers);
        
        $paypal_html = '<h1>PayPal</h1>';
        $paypal_html .= '<h2>Clique no botão abaixo para realizar o pagamento de sua inscrição.</h2>';
        $paypal_html .= '<h3>Utilize o mesmo e-mail que você utilizou em seu cadastro.</h3>';
        $paypal_html .= '<h3>'.PAYPAL_ITEM_NAME.'</h3>';
        $paypal_html .= '<h3>Valor Total: R$ '.$valor_final.'</h3>';

        return $pagamento;
    }

    private function payWithDeposito($userId, $transacao_id, $valor_final) {
        $userDAO = new UserDAO;
        $user = $userDAO->getUserByID($userId);

        $transacaoDAO = new TransacaoDAO;
        $transacao = $transacaoDAO->getTransacaoById($transacao_id);

        $pagamento = new Pagamento;
        $pagamento->set('id_transacao', $transacao->get('id'));
        $pagamento->set('metodo_pagto', 'DEP');
        $pagamento->set('info', "");
        $pagamento->set('obs', "");

        $pagamento_dao = new PagamentoDAO;
        if (!$pagamento_dao->insert($pagamento)) {
            $this->rollbackTransacaoAndItems($transacao);
            Structure::redirWithMessage("Erro 304\nProblemas ao criar pagamento. Tente novamente, por favor.", "/dashboard");       
        }

        $to = $user->get('email');
        $subject = DEFAULT_EMAIL_SUBJECT;
        $message = DEFAULT_EMAIL_GREETING;
        $message .= "<p>Sua inscrição no ".APP_TITLE." foi realizada.</p>";
        $message .= "<p>Você escolheu pagar utilizando Depósito Bancário. Por favor, realize o depósito para a conta abaixo e o comprovante para ".DEPOSITO_EMAIL.".</p>";
        $message .= "<p>".DEPOSITO_BANCO."<br />";
        $message .= DEPOSITO_NOME."<br />";
        $message .= "CPF ".DEPOSITO_CPF."<br />";
        $message .= "Agência ".DEPOSITO_AGENCIA."<br />";
        $message .= "Conta ".DEPOSITO_CONTA."<br />";

        $message .= DEFAULT_EMAIL_SIGN;
        
        $additional_headers = "MIME-Version: 1.0\n";
        $additional_headers .= "Content-type: text/html; utf8";
        $additional_headers .= "From:".DEFAULT_EMAIL_FROM;
        
        mail($to, $subject, $message, $additional_headers);
        
        $html = '<h1>Depósito Bancário</h1>';
        $html .= "<p><strong>Você escolheu pagar utilizando Depósito Bancário. Por favor, realize o depósito para a conta abaixo e o comprovante para <em>".DEPOSITO_EMAIL."</em>.</strong></h2>";
        $html .= "<h2>Dados Bancários</h2>";
        $html .= "<p>".DEPOSITO_BANCO."<br />";
        $html .= DEPOSITO_NOME."<br />";
        $html .= "CPF ".DEPOSITO_CPF."<br />";
        $html .= "Agência ".DEPOSITO_AGENCIA."<br />";
        $html .= "Conta ".DEPOSITO_CONTA."<br />";
        $html .= '<h3>Valor Total: R$ '.$valor_final.'</h3>';

        return $pagamento;
    }

    private function payWithPagSeguro($userId, $transactionId, $totalValue) {
        $genericDAO = new GenericDAO;
        $userDAO = new UserDAO;
        $user = $userDAO->getUserByID($userId);

        $transaction = $genericDAO->selectAll("Transaction", "id = $transactionId");
        $transactionItems = $genericDAO->selectAll("TransactionItem", "id_transaction = $transactionId");
        if (!is_array($transactionItems)) $transactionItems = array($transactionItems);

        $paymentRequest = new PagSeguroPaymentRequest();
        $paymentRequest->setCurrency("BRL");

        foreach ($transactionItems as $transactionItem) {
            $product = $genericDAO->selectAll("Product", "id = ".$transactionItem->get('id_product'));

            $vlItem = floatval($transactionItem->get('vl_item'));
            if ($vlItem > 0) {
                $vlItem *= PAGSEGURO_MULTIPLIER;
                $vlItem = number_format($vlItem, 2, '.', '');
                $paymentRequest->addItem($transactionItem->get('id'), $product->get('description'), 1, $vlItem);
            }
        }

        $phone = $user->get('telefone_celular');
        $phone = trim($phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);

        $phoneCode = substr($phone, 0, 2);
        $phoneNumber = substr($phone, 2);

        // $phoneCode = substr($user->get('telefone_celular'), 1, 2);
        // $phoneNumber = str_replace("-", "", trim(substr($user->get('telefone_celular'), 4)));
        
        $paymentRequest->setReference($transactionId);
        $paymentRequest->setMaxAge(259200);
        $paymentRequest->setMaxUses(15);
        $paymentRequest->setSender($user->get('nome'), $user->get('email'), $phoneCode, $phoneNumber);
        
        $paymentRequest->setRedirectUrl(APP_URL."/dashboard");

        try {
            $credentials = new PagSeguroAccountCredentials(PAGSEGURO_EMAIL, PAGSEGURO_TOKEN);
            $url = $paymentRequest->register($credentials);
            if ($url) {
              $now = date('Y-m-d H:i:s');
              $transactionPayment = new TransactionPayment;
              $transactionPayment->set('id_transaction', $transaction->get('id'));
              $transactionPayment->set('dt_payment', $now);
              $transactionPayment->set('type', 'PGS');
              $transactionPayment->set('info', $url);
              $transactionPayment->set('total_value', floatval($transaction->get('total_value') * PAGSEGURO_MULTIPLIER));
              
              if (!$genericDAO->insert($transactionPayment)) {
                return false;
              }
              
              $transactionPayment = $genericDAO->selectAll("TransactionPayment", "dt_payment = '$now' AND type = 'PGS' AND id_transaction = ".$transaction->get('id'));
              if ($transactionPayment) {
                $transaction->set('id_last_payment', $transactionPayment->get('id'));
                
                $to = $user->get('email');
                $subject = DEFAULT_EMAIL_SUBJECT;
                $message = DEFAULT_EMAIL_GREETING;
                $message .= "<p>Sua inscrição no ".APP_TITLE." foi realizada.</p>";
                $message .= "<p>Você escolheu pagar utilizando o PagSeguro. Por favor, aguarde a confirmação da sua incrição via e-mail nos próximos dias.</p>";
                $message .= "<p><a href='$url'>PagSeguro</a></p>";
                $message .= DEFAULT_EMAIL_SIGN;
                
                $additional_headers = "MIME-Version: 1.0\n";
                $additional_headers .= "Content-type: text/html; utf8";
                $additional_headers .= "From: ".APP_TITLE." <".DEFAULT_EMAIL_FROM.">\n";
                $additional_headers .= "Reply-To: ".APP_TITLE." <".DEFAULT_EMAIL_FROM.">";
                
                mail($to, $subject, $message, $additional_headers);
                
                return $transactionPayment;
              }
              
              return false;
            } else {
                return false;
            }
        }  catch (PagSeguroServiceException $e) {
                $log = new LogEngine('payment.log');
                $log->logIt("Transacao".$transactionId." PagSeguro ERROR: ".$e->getMessage());

                Structure::redirWithMessage("Erro399 - Problemas ao criar requisição no PagSeguro. Entre em contato através com o administrador.", "/dashboard");
                return false;
        }
    }

}

?>