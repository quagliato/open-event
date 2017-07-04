<?php
  $user = Structure::verifySession();
  Structure::header();

  if (isMaxReached()) {
    Structure::redirWithMessage("Lote encerrado.", "/dashboard");
  }

  $genericDAO = new GenericDAO;

  $isExempted = getUserExemptions($user->get('id'));
  $now = date("Y-m-d H:i:s");

  $products = false;

  $productsFatherStr = "";
  $productsFather = $genericDAO->selectAll("ProductFather", NULL);
  if ($productsFather) {
    if (!is_array($productsFather)) $productsFather = array($productsFather);
    foreach ($productsFather as $productFather) {
      if (!$genericDAO->selectAll("ProductFather", "id_product = {$productFather->get('id_father')}")) {
        if (strlen($productsFatherStr) > 0) $productsFatherStr .= ", ";
        $productsFatherStr .= $productFather->get('id_father');
      }
    }
  }

  $products = $genericDAO->selectAll("Product", "dt_begin < '$now' AND dt_end > '$now'".(strlen($productsFatherStr) > 0 ? " AND id IN ($productsFatherStr)" : ""));
  /*
  if (!$isExempted) {
      $products = $genericDAO->selectAll("Product", "dt_begin < '$now' AND dt_end > '$now'".(strlen($productsFatherStr) > 0 ? " AND id IN ($productsFatherStr)" : ""));
  } else {
      $products = $genericDAO->selectAll("Product", (strlen($productsFatherStr) > 0 ? " id IN ($productsFatherStr)" : " 1=1")." ORDER BY id LIMIT 1");
  }
  */
  if (!$products) Structure::redirWithMessage("Nenhum item cadastrado", "/dashboard");
  if (!is_array($products)) $products = array($products);


  function onlyOpenProductExclude($exclude) {
    $genericDAO = new GenericDAO;
    if ($exclude && is_array($exclude)) {
      $aux = array();

      foreach ($exclude as $excludeItem) {
        $product1 = $genericDAO->selectAll("Product", "id = ".$excludeItem->get('id_product1'));
        $product2 = $genericDAO->selectAll("Product", "id = ".$excludeItem->get('id_product2'));

        $productToFind = false;

        if ($product1->get('id') == $productId) {
          $productToFind = $product2;
        } else {
          $productToFind = $product1;
        }

        $begin = new DateTime($productToFind->get('dt_begin'));
        $end = new DateTime($productToFind->get('dt_end'));

        $now = new DateTime();

        if ($now > $begin && $now < $end) {
          $aux[] = $excludeItem;
        }
      }

      if (sizeof($aux) == 1) return $aux[0];
      elseif (sizeof($aux) > 1) return ($aux);
      else return false;
    }

    return $exclude;
  }

  function printProducts($products, $hasFather, $level, $fatherId){
    $user = Structure::verifySession();
    $genericDAO = new GenericDAO;
    foreach ($products as $product) {
      if (!isMaxReachedByProd($product->get('id'))) {
        $productId = $product->get('id');

        $disabled = true;
        $checked = false;
        if ($hasFather) $disabled = false;
        $hasProduct = false;
        if (userHasProduct($user->get('id'), $productId)) {
            $disabled = true;
            $checked = true;
            $hasProduct = true;
        }

        $exclude = $genericDAO->selectAll("ProductExclude", "id_product1 = $productId OR id_product2 = $productId");
        if (!is_array($exclude)) $exclude = array($exclude);
        foreach ($exclude as $excludeItem) {
          if (userHasProduct($user->get('id'), $excludeItem->get('id_product1')) || userHasProduct($user->get('id'), $excludeItem->get('id_product2'))) {
            $hasProduct = true;
            $checked = true;
            $disabled = true;
          }
        }

        $exclude = onlyOpenProductExclude($exclude);
        $excludeStr = "";
        foreach ($exclude as $excludeItem) {
          if (($excludeItem->get('id_product1') == $productId && userHasProduct($user->get('id'), $excludeItem->get('id_product2'))) ||
            ($excludeItem->get('id_product2') == $productId && userHasProduct($user->get('id'), $excludeItem->get('id_product1')))) {
              $disabled = true;
              // $exclude = $excludeItem;
          }

          if (strlen($excludeStr) > 0) $excludeStr .= ",";
          $excludeStr .= $excludeItem->get('id');
        }


        $isChild = false;
        if ($level > 0) $isChild = true;
        $hasChildren = false;
        if ($genericDAO->selectAll("ProductFather", "id_father = $productId")) $hasChildren = true;

        $minorDisabled = false;
        ?>

        <li>
            <input
                type="checkbox"
                id="product<?=$productId?>"
                name="<?=$hasProduct || userHasProduct($user->get('id'), $productId) ? 'alreadyOwn[]' : 'products[]'?>"
                value="<?=$productId?>"
                class="
                  product
                  <?=$isChild === true? "child" : ""?>
                  <?=$hasChildren === true ? "father" : ""?>
                  <?=$exclude ? 'exclude' : ''?>
                  <?=$minorDisabled ? 'minor-disabled' : ""?>
                "

                <?=$fatherId && $isChild ? 'data-father="product'.$fatherId.'"' : ''?>
                <?=$exclude ? (is_array($exclude) ? 'data-exclude="'.$excludeStr.'"' : 'data-exclude="'.$exclude->get('id').'"') : ''?>
                <?=$disabled ? 'disabled' : ''?>
                <?=$checked ? 'checked' : ''?>
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
        $children = $genericDAO->selectAll("ProductFather", "id_father = ".$productId);
        if ($children) {
          $strChildren = "";
          if (!is_array($children)) $children = array($children);
          foreach ($children as $child) {
            if (strlen($strChildren) > 0) $strChildren .= ", ";
            $strChildren .= $child->get('id_product');
          }
          $children = $strChildren;
        }
        if (strlen($children) > 0) {
          $children = $genericDAO->selectAll("Product", "id IN ($children)");
          if ($children) {
            if (!is_array($children)) $children = array($children);
            $nextLevel = $level + 1;
            printProducts($children, $hasProduct, $nextLevel, $productId);
          }
        }
      }
    }
  }
