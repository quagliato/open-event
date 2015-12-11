<?php
    $user = Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Isenções</h1>
            </header>
            <section class="wrapper">
            <?php
                $exemptions = $genericDAO->selectAll("Exemption", NULL);
                if ($exemptions) :
                    if (!is_array($exemptions)) $exemptions = array($exemptions);
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                    <a href="<?=APP_URL?>/admin/exemption" class="submit positive">Adicionar novo</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td style="width:5%; text-align:center;">ID</td>
                        <td style="width:32%; text-align:left;">Edital</td>
                        <td style="width:31%; text-align:left;">Produto</td>
                        <td style="width:15%; text-align:left;">Modificador</td>
                        <td style="width:8%; text-align:center;">Editar</td>
                        <td style="width:8%; text-align:center;">Excluir</td>
                    </thead>
                    <?php
                        $count = 0;
                        foreach ($exemptions as $exemption) :
                            $edital = $genericDAO->selectAll("Edital", "id = ".$exemption->get('id_edital'));
                            $product = $genericDAO->selectAll("Product", "id = ".$exemption->get('id_product'));
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td style="text-align:center;"><?=$exemption->get('id')?></td>
                            <td style="text-align:left;"><?=$edital->get('nome')?></td>
                            <td style="text-align:left;"><?=$product->get('description')?></td>
                            <td style="text-align:left;"><?=$exemption->get('modifier')?></td>
                            <td style="text-align:center;"><a href="<?=APP_URL?>/admin/exemption?id=<?=$exemption->get('id')?>">Editar</a></td>
                            <td style="text-align:center;"><a class="post" id="<?=$exemption->get('id')?>" href="<?=APP_URL?>/admin/exemption/action/delete">Excluir</a></td>
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