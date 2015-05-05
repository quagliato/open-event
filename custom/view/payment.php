<?php
    $usuario = Structure::verifySession();
    
    $isencao_dao = new IsencaoDAO;
    $valor_dao = new ValorDAO;
    if ($valor_dao->isMaxReached(0) && !array_key_exists('late', $_POST)) {
        Structure::redirWithMessage("Lote finalizado. Inscricoes encerradas.", "/dashboard"); //TODO: Adicionar acento
    }

    $id_transacao = $_POST['id_transacao'];
    $metodo_pagamento = $_POST['payment'];
    $valor_final = $_POST['valor_final'];

    $transacao_dao = new TransacaoDAO;

    $transacao = $transacao_dao->selectAll("Transacao", "id = $id_transacao");

    $payment = new Payment;

    if ($metodo_pagamento == "BOL") :
        if (!PAY_BOLETO) {
            Structure::redirWithMessage("Erro 305\nO metodo de pagamento BOLETO nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
        }
        
        $pagamento = $payment->pay($usuario->get('id'), $transacao->get('id'), $metodo_pagamento, $valor_final);
        Structure::header();
        echo "<h1>Boleto</h1>";
        echo '<a target="_blank" href="'.$pagamento->get('info').'">Clique aqui para imprimir seu boleto</a>';
        echo "<h3>Guarde sempre o seu comprovante de pagamento.</h3>";
        Structure::footer();

    elseif ($metodo_pagamento == "DEP") :
        if (!PAY_DEPOSITO) {
            Structure::redirWithMessage("Erro 305\nO metodo de pagamento DEPOSITO nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
        }
        
        $pagamento = $payment->pay($usuario->get('id'), $transacao->get('id'), $metodo_pagamento, $valor_final);
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

    elseif ($metodo_pagamento == "PPL") :
        if (!PAY_PAYPAL) {
            Structure::redirWithMessage("Erro 305\nO metodo de pagamento PAYPAL nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
        }

        $pagamento = $payment->pay($usuario->get('id'), $transacao->get('id'), $metodo_pagamento, $valor_final);
        Structure::header();
        $paypal_html = '<h1>PayPal</h1>';
        $paypal_html .= '<h2>Clique no botão abaixo para realizar o pagamento de sua inscrição.</h2>';
        $paypal_html .= '<h3>Utilize o mesmo e-mail que você utilizou em seu cadastro.</h3>';
        $paypal_html .= '<h3>'.PAYPAL_ITEM_NAME.'</h3>';
        $paypal_html .= '<h3>Valor Total: R$ '.$valor_final.'</h3>';
        echo $paypal_html;
        echo $pagamento->get('obs');
        Structure::footer();


    elseif ($metodo_pagamento == "PGS") :
        if (!PAY_PAGSEGURO) {
            Structure::redirWithMessage("Erro 305\nO metodo de pagamento PAGSEGURO nao esta disponivel.", "/dashboard"); //TODO: Adicionar acento
        }

        $pagamento = $payment->pay($usuario->get('id'), $transacao->get('id'), $metodo_pagamento, $valor_final);

        if ($pagamento) {
            Structure::header();
            $html = '<h1>PagSeguro</h1>';
            $html .= '<h2>Clique no link abaixo para realizar o pagamento de sua inscrição.</h2>';
            $html .= '<h3>Utilize o mesmo e-mail que você utilizou em seu cadastro.</h3>';
            $html .= '<h3>Valor Total Final: R$ '.($valor_final * PAGSEGURO_MULTIPLIER).'</h3>';
            $html .= "<p><a href='".$pagamento->get('info')."'>PagSeguro</a></p>";
            echo $html;
            Structure::footer();
        } else {
            Structure::redirWithMessage("Erro 306\nProblemas ao processar seu pagamento. Tente novamente mais tarde. Sua inscricao esta garantida.", "/dashboard"); //TODO: Adicionar acento
        }
    endif;
?>