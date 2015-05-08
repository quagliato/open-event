<h2>Inscrições</h2>
<style>
table.noline { border: none; }
table.noline tr { border: none; }
table.noline tr td{ border: none; }
table.noline thead { border: none; }
table.noline thead td{ border: none; }
.bb1s{ border-bottom: #666666 1px solid !important; }
.bt1s{ border-top: #666666 1px solid !important; }
</style>
<table class="noline">
    <thead>
        <td class="center tenth">Código</td>
        <td class="fourth">Descrição</td>
        <td class="right tenth">Valor</td>
        <td class="right tenth">Isenção</td>
        <td class="third">Status</td>
        <td class="tenth">Pagamento</td>
    </thead>
<?php
    $genericDAO = new GenericDAO;
    $user = $genericDAO->selectAll("Usuario", "id = ".$_SESSION['user_id']);
    $transactions = $genericDAO->selectAll("Transaction", "id_user = ".$user->get('id'));
    if ($transactions) {
        if (!is_array($transactions)) $transactions = array($transactions);
        foreach ($transactions as $transaction) {
            $payment  = false;
            if ($transaction->get('id_last_payment') == '' || is_null($transaction->get('id_last_payment'))) {
                $payments = $genericDAO->selectAll("TransactionPayment", "id_transaction = ".$transaction->get('id')." ORDER BY dt_payment DESC");
                if ($payments) {
                    if (!is_array($payments)) {
                        $payment = $payments;
                    } else {
                        $payment = $payment[0];
                    }
                }
            } else {
                $payment = $genericDAO->selectAll("TransactionPayment", "id = ".$transaction->get('id_last_payment'));
            }
            $transactionStatus = "";
            if ($transaction->get('status') == 0) $transactionStatus = "Aguardando Confirmação";
            if ($transaction->get('status') == 1) $transactionStatus = "Inscrição Confirmada";
            if ($transaction->get('status') == 2) $transactionStatus = "Credenciado";
            if ($transaction->get('status') == 3) $transactionStatus = "Inscrição Cancelada";
?>
    <tr>
        <td class="center"><?=$transaction->get('id')?></td>
        <td></td>
        <td class="right">R$ <?=$transaction->get('total_value')?></td>
        <td class="right">R$ <?=$transaction->get('value_exemption')?></td>
        <td><?=$transactionStatus?></td>
        <?php if($transaction->get('status') < 2) : ?>
            <?php if($payment) : ?>
                <td><a href="<?=$payment->get('info')?>">Pagar</a></td>
            <?php else : ?>
                <td><a href="<?=APP_URL?>/pagamento/metodo/late?id=<?=$transaction->get('id')?>">Pagar</a></td>
            <?php endif; ?>
        <?php endif; ?>
    </tr>
<?php
            $transactionItems = $genericDAO->selectAll("TransactionItem", "id_transaction = ".$transaction->get('id'));
            if ($transactionItems) {
                if (!is_array($transactionItems)) $transactionItems = array($transactionItems);
                foreach ($transactionItems as $transactionItem) {
                    $product = $genericDAO->selectAll("Product", "id = ".$transactionItem->get('id_product'));
?>
                <tr>
                    <td></td>
                    <td><?=$product->get('description')?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
<?php
                }
            }
        }
    }
?>
</table>
<?php if (!isMaxReached()) : ?>
    <p><h3><a href="<?=APP_URL?>/pacotes">Faça sua inscrição ou compre pacotes adicionais.</a></h3></p>
<?php else: ?>
    <p><h3>Inscrições fechadas no momento.</h3></p>
<?php endif; ?>

<hr>

<?php
    $editalDAO = new editalDAO;
    $respostaEditalDAO = new RespostaEditalDAO;
    $editais = $editalDAO->getOpenEdital();
    if ($editais) :
?>
    <h2>Editais</h2>
    <p class="light">Os editais são o melhor caminho para você participar ativamente na construção de um encontro único. Leia o manual com as instruções para cada edital e inscreva-se em quantos desejar. <strong>Estamos torcendo por você (:</strong></p>
    <ul id="edital_list" class="wrapper">
<?php
        if (!is_array($editais)) :
          $editais = array($editais);
        endif;
        foreach ($editais as $edital) :
            $hasAnsweredEdital = $respostaEditalDAO->hasAnsweredEdital($usuario->get('id'), $edital->get('id'));
?>
        <li>
            <span class="upper"><?=$edital->get('nome')?>
                <?php if ($hasAnsweredEdital) : ?>
                <span class="no-transform note">
                    Você respondeu esse edital há <?=Utils::getRelativeDate(new DateTime($hasAnsweredEdital->get('dt_fim_resposta')))?>.
                </span>
                <?php endif; ?>
            </span>
            <span class="fright">
                <a href="<?=APP_URL?>/edital?id=<?=$edital->get('id')?>">Inscrição</a>
            </span>
        </li>
<?php
        endforeach;
?>
    </ul>
<?php
    else:
?>
    <h3>Nenhum edital aberto.</h3>
<?php
    endif;
?>
