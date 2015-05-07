<h2>Inscrições</h2>
<?php
    $genericDAO = new GenericDAO;
    $user = $genericDAO->selectAll("Usuario", "id = ".$_SESSION['user_id']);
    $transactions = $genericDAO->selectAll("Transaction", "id_user = ".$user->get('id'));
    if ($transactions) {
        if (!is_array($transactions)) $transactions = array($transactions);
        foreach ($transactions as $transaction) {
?>
    <hr>
    <p>Inscrição <?=$transaction->get('id')?> / Valor Total: R$ <strong><?=$transaction->get('total_value')?></strong><?=$transaction->get('value_exemption') > 0 ? 'Isenção: R$ <strong>'.$transaction->get('value_exemption').'</strong>' : ''?></p>
<?php
            $transactionItems = $genericDAO->selectAll("TransactionItem", "id_transaction = ".$transaction->get('id'));
            if ($transactionItems) {
                if (!is_array($transactionItems)) $transactionItems = array($transactionItems);
                foreach ($transactionItems as $transactionItem) {
                    $product = $genericDAO->selectAll("Product", "id = ".$transactionItem->get('id_product'));
?>
                <p>&nbsp;&nbsp;&nbsp;<?=$transactionItem->get('id')?> - <?=$product->get('description')?> / Valor Total: R$ <strong><?=$transactionItem->get('vl_item')?></strong><?=$transaction->get('value_exemption') > 0 ? 'Isenção: R$ <strong>'.$transactionItem->get('vl_exemption').'</strong>' : ''?></p>
<?php
                }
            }
        }
    }
?>
<hr>
<?php if (!isMaxReached()) : ?>
    <p><a href="<?=APP_URL?>/pacotes">Faça sua inscrição ou compre pacotes adicionais.</a></p>
<?php else: ?>
    <p>Inscrições fechadas no momento.</p>
<?php endif; ?>

<?php
    $editalDAO = new editalDAO;
    $respostaEditalDAO = new RespostaEditalDAO;
    $editais = $editalDAO->getOpenEdital();
    if ($editais) :
?>
    <h2>Editais abertos</h2>
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