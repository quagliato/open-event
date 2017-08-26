<?php
    $user = Structure::verifySession("/edital", $_GET, true);
    Structure::header();

    $genericDAO = new GenericDAO;
    $editalDAO = new EditalDAO;
    $respostaEditalDAO = new respostaEditalDAO;

    $editalUser = false;
    $respostaEdital = false;
    $idEdital = false;
    if (array_key_exists('idRespostaEdital', $_GET) && $user->get('role') == 'ADM') {
        $respostaEdital = $genericDAO->selectAll('RespostaEdital', 'id = '.$_GET['idRespostaEdital']);
        if ($respostaEdital) {
            $editalUser = $genericDAO->selectAll('User', 'id = '.$respostaEdital->get('id_user'));
            $idEdital = $respostaEdital->get('id_edital');
        }
    } else if (array_key_exists('id', $_GET)) {
        $idEdital = $_GET['id'];
    }

    $edital = $genericDAO->selectAll("Edital", "id = $idEdital");

    if ($user->get('role') !== 'ADM' && (!$respostaEdital && (!$edital || !$editalDAO->getOpenEdital($idEdital)))) {
        Structure::redirWithMessage("O edital requisitado não existe ou está fechado.", "/dashboard");
    }

?>
        <main>
            <header class="center">
                <h1 class="edital"><?=$edital->get('nome')?></h1>

                <div id="edital_info">
                    <?php if (!$respostaEdital) : ?>

                    <p><?=$edital->get('desc_completa')?></p>

                    <?php else : ?>

                    <div class="left">
                        <p><strong>Nome: </strong><?=$editalUser->get('nome')?></p>
                        <p><strong>Cidade/UF: </strong><?=$editalUser->get('end_cidade')?> / <?=$editalUser->get('end_estado')?></p>
                        <p><strong>Ensino: </strong><?=$editalUser->get('inst_ens')?> / <?=$editalUser->get('curso')?> - Período: <?=$editalUser->get('periodo')?></p>
                        <p><strong>E-mail: </strong><?=$editalUser->get('email')?></p>
                        <p><strong>Facebook: </strong><?=$editalUser->get('facebook')?></p>
                        <p><strong>Telefone Residencial: </strong><?=$editalUser->get('telefone_residencial')?></p>
                        <p><strong>Telefone Celular: </strong><?=$editalUser->get('telefone_celular')?></p>
                        <p><strong>Deficiência: </strong><?=strlen($editalUser->get('deficiencia')) == 0 ? "Nenhuma" : $editalUser->get('deficiencia')?></p>
                        <p><strong>Alergia: </strong><?=strlen($editalUser->get('alergias')) == 0 ? "Nenhuma" : $editalUser->get('alergias')?></p>
                    </div>

                    <?php endif; ?>
                    <div class="metric_info">

                        <!-- <span class="fleft left">
                            <i class="fa fa-play"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_abertura'))?>&nbsp;&nbsp;&nbsp;
                            <i class="fa fa-stop"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_fechamento'))?>
                        </span> -->

                        <span class="fleft left">

                            <!-- <i class="fa fa-check f-positive"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_abertura'))?>&nbsp;&nbsp;&nbsp; -->
                            <!-- <i class="fa fa-times f-negative"></i>&nbsp;<?=Utils::sqlTimestamp2BrFormat($edital->get('dt_fechamento'))?> -->

                            <?php if (!$respostaEdital) : ?>

                            <strong>Fechamento deste edital:</strong> <?=Utils::sqlTimestamp2BrFormat($edital->get('dt_fechamento'))?>

                            <?php else : ?>

                            <strong>Início da Resposta:</strong> <?=Utils::sqlTimestamp2BrFormat($respostaEdital->get('dt_inicio_resposta'))?>&nbsp;&nbsp;
                            <strong>Fim da Resposta:</strong> <?=Utils::sqlTimestamp2BrFormat($respostaEdital->get('dt_inicio_resposta'))?>

                            <?php endif; ?>
                        </span>

                        <?php if (!$respostaEdital) : ?>
                        <?php $averageTime = $respostaEditalDAO->getAverageTime($edital->get('id')); ?>
                        <span class="fright right"><i class="fa fa-clock-o"></i> <?=$averageTime == 0 ? $edital->get('tempo_preenchimento') : $averageTime?> minuto(s)</span>
                        <?php endif; ?>
                    </div>
                </div>

            </header>
            <section class="wrapper center">
                <form method="POST" action="<?=APP_URL?>/edital/action" class="new_submit needs-confirmation" data-confirm-msg="Você realmente terminou de preencher esse edital? Se sim, pressione OK.">

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

                            $respostaPergunta = false;
                            if ($respostaEdital) {
                                $respostaPergunta = $genericDAO->selectAll('RespostaPergunta', 'id_resposta_edital = '.$respostaEdital->get('id').' AND id_pergunta = '.$pergunta->get('id'));
                            }

                            if (!$respostaPergunta || is_array($respostaPergunta) || sizeof($respostaPergunta) == 0) {
                                $respostaPergunta = false;
                            }

                            ?>

                            <label for="<?=$id?>"><?=$pergunta->get('titulo')?> <?=$descricao ? "<em>($descricao)</em>" : ""?></label>
                            <?php $tamanhoResposta = $pergunta->get('tamanho_resposta'); ?>
                            <?php if ($tipoResposta == "text") : ?>
                                <input required name="<?=$name?>" type="text" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="'.$tamanhoResposta.'" ' : ''?>placeholder="<?=$pergunta->get('exemplo')?>"<?=$respostaPergunta ? ' disabled value="'.$respostaPergunta->get('vl_resposta').'"' : ''?>>

                            <?php elseif ($tipoResposta == "textarea-s") : ?>
                                <textarea required name="<?=$name?>" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="'.$tamanhoResposta.'" ' : ''?> placeholder="<?=$pergunta->get('exemplo')?>" class="s" <?=$respostaPergunta ? 'disabled' : ''?>><?=$respostaPergunta ? $respostaPergunta->get('vl_resposta') : ''?></textarea>

                            <?php elseif ($tipoResposta == "textarea-m") : ?>
                                <textarea required name="<?=$name?>" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="'.$tamanhoResposta.'" ' : ''?> placeholder="<?=$pergunta->get('exemplo')?>" class="m" <?=$respostaPergunta ? 'disabled' : ''?>><?=$respostaPergunta ? $respostaPergunta->get('vl_resposta') : ''?></textarea>

                            <?php elseif ($tipoResposta == "textarea-l") : ?>
                                <textarea required name="<?=$name?>" id="<?=$id?>" <?=$tamanhoResposta && $tamanhoResposta > 0 ? 'maxlength="$'.$tamanhoResposta.'" ' : ''?> placeholder="<?=$pergunta->get('exemplo')?>" class="l" <?=$respostaPergunta ? 'disabled' : ''?>><?=$respostaPergunta ? $respostaPergunta->get('vl_resposta') : ''?></textarea>

                            <?php elseif ($tipoResposta == "number") : ?>
                                <input required name="<?=$name?>" type="number" id="<?=$id?>" placeholder="<?=$pergunta->get('exemplo')?>"<?=$respostaPergunta ? ' disabled value="'.$respostaPergunta->get('vl_resposta').'"' : ''?>>

                            <?php elseif ($tipoResposta == "datepicker") : ?>
                                <input name="<?=$name?>" type="text" id="<?=$id?>" placeholder="<?=$pergunta->get('exemplo')?>" class="datepicker date"<?=$respostaPergunta ? ' disabled value="'.Utils::sqlDate2SimpleDate($respostaPergunta->get('vl_resposta')).'"' : ''?>>

                            <?php elseif ($tipoResposta == "datetimepicker") : ?>
                                <input name="<?=$name?>" type="text" id="<?=$id?>" placeholder="<?=$pergunta->get('exemplo')?>" class="datetimepicker"<?=$respostaPergunta ? ' disabled value="'.Utils::sqlTimestamp2BrFormat($respostaPergunta->get('vl_resposta')).'"' : ''?>>

                            <?php elseif ($tipoResposta == "select") : ?>
                                <select name="<?=$name?>" id="<?=$id?>">
                                <?php
                                    $valorPossivelDAO = new ValorPossivelDAO;
                                    $valoresPossiveis = $valorPossivelDAO->getValorPossivelByPergunta($pergunta->get('id'));
                                    foreach ($valoresPossiveis as $valorPossivel) :
                                ?>
                                    <option value="<?=$valorPossivel->get('valor')?>"<?=$respostaPergunta && $respostaPergunta->get('vl_resposta') == $valorPossivel->get('valor') ? ' selected' : ''?>><?=$valorPossivel->get('label')?></option>
                                <?php
                                    endforeach;
                                ?>
                                </select>

                            <?php elseif ($tipoResposta == "checkbox") : ?>
                                <ul class="checkbox">
                                <?php
                                    $valorPossivelDAO = new ValorPossivelDAO;
                                    $valoresPossiveis = $valorPossivelDAO->getValorPossivelByPergunta($pergunta->get('id'));
                                    if ($valoresPossiveis && !is_array($valoresPossiveis)) $valoresPossiveis = array($valoresPossiveis);
                                    foreach ($valoresPossiveis as $valorPossivel) :
                                        $checked = false;
                                        if ($respostaPergunta) {
                                            if (!is_array($respostaPergunta)) {
                                                $respostaPergunta = array($respostaPergunta);
                                            }

                                            foreach ($respostaPergunta as $respostaPergunta) {
                                                if ($respostaPergunta->get('vl_resposta') == $valorPossivel->get('valor')) {
                                                    $checked = true;
                                                }
                                            }
                                        }

                                ?>

                                    <li><input type="checkbox" id="valor<?=$valorPossivel->get('id')?>" name="<?=$name?>" value="<?=$valorPossivel->get('valor')?>"<?=$checked ? ' checked' : ''?>><label for="valor<?=$valorPossivel->get('id')?>"><?=$valorPossivel->get('label')?></label></li>
                                <?php
                                    endforeach;
                                ?>
                            <?php elseif ($tipoResposta == "slider") : ?>
                                <?php if ($respostaPergunta) : ?>
                                    <p><strong>Resposta:</strong> <?=$respostaPergunta->get('vl_resposta')?></p>
                                <?php else : ?>
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
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                    endforeach;
                ?>
                    <?php if (!$respostaEdital) : ?>
                    <div class="input_line submit_line center">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="Enviar" value="Enviar" class="positive">
                    </div>
                    <?php endif; ?>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
