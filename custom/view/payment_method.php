<?php
    $user = Structure::verifySession();
    Structure::header();

function userHasProduct($idUser, $idProduct) {
    $genericDAO = new GenericDAO;
    $transactions = $genericDAO->selectAll("Transaction", "id_user = $idUser AND (status = 1 OR status = 0)");
    if ($transactions) {
        if (!is_array($transactions)) $transactions = array($transactions);
        foreach ($transactions as $transaction) {
            $transactionsItems = $genericDAO->selectAll("TransactionItem", "id_product = $idProduct AND id_transaction = ".$transaction->get('id'));
            if ($transactionsItems) return true;
        }
    }

    return false;
}

function userHasExemption($idUser, $idProduct) {
    $genericDAO = new GenericDAO;
    $selectedEditals = $genericDAO->selectAll("RespostaEdital", "id_user = $idUser");
    if ($selectedEditals) {
        if (!is_array($selectedEditals)) $selectedEditals = array($selectedEditals);
        foreach ($selectedEditals as $selectedEdital) {
            $edital = $genericDAO->selectAll("Edital", "id = ".$selectedEdital->get('id'));
            if ($edital && sizeof($edital) > 0) {
                $exemptions = $genericDAO->selectAll("Exemption", "id_product = $idProduct AND id_edital = ".$edital->get('id'));
                return $exemptions;
            }
        }
    }

    return false;
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
    
    echo "<pre>";
    var_dump($products);
    echo "</pre>";

    foreach ($products as $product) {
        echo "<p>PRODUCT: $product</p>";
        echo "<h2>PRODUCT OBJ</h2>";
        echo "<pre>";
        $productObj = $genericDAO->selectAll("Product", "id = $product");
        var_dump($productObj);
        echo "</pre>";
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
            
            echo "<h2>TRANSACTION ITEM</h2>";
            echo "<pre>";
            var_dump($transactionItem);
            echo "</pre>";

            $totalValue += floatval($transactionItem->get('vl_item'));
            var_dump($totalValue);

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
    var_dump($result);
    if ($result) :
        $transaction = $genericDAO->selectAll("Transaction", "id_user = ".$user->get('id')." AND dt_transaction = '$now'");
        var_dump($transaction);
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
                                <input type="radio" name="payment" id="boleto" value="BOL">
                                <label for="boleto">Boleto</label>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (PAY_PAYPAL): ?>
                            <li>
                                <input type="radio" name="payment" id="paypal" value="PPL">
                                <label for="paypal">PayPal <em>(Acréscimo de 10% no Valor Total.)</em></label>
                            </li>
                            <?php endif; ?>

                            <?php if (PAY_PAGSEGURO): ?>
                            <li>
                                <input type="radio" name="payment" id="pagseguro" value="PGS">
                                <label for="paypal">PagSeguro</label>
                            </li>
                            <?php endif; ?>

                            <?php if (PAY_DEPOSITO): ?>
                            <li>
                                <input type="radio" name="payment" id="deposito" value="DEP">
                                <label for="deposito">Depósito</label>
                            </li>
                            <?php endif; ?>
                        </ul>
                        </div>
                    </div>
                    <div class="input_line submit_line right">
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