?>
        <main>
            <header class="center">
                <h1>Selecionar pacotes</h1>
            </header>
            <section class="wrapper">
                <form method="POST" action="<?=APP_URL?>/pagamento/metodo">
                    <div class="input_line">
                      <div class="input_container full">
                        <p class="fg-red">Após selecionar o pacote e ir para a próxima tela, <strong>sua opção não poderá ser alterada</strong>.</p>
                      </div>
                    </div>
                    <div class="input_line">
                        <div class="input_container two-thirds fnone">
                            <ul class="checkbox">
                            <?php
                              printProducts($products, true, true, 0);
                            ?>
                            </ul>
                        </div>
                    </div>
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
                    if ($(this).attr("data-father") == fatherId && !$(this).attr("checked")) {
                        var canEnable = true;
                        if ($(this).attr('data-father')) {
                            var thisProduct = $(this).attr('value');
                            var dataFather = $(this).attr('data-father');
                            $('input.child').each(function(){
                                if ($(this).attr('data-father') == dataFather && $(this).attr('value') != thisProduct && $(this).attr("checked") || $(this).hasClass("minor-disabled")) {
                                    canEnable = false;
                                }
                            });
                        }

                        if (fatherChecked && canEnable) {
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
                if ($(this).hasClass("minor-disabled")) {
                  $(this).removeAttr("checked");
                  $(this).attr("disabled", "disabled");
                  return;
                }


                var clickSource = $(this);

                var excludeIds = $(this).attr('data-exclude').split(",");
                var thisId = $(this).attr('id');
                var isChecked = false;

                if ($(this).is(":checked")) isChecked = true;

                $('input.exclude').each(function(){
                    // Search the other pair of exclude
                    var foundEqual = false;
                    var thisExcludeIds = $(this).attr('data-exclude').split(",");
                    for (var i = 0; i < excludeIds.length; i++) {
                      for (var j = 0; j < thisExcludeIds.length; j++) {
                        if (excludeIds[i] == thisExcludeIds[j]) foundEqual = true;
                      }
                    }

                    if ($(this).attr('data-exclude') != undefined && foundEqual == true && $(this).attr('id') != thisId) {
                        <?php if (DEBUG !== false): ?>
                        console.log(isChecked);
                        console.log(!$(this).is(":disabled"));
                        console.log($(this).attr('name').indexOf('alreadyOwn') === -1);
                        console.log(isChecked && !$(this).is(":disabled") && $(this).attr('name').indexOf('alreadyOwn') === -1);
                        <?php endif; ?>

                        // If the click source it's checked and this is now disabled
                        if (isChecked &&
                            (
                              (
                                !$(this).is(":disabled") &&
                                $(this).attr('name').indexOf('alreadyOwn') == -1
                              ) ||
                              (
                                $(this).is(":disabled") &&
                                $(this).attr('name').indexOf('product') > -1
                              )
                            )
                          ) {

                            // Uncheck the pair
                            $(this).removeAttr("checked");

                            // If the pair is a father
                            if ($(this).hasClass("father")) {

                                // Finds its children and disable then;
                                var fatherId = $(this).attr('id');
                                $('input.child').each(function(){
                                    if ($(this).attr('data-father') == fatherId) {
                                        $(this).removeAttr("checked");
                                        $(this).attr("disabled", "disabled");
                                        $(this).parent().find('label').addClass("disabled");
                                    }
                                });
                            }
                        } else {
                            clickSource.removeAttr("checked");
                            // If the pair is a father
                            if (clickSource.hasClass("father")) {

                                // Finds its children and disable then;
                                var fatherId = clickSource.attr('id');
                                $('input.child').each(function(){
                                    if ($(this).attr('data-father') == fatherId) {
                                        $(this).removeAttr("checked");
                                        $(this).attr("disabled", "disabled");
                                        $(this).parent().find('label').addClass("disabled");
                                    }
                                });
                            }
                        }
                    }
                    updatePrice();
                });
                updatePrice();
            });

            $('input.product').change(function(){
                updatePrice();
            });
            updatePrice();
        });
        </script>
<?php Structure::footer(); ?>
