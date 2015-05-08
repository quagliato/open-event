<?php
    $user = Structure::verifySession();
    Structure::header();
?>

        <main>
            <header class="center">
                <h1>Escolha o método de pagamento</h1>
            </header>
            <section class="wrapper">

<?php
    $genericDAO = new GenericDAO;

    if (!array_key_exists('id', $_GET)) {
        Structure::redirWithMessage("Erro 556 - Código da Transação não especificado. ", "/dashboard");
    }

    $idTransaction = $_GET['id'];

    $transaction = $genericDAO->selectAll("Transaction", "id = $idTransaction");
    if (!$transaction) {
        Structure::redirWithMessage("Erro 557 - Transação não encontrada.", "/dashboard");
    }

    if (floatval($transaction->get('total_value')) == 0) {
      Structure::redirWithMessage("Error 558 - Pagamento não pode ser realizado para uma inscrição isenta.", "/dashboard");
    }
?>
                <form method="POST" action="<?=APP_URL?>/pagamento">
                <input type="hidden" name="id_transaction" id="id_transaction" value="<?=$transaction->get('id')?>">
                    <div class="input_line">
                        <div class="input_container two-thirds fnone">
                            <ps ><strong style="font-size: 24px;">R$ <span id="total"><?=$transaction->get('total_value')?></span></strong> (total)</p>
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
            </section>
        </main>
<?php Structure::footer(); ?>
