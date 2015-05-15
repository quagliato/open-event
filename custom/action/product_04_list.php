<?php
    $usuario = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Pacotes</h1>
            </header>
            <section class="wrapper">
            <?php
                $products = $genericDAO->selectAll("Product", NULL);
                if ($products) :
                    if (!is_array($products)) $products = array($products);
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                    <a href="<?=APP_URL?>/admin/product" class="submit positive">Adicionar novo</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td style="width:5%; text-align:center;">ID</td>
                        <td style="width:23%; text-align:left;">Descrição</td>
                        <td style="width:7%; text-align:right;">Qtde. Máxima</td>
                        <td style="width:7%; text-align:right;">Preço</td>
                        <td style="width:11%; text-align:right;">Início</td>
                        <td style="width:11%; text-align:right;">Fim</td>
                        <td style="width:8%; text-align:center;">Editar</td>
                        <td style="width:8%; text-align:center;">Excluir</td>
                    </thead>
                    <?php
                        $count = 0;
                        foreach ($products as $product) :
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td style="text-align:center;"><?=$product->get('id')?></td>
                            <td style="text-align:left;"><?=$product->get('description')?></td>
                            <td style="text-align:right;"><?=$product->get('max_quantity')?></td>
                            <td style="text-align:right;">R$ <?=$product->get('price')?></td>
                            <td style="text-align:right;"><?=$product->get('dt_begin')?></td>
                            <td style="text-align:right;"><?=$product->get('dt_end')?></td>
                            <td style="text-align:center;"><a href="<?=APP_URL?>/admin/product?id=<?=$product->get('id')?>">Editar</a></td>
                            <td style="text-align:center;"><a class="post" id="<?=$product->get('id')?>" href="<?=APP_URL?>/admin/product/action/delete">Excluir</a></td>
                        </tr>
                    <?php 
                            $count++; 
                        endforeach;
                    ?>
                </table>
            <?php else: ?>
                <h2 class="center">Nenhum registro encontrado</h2>
            <?php endif; ?>
            </section>
        </main>

<?php Structure::footer(); ?>