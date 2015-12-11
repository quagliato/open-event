<?php
    $user = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Pacotes Excludentes</h1>
            </header>
            <section class="wrapper">
            <?php
                $productExcludes = $genericDAO->selectAll("ProductExclude", NULL);
                if ($productExcludes) :
                    if (!is_array($productExcludes)) $productExcludes = array($productExcludes);
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                    <a href="<?=APP_URL?>/admin/product-exclude" class="submit positive">Adicionar novo</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td style="width:5%; text-align:center;">ID</td>
                        <td style="width:40%; text-align:left;">Pacote 1</td>
                        <td style="width:38%; text-align:left;">Pacote 2</td>
                        <td style="width:8%; text-align:center;">Editar</td>
                        <td style="width:8%; text-align:center;">Excluir</td>
                    </thead>
                    <?php
                        $count = 0;
                        foreach ($productExcludes as $productExclude) :
                            $product1 = $genericDAO->selectAll("Product", "id = ".$productExclude->get('id_product1'));
                            $product2 = $genericDAO->selectAll("Product", "id = ".$productExclude->get('id_product2'));
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td style="text-align:center;"><?=$productExclude->get('id')?></td>
                            <td style="text-align:left;"><?=$product1->get('description')?></td>
                            <td style="text-align:left;"><?=$product2->get('description')?></td>
                            <td style="text-align:center;"><a href="<?=APP_URL?>/admin/product-exclude?id=<?=$productExclude->get('id')?>">Editar</a></td>
                            <td style="text-align:center;"><a class="post" id="<?=$productExclude->get('id')?>" href="<?=APP_URL?>/admin/product-exclude/action/delete">Excluir</a></td>
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