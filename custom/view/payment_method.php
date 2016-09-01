<?php
    $user = Structure::verifySession();
    Structure::header();

    if (isMaxReached()) {
      Structure::redirWithMessage("Lote encerrado.", "/dashboard");
    }
?>

        <main>
            <header class="center">
                <h1>Escolha o método de pagamento</h1>
            </header>
            <section class="wrapper">

<?php
    $genericDAO = new GenericDAO;

    $products = $_POST['products'];
    if (!is_array($products)) $products = array($products);

    $transactionItems = array();
    $totalValue = 0;
    $valueExemption = 0;

    foreach ($products as $product) {
        $productObj = $genericDAO->selectAll("Product", "id = $product");
        if ($productObj) {
            $transactionItem = new TransactionItem;
            $transactionItem->set('id_product', $productObj->get('id'));

            $exemption = userHasExemption($user->get('id'), $productObj->get('id'));
            $transactionItem->set('vl_exemption', 0);
            if ($exemption) {
              $exemption = floatval($productObj->get('price')) * floatval($exemption->get('modifier'));
              $transactionItem->set('vl_exemption', $exemption);
              $valueExemption += $exemption;
            }
            $transactionItem->set('vl_item', (floatval($productObj->get('price')) - floatval($transactionItem->get('vl_exemption'))));
            
            $totalValue += floatval($transactionItem->get('vl_item'));

            $transactionItems[] = $transactionItem;
        }
    }

    $now = date('Y-m-d H:i:s');

    $transaction = new Transaction;
    $transaction->set('id_user', $user->get('id'));
    $transaction->set('dt_transaction', $now);
    $transaction->set('total_value', $totalValue);
    $transaction->set('value_exemption', $valueExemption);
    
    $result = $genericDAO->insert($transaction);
    if ($result) :
        $transaction = $genericDAO->selectAll("Transaction", "id_user = ".$user->get('id')." AND dt_transaction = '$now'");
        if ($transaction) :
            foreach ($transactionItems as $transactionItem) {
                $transactionItem->set('id_transaction', $transaction->get('id'));
                $genericDAO->insert($transactionItem);
            }
            
            if ($totalValue == 0 && $valueExemption > 0) : ?>
                <p>Você possui total isenção.</p>
                <p>Sua incrição está <strong>CONFIRMADA.</strong>
            <?php else : ?>
                <form method="POST" action="<?=APP_URL?>/pagamento">
                <input type="hidden" name="id_transaction" id="id_transaction" value="<?=$transaction->get('id')?>">
                    <div class="input_line">
                        <div class="input_container two-thirds fnone">
                            <ps ><strong style="font-size: 24px;">R$ <span id="total"><?=$totalValue?></span></strong> (total)</p>
                        </div>
                    </div>
                    <div class="input_line">
                        <div class="input_container two-thirds fnone">
                        <ul id="checkbox">
                            <?php if (PAY_BOLETO) : ?>
                            <li>
                                <input type="radio" name="payment" id="boleto" value="BOL" <?=DEFAULT_PAYMENT == 'BOL' ? 'checked' : ''?>>
                                <label for="boleto">Boleto</label>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (PAY_PAYPAL): ?>
                            <li>
                                <input type="radio" name="payment" id="paypal" value="PPL" <?=DEFAULT_PAYMENT == 'PPL' ? 'checked' : ''?>>
                                <label for="paypal">PayPal <em>(Acréscimo de 10% no Valor Total.)</em></label>
                            </li>
                            <?php endif; ?>

                            <?php if (PAY_PAGSEGURO): ?>
                            <li>
                                <input type="radio" name="payment" id="pagseguro" value="PGS" <?=DEFAULT_PAYMENT == 'PGS' ? 'checked' : ''?>>
                                <label for="paypal">PagSeguro<?=PAGSEGURO_MULTIPLIER && PAGSEGURO_MULTIPLIER_LABEL ? ' <em>(Adicional de '.PAGSEGURO_MULTIPLIER_LABEL.')</em>' : ''?></label>
                            </li>
                            <?php endif; ?>

                            <?php if (PAY_DEPOSITO): ?>
                            <li>
                                <input type="radio" name="payment" id="deposito" value="DEP" <?=DEFAULT_PAYMENT == 'DEP' ? 'checked' : ''?>>
                                <label for="deposito">Depósito</label>
                            </li>
                            <?php endif; ?>
                        </ul>
                        </div>
                    </div>
                    <div class="input_line submit_line center">
                        <a href="<?=APP_URL?>/dashboard" class="submit negative">Cancelar</a>
                        <input type="submit" name="next" value="Pagar" class="positive">
                    </div>
                </form>
            <?php endif; ?>
            </section>
        </main>
<?php
        endif;
    endif;
?>
<?php Structure::footer(); ?>
