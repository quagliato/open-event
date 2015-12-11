<?php
    $user = Structure::verifySession();
    Structure::header();

    $genericDAO = new GenericDAO;
    $valorPossivelDAO = new ValorPossivelDAO;
?>
        <main>
            <header class="center">
                <h1>Valores Possíveis</h1>
            </header>
            <section class="wrapper">
            <?php
                $valoresPossiveis = $genericDAO->selectAll("ValorPossivel", NULL);
                if ($valoresPossiveis) :
                    if (!is_array($valoresPossiveis)) :
                        $valoresPossiveis = array($valoresPossiveis);
                    endif;
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                    <a href="<?=APP_URL?>/admin/valor-possivel" class="submit positive">Adicionar novo</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td style="width:5%; text-align:center;">ID</td>
                        <td style="width:48%; text-align:left;">Edital/Pergunta</td>
                        <td style="width:15%; text-align:left;">Valor</td>
                        <td style="width:15%; text-align:left;">Etiqueta</td>
                        <td style="width:8%; text-align:center;">Editar</td>
                        <td style="width:8%; text-align:center;">Excluir</td>
                    </thead>
                    <?php
                        $count = 0;
                        $lastPerguntaId = false;
                        $editalPergunta = false;
                        foreach ($valoresPossiveis as $valorPossivel) :
                            if ($lastPerguntaId != $valorPossivel->get('id_pergunta')) {
                                $lastPerguntaId = $valorPossivel->get('id_pergunta');
                                $editalPergunta = $valorPossivelDAO->getEditalPergunta($valorPossivel->get('id'));
                            }
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td style="text-align:center;"><?=$valorPossivel->get('id')?></td>
                            <td style="text-align:left;"><?=$editalPergunta?></td>
                            <td style="text-align:left;"><?=$valorPossivel->get('valor')?></td>
                            <td style="text-align:left;"><?=$valorPossivel->get('label')?></td>
                            <td style="text-align:center;"><a href="<?=APP_URL?>/admin/valor-possivel?id=<?=$valorPossivel->get('id')?>">Editar</a></td>
                            <td style="text-align:center;"><a class="post" id="<?=$valorPossivel->get('id')?>" href="<?=APP_URL?>/admin/valor-possivel/action/delete">Excluir</a></td>
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