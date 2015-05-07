<?php
    $user = Structure::verifySession();
    Structure::header();

    if (isMaxReached()) {
        Structure::redirWithMessage("Lote encerrado.", "/dashboard");
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
                                        name="<?=userHasProduct($user->get('id'), $product->get('id')) ? 'alreadyOwn[]' : 'products[]'?>" 
                                        value="<?=$product->get('id')?>"
                                        class="product father <?=$exclude ? 'exclude' : ''?>"
                                        <?=$exclude ? 'data-exclude="'.$exclude->get('id').'"' : ''?>
                                        <?php if (userHasProduct($user->get('id'), $product->get('id'))) : ?> 
                                            <?php $hasFather = true; ?>
                                        disabled
                                        checked
                                        <?php endif; ?>
                                    >
                                    <label 
                                        for="product<?=$product->get('id')?>"
                                    >
                                        <?=$product->get('description')?>
                                        <!--PRICE -->
                                        - <strong>R$ <span class="price" data-value="<?=$product->get('price')?>"><?=$product->get('price')?></span></strong>
                                        <!--/PRICE -->

                                        <!--EXEMPTION -->
                                        <?php 
                                        $exemption = userHasExemption($user->get('id'), $product->get('id'));
                                        if ($exemption) :
                                            $value = floatval($product->get('price')) * floatval($exemption->get('modifier'));
                                        ?>
                                        (Isenção: <strong>R$ <span class="exemption" data-value="<?=$value?>"><?=$value?></span></strong>)
                                        <?php endif; ?>
                                        <!--/EXEMPTION -->

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
                                        if (userHasProduct($user->get('id'), $child->get('id'))) {
                                            $disabled = true;
                                            $checked = true;
                                        }
                                        
                                        if (!is_array($exclude)) $exclude = array($exclude);
                                        foreach ($exclude as $excludeItem) {
                                          if (($excludeItem->get('id_product1') == $productId && userHasProduct($user->get('id'), $excludeItem->get('id_product2'))) ||
                                            ($excludeItem->get('id_product2') == $productId && userHasProduct($user->get('id'), $excludeItem->get('id_product1')))) {
                                              $disabled = true;
                                              $exclude = $excludeItem;
                                          }
                                        }

                                ?>
                                <li>
                                    <input 
                                        type="checkbox" 
                                        id="product<?=$child->get('id')?>" 
                                        name="<?=userHasProduct($user->get('id'), $child->get('id')) ? 'alreadyOwn[]' : 'products[]'?>" 
                                        value="<?=$child->get('id')?>"
                                        class="product child  <?=$exclude ? 'exclude' : ''?>"
                                        data-father="product<?=$product->get('id')?>"
                                        <?=$exclude && !is_array($exclude) ? 'data-exclude="'.$exclude->get('id').'"' : ''?>
                                        <?=$disabled ? 'disabled' : ''?>
                                        <?=$checked ? 'checked' : ''?>
                                    >
                                        <label 
                                            for="product<?=$child->get('id')?>"
                                            <?=$disabled ? 'class="disabled"' : ''?>
                                        >
                                            <?=$child->get('description')?>

                                            <!-- PRICE -->
                                             - <strong>R$ <span class="price" data-value="<?=$child->get('price')?>"><?=$child->get('price')?></span></strong>
                                            <!-- /PRICE-->

                                            <!--EXEMPTION -->
                                            <?php 
                                            $exemption = userHasExemption($user->get('id'), $child->get('id'));
                                            if ($exemption) :
                                                $value = floatval($child->get('price')) * floatval($exemption->get('modifier'));
                                            ?>
                                            (Isenção: <strong>R$ <span class="exemption" data-value="<?=$value?>"><?=$value?></span></strong>)
                                            <?php endif; ?>
                                            <!--/EXEMPTION -->
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

                    <?php
                    $totalValueExemption = getTotalValueExemptions($user->get('id'));
                    echo "<!-- $totalValueExemption -->";
                    if ($totalValueExemption) :
                    ?>
                    <div class="input_line">
                        <div class="input_container two-thirds fnone">
                            <!-- <p><strong>ATENÇÃO!</strong> Você possui isenções. Mais informações na próxima página.</p> -->
                            <p><strong style="font-size: 24px;">R$ <span id="total-exemption">0</span></strong> (isenção total)</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="input_line">
                        <div class="input_container fnone">
                            <p><strong>ATENÇÃO!</strong> Prosseguindo no processo de inscrição você concorda com os termos <a href="<?=TERMS_LINK?>" target="_blank">aqui</a> descritos.</p>
                        </div>
                    </div>

                    <div class="input_line submit_line center">
                        <a href="<?=APP_URL?>/dashboard" class="submit negative">Cancelar</a>
                        <input type="submit" name="next" id="btn_next" value="Próximo" class="positive disabled" disabled>
                    </div>
                </form>
            </section>
        </main>
        <script>
        function updatePrice(){
            var total = 0;
            var totalExemption = 0;
            $('input.product').each(function(){
                if ($(this).is(":checked") && $(this).attr('name').indexOf('products') >= 0) {
                    $(this).parent().find('.price').each(function(){
                        total += parseFloat($(this).html());
                    });
                    $(this).parent().find('.exemption').each(function(){
                        totalExemption += parseFloat($(this).html());
                    });
                }
            });

            if (total > 0) {
                $('#btn_next').removeClass('disabled').removeAttr('disabled');
            } else {
                $('#btn_next').addClass('disabled').attr('disabled', 'disabled');
            }

            $('#total').html(total);
            $('body').find('#total-exemption').html(totalExemption);
        }

        $(document).ready(function(){
            $('input.father').change(function(){
                var fatherChecked = false;
                if ($(this).is(":checked")) fatherChecked = true;

                var fatherId = $(this).attr("id");

                $('input.child').each(function(){
                    if ($(this).attr("data-father") == fatherId) {
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
