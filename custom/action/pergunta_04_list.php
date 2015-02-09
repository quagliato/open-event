<?php
    $usuario = Structure::verifySession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Perguntas</h1>
            </header>
            <section class="wrapper">
            <?php
                $perguntas = $genericDAO->selectAll("Pergunta", NULL);
                if ($perguntas) :
                    if (!is_array($perguntas)) :
                        $perguntas = array($perguntas);
                    endif;
            ?>
                <div class="input_line submit_line right">
                    <a href="#" class="submit negative cancel">Voltar</a>
                    <a href="<?=APP_URL?>/admin/pergunta" class="submit positive">Adicionar nova</a>
                </div>
                <table style="font-size:12px;" class="jquerydatatable">
                    <thead>
                        <td style="width:5%; text-align:center;">ID</td>
                        <td style="width:20%; text-align:left;">Edital</td>
                        <td style="width:40%; text-align:left;">Pergunta</td>
                        <td style="width:19%; text-align:left;">Tipo de Resposta</td>
                        <td style="width:8%; text-align:center;">Editar</td>
                        <td style="width:8%; text-align:center;">Excluir</td>
                    </thead>
                    <?php
                        $count = 0;
                        foreach ($perguntas as $pergunta) :
                            $edital = $genericDAO->selectAll("Edital", "id = ".$pergunta->get('id_edital'));
                    ?>
                        <tr <?php if ($count % 2 == 0) { echo 'style="background-color: #CCCCCC;"'; } ?>>
                            <td style="text-align:center;"><?=$pergunta->get('id')?></td>
                            <td style="text-align:left;"><?=$edital->get('nome')?></td>
                            <td style="text-align:left;"><?=$pergunta->get('titulo')?></td>
                            <td style="text-align:left;"><?=$pergunta->get('tipo_resposta')?></td>
                            <td style="text-align:center;"><a href="<?=APP_URL?>/admin/pergunta?id=<?=$pergunta->get('id')?>">Editar</a></td>
                            <td style="text-align:center;"><a class="post" id="<?=$pergunta->get('id')?>" href="<?=APP_URL?>/admin/pergunta/action/delete">Excluir</a></td>
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