<?php
  $user = Structure::verifyAdminSession();
  Structure::header();

  $genericDAO = new GenericDAO;
?>
  <main>
    <header class="center">
      <h1>InfoPanel</h1>
    </header>
    <section class="wrapper">
      <h2>Editais</h2>
      <?php
          $editalDAO = new EditalDAO;
          $editais = $editalDAO->selectAll("Edital", NULL);
          if ($editais) :
              if (!is_array($editais)) $editais = array($editais);
      ?>
      <ul id="info">
          <?php foreach ($editais as $edital) : ?>
          <li class="third fleft">
              <p class="title center upper thin"><?=$edital->get('nome')?></p>
              <p class="number center light"><?=$editalDAO->countAnswersPerEdital($edital->get('id'))?></p>
          </li>
          <?php endforeach; ?>
      </ul>
      <?php endif; ?>

      <h2>Inscrições</h2>

      <?php
        $status = array(
          0 => "Pendentes",
          1 => "Confirmadas",
          2 => "Credenciadas",
          3 => "Canceladas"
        );

        foreach ($status as $statusId => $statusDesc) :
      ?>
        <h3><?=$statusDesc?></h3>
        <ul id="info">
        <?php
          $products = $genericDAO->selectAll("Product", NULL);
          if ($products) {
            if (!is_array($products)) $products = array($products);
            $productCount = array();

            $divisor = "full";
            if (sizeof($products) % 5 === 0) $divisor = "fifth";
            else if (sizeof($products) % 4 === 0) $divisor = "fourth";
            else if (sizeof($products) % 3 === 0) $divisor = "third";
            else if (sizeof($products) % 2 === 0) $divisor = "half";
            else if (sizeof($products) > 5) $divisor = "third";

            foreach($products as $product) {
              $productCount[$product->get('id')] = 0;
              $transactionItems = $genericDAO->selectAll("TransactionItem", "id_product = {$product->get('id')}");
              if ($transactionItems) {
                if (!is_array($transactionItems)) $transactionItems = array($transactionItems);
                foreach ($transactionItems as $transactionItem) {
                  $transaction = $genericDAO->selectAll("Transaction", "id = {$transactionItem->get('id_transaction')}");
                  if ($transaction && $transaction->get('status') == $statusId) $productCount[$product->get('id')] += 1;
                }
              }
        ?>
              <li class="<?=$divisor?> fleft">
                <p class="title center upper thin"><?=$product->get('description')?>&nbsp;<strong>R$ <?=$product->get('price')?></strong></p>
                <p class="number center light"><?=$productCount[$product->get('id')]?></p>
              </li>
        <?php
            }
          }
        ?>
        </ul>
      <?php endforeach; ?>




    </section>
  </main>
<?php Structure::footer(); ?>
