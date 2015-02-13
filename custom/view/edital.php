<?php
    Structure::verifySession("/edital", $_GET, true);
    Structure::header();

    $genericDAO = new GenericDAO;
    $editalDAO = new EditalDAO;

    $idEdital = $_GET['id'];
    $edital = $genericDAO->selectAll("Edital", "id = $idEdital");

    if (!$edital && !$editalDAO->getOpenEdital($idEdital)) :
        Structure::redir("/dashboard");
    endif;

?>
        <main>
            <header class="center">
                <h1 class="edital"><?=$edital->get('nome')?></h1>
                
                <div id="edital_info">
                    <p><?=$edital->get('desc_completa')?></p>
                    <div class="metric_info">
                        <!-- <span class="fleft left">
                            <i class="fa fa-play"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_abertura'))?>&nbsp;&nbsp;&nbsp;
                            <i class="fa fa-stop"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_fechamento'))?>
                        </span> -->
                        <span class="fleft left">
                            <!-- <i class="fa fa-check f-positive"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_abertura'))?>&nbsp;&nbsp;&nbsp; -->
                            <!-- <i class="fa fa-times f-negative"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_fechamento'))?> -->
                            <strong>Fechamento deste edital:</strong> <?=Utils::sqlTimestamp2BrFormat($edital->get('dt_fechamento'))?>
                        </span>
                        <span class="fright right"><i class="fa fa-clock-o"></i> <?=$edital->get('tempo_preenchimento')?> minuto(s)</span>
                    </div>
                </div>
                
            </header>
            <section class="wrapper center">
                <form method="POST" action="<?=APP_URL?>/edital/action" class="new_submit">

                    <input type="hidden" name="edital" value="<?=$edital->get('id')?>">
                    <input type="hidden" name="dt_inicio_resposta" value="<?=date('Y-m-d H:i:s')?>">

                <?php
                    $perguntaDAO = new PerguntaDAO;
                    $perguntas = $perguntaDAO->getPerguntaByEdital($edital->get('id'));

                    foreach ($perguntas as $pergunta) :
                ?>
                    <div class="input_line edital">
                        <div class="input_container two-thirds fnone edital">
                            <?php
                            $descricao = false;
                            if (!is_null($pergunta->get('descricao')) && strlen($pergunta->get('descricao')) > 0){
                                $descricao = $pergunta->get('descricao');
                            }

                            $id = "pergunta".$pergunta->get('id');
                            $name = $pergunta->get('id');

                            $tipoResposta = $pergunta->get('tipo_resposta');

                            ?>

                            <label for="<?=$id?>"><?=$pergunta->get('titulo')?> <?=$pergunta ? "<em>($descricao)</em>" : ""?></label>
                            <?php $tamanhoResposta = $pergunta->get('tamanho_resposta'); ?>
                            <?php if ($tipoResposta == "text") : ?>
                                <input name="<?=$name?>" type="text" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="$tamanhoResposta" ' : ''?>placeholder="<?=$pergunta->get('exemplo')?>">

                            <?php elseif ($tipoResposta == "textarea-s") : ?>
                                <textarea name="<?=$name?>" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="$tamanhoResposta" ' : ''?> placeholder="<?=$pergunta->get('exemplo')?>" class="s"></textarea>

                            <?php elseif ($tipoResposta == "textarea-m") : ?>
                                <textarea name="<?=$name?>" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="$tamanhoResposta" ' : ''?> placeholder="<?=$pergunta->get('exemplo')?>" class="m"></textarea>

                            <?php elseif ($tipoResposta == "textarea-l") : ?>
                                
                                <textarea name="<?=$name?>" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="$tamanhoResposta" ' : ''?> placeholder="<?=$pergunta->get('exemplo')?>" class="l"></textarea>

                            <?php elseif ($tipoResposta == "number") : ?>
                                <input name="<?=$name?>" type="number" id="<?=$id?>" placeholder="<?=$pergunta->get('exemplo')?>">

                            <?php elseif ($tipoResposta == "datepicker") : ?>
                                <input name="<?=$name?>" type="text" id="<?=$id?>" placeholder="<?=$pergunta->get('exemplo')?>" class="datepicker date">

                            <?php elseif ($tipoResposta == "datetimepicker") : ?>
                                <input name="<?=$name?>" type="text" id="<?=$id?>" placeholder="<?=$pergunta->get('exemplo')?>" class="datetimepicker">

                            <?php elseif ($tipoResposta == "select") : ?>
                                <select name="<?=$name?>" id="<?=$id?>">
                                <?php
                                    $valorPossivelDAO = new ValorPossivelDAO;
                                    $valoresPossiveis = $valorPossivelDAO->getValorPossivelByPergunta($pergunta->get('id'));
                                    foreach ($valoresPossiveis as $valorPossivel) :
                                ?>
                                    <option value="<?=$valorPossivel->get('valor')?>"><?=$valorPossivel->get('label')?></option>
                                <?php
                                    endforeach;
                                ?>
                                </select>

                            <?php elseif ($tipoResposta == "checkbox") : ?>
                                <ul class="checkbox">
                                <?php
                                    $valorPossivelDAO = new ValorPossivelDAO;
                                    $valoresPossiveis = $valorPossivelDAO->getValorPossivelByPergunta($pergunta->get('id'));
                                    foreach ($valoresPossiveis as $valorPossivel) :
                                ?>

                                    <li><input type="checkbox" id="valor<?=$valorPossivel->get('id')?>" name="<?=$name?>" value="<?=$valorPossivel->get('valor')?>"><label for="valor<?=$valorPossivel->get('id')?>"><?=$valorPossivel->get('label')?></label></li>
                                <?php
                                    endforeach;
                                ?>
                            <?php elseif ($tipoResposta == "slider") : ?>
                                <p id="<?=$id?>text" class="fright"></p>
                                <select name="<?=$name?>" id="<?=$id?>" class="slider" style="display:none;">
                                <?php
                                    $valorPossivelDAO = new ValorPossivelDAO;
                                    $valoresPossiveis = $valorPossivelDAO->getValorPossivelByPergunta($pergunta->get('id'));
                                    foreach ($valoresPossiveis as $valorPossivel) :
                                ?>
                                    <option value="<?=$valorPossivel->get('id')?>"><?=$valorPossivel->get('label')?></option>
                                <?php
                                    endforeach;
                                ?>
                                </select>
                                 <script>
                                    $(function() {
                                        var select = $( "#<?=$id?>" );

                                        var firstOption = $(select.children("option")[0]);
                                        $('#<?=$id?>text').html(firstOption.html());

                                        var slider = $( "<div id='slider'></div>" ).insertAfter( select ).slider({
                                            min: <?=$valorPossivelDAO->getLowestValue($pergunta->get('id'))?>,
                                            max: <?=$valorPossivelDAO->getHigherValue($pergunta->get('id'))?>,
                                            range: "min",
                                            value: select[ 0 ].selectedIndex + 1,
                                            slide: function( event, ui ) {
                                                select[ 0 ].selectedIndex = ui.value - 1;
                                                
                                                var count = 0;
                                                select.children("option").each(function(){
                                                    if (count == select[0].selectedIndex) {
                                                        $('#<?=$id?>text').html($(this).html());
                                                    }
                                                    count++;
                                                });
                                            }
                                        });
                                    });
                                </script>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                    endforeach;
                ?>

                    <div class="input_line submit_line center">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="Enviar" value="Enviar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
