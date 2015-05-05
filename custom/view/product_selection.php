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
                if ($exemptions) return true;
            }
        }
    }

    return false;
}

    $genericDAO = new GenericDAO;

    $products = $genericDAO->selectAll("Product", "id_father IS NULL");
    if (!$products) Structure::redirWithMessage("Nenhum item cadastrado", "/");

    if (!is_array($products)) $products = array($products);
?>
        <main>
            <header class="center">
                <h1>Selecionar pacotes</h1>
            </header>
            <section class="wrapper">
                <form method="POST" action="<?=APP_URL?>/pagamento/metodo">
                    <?php

                    foreach ($products as $product) :
                        $hasFather = false;
                        $productId = $product->get('id');
                        $exclude = $genericDAO->selectAll("ProductExclude", "id_product1 = $productId OR id_product2 = $productId");

                    ?>
                    <div class="input_line">
                        <div class="input_container two-thirds fnone">
                            <ul class="checkbox">
                                <li>
                                    <input 
                                        type="checkbox" 
                                        id="product<?=$product->get('id')?>" 
                                        name="<?=userHasProduct($user->get('id'), $product->get('id')) ? 'alreadyOwn' : 'products'?>" 
                                        value="<?=$product->get('id')?>"
                                        class="product father <?=$exclude ? 'exclude' : ''?>"
                                        <?=$exclude ? 'data-exclude="'.$exclude->get('id').'"' : ''?>
                                        <?php if (userHasExemption($user->get('id'), $product->get('id')) ||
                                                  userHasProduct($user->get('id'), $product->get('id'))) : ?> 
                                            <?php $hasFather = true; ?>
                                        disabled
                                        checked
                                        <?php endif; ?>
                                    >
                                    <label 
                                        for="product<?=$product->get('id')?>"
                                    >
                                        <?=$product->get('description')?>
                                        - <strong>R$ <span class="price" data-value="<?=$product->get('price')?>"><?=$product->get('price')?></span></strong>
                                    </label>
                                </li>
                                <?php 
                                $children = $genericDAO->selectAll("Product", "id_father = ".$product->get('id')." ORDER BY description");
                                if ($children):
                                    if (!is_array($children)) $children = array($children);
                                    foreach ($children as $child) :
                                        $productId = $child->get('id');
                                        $exclude = $genericDAO->selectAll("ProductExclude", "id_product1 = $productId OR id_product2 = $productId");

                                        $disabled = true;
                                        $checked = false;
                                        if ($hasFather) $disabled = false;
                                        if (userHasExemption($user->get('id'), $child->get('id')) || 
                                            userHasProduct($user->get('id'), $child->get('id'))) {
                                            $disabled = true;
                                            $checked = true;
                                        }

                                ?>
                                <li>
                                    <input 
                                        type="checkbox" 
                                        id="product<?=$child->get('id')?>" 
                                        name="<?=userHasProduct($user->get('id'), $child->get('id')) ? 'alreadyOwn' : 'products'?>" 
                                        value="<?=$child->get('id')?>"
                                        class="product child  <?=$exclude ? 'exclude' : ''?>"
                                        data-father="product<?=$product->get('id')?>"
                                        <?=$exclude ? 'data-exclude="'.$exclude->get('id').'"' : ''?>
                                        <?=$disabled ? 'disabled' : ''?>
                                        <?=$checked ? 'checked' : ''?>
                                    >
                                        <label 
                                            for="product<?=$child->get('id')?>"
                                            <?=$disabled ? 'class="disabled"' : ''?>
                                        >
                                            <?=$child->get('description')?>
                                             - <strong>R$ <span class="price" data-value="<?=$child->get('price')?>"><?=$child->get('price')?></span></strong>
                                        </label>
                                    </li>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
                    <div class="input_line">
                        <div class="input_container two-thirds fnone">
                            <p><strong style="font-size: 24px;">R$ <span id="total">0</span></strong> (total)</p>
                        </div>
                    </div>
                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="next" value="Próximo" class="positive">
                    </div>
                </form>
            </section>
        </main>
        <script>
        function updatePrice(){
            var total = 0;
            $('input.product').each(function(){
                if ($(this).is(":checked")) {
                    $(this).parent().find('.price').each(function(){
                        total += parseFloat($(this).html());
                    });
                }
            });
            $('#total').html(total);
        }

        $(document).ready(function(){
            $('input.father').change(function(){
                var fatherChecked = false;
                if ($(this).is(":checked")) fatherChecked = true;

                var fatherId = $(this).attr("id");

                $('input.child').each(function(){
                    if ($(this).attr("data-father") == fatherId && !$(this).is(':checked')) {
                        if (fatherChecked) {
                            $(this).removeAttr("disabled");
                            $(this).parent().children("label").each(function(){
                                $(this).removeClass("disabled");
                            });
                        } else {
                            $(this).attr("disabled", "disabled");
                            $(this).removeAttr("checked");
                            $(this).parent().children("label").each(function(){
                                $(this).addClass("disabled");
                            });
                            updatePrice();
                        }
                    }
                });
                updatePrice();
            });

            $('input.exclude').change(function(){
                var excludeId = $(this).attr('data-exclude');
                var thisId = $(this).attr('id');
                var isChecked = false;
                if ($(this).is(":checked")) isChecked = true;
                $('input.exclude').each(function(){
                    if ($(this).attr('data-exclude') == excludeId && $(this).attr('id') != thisId) {
                        if (isChecked && !$(this).is(":disabled")) $(this).removeAttr("checked");
                    }
                    updatePrice();
                });
                updatePrice();
            });

            $('input.product').change(function(){
                updatePrice();
            });
        });
        </script>
<?php Structure::footer(); ?>
