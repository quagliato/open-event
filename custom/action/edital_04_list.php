<?php
    $usuario = Structure::verifySession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Editais</h1>
            </header>
            <section class="wrapper">
            <?php
                $editais = $genericDAO->selectAll("Edital", NULL);
                if ($editais) :
                    if (!is_array($editais)) :
                        $editais = array($editais);
                    endif;
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                    <a href="<?=APP_URL?>/admin/edital" class="submit positive">Adicionar novo</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td style="width:5%; text-align:center;">ID</td>
                        <td style="width:40%; text-align:left;">Nome</td>
                        <td style="width:20%; text-align:left;">Data de Abertura</td>
                        <td style="width:19%; text-align:left;">Data de Fechamento</td>
                        <td style="width:8%; text-align:center;">Editar</td>
                        <td style="width:8%; text-align:center;">Excluir</td>
                    </thead>
                    <?php
                        $count = 0;
                        foreach ($editais as $edital) :
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td style="text-align:center;"><?=$edital->get('id')?></td>
                            <td style="text-align:left;"><?=$edital->get('nome')?></td>
                            <td style="text-align:left;"><?=Utils::sqlTimestamp2BrFormat($edital->get('dt_abertura'))?></td>
                            <td style="text-align:left;"><?=Utils::sqlTimestamp2BrFormat($edital->get('dt_fechamento'))?></td>
                            <td style="text-align:center;"><a href="<?=APP_URL?>/admin/edital?id=<?=$edital->get('id')?>">Editar</a></td>
                            <td style="text-align:center;"><a class="post" id="<?=$edital->get('id')?>" href="<?=APP_URL?>/admin/edital/action/delete">Excluir</a></td>
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