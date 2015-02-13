<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $status = "INSERTING";
    $action = APP_URL."/admin/pergunta/action/insert";
    $obj = null;

    if (array_key_exists("id", $_GET)) {
        $status = "UPDATING";
        $action = APP_URL."/admin/pergunta/action/update";

        $id = $_GET['id'];
        $obj = $genericDAO->selectAll("Pergunta", "id = $id");
        if (!$obj) {
            // error
        }
    }
?>
        <main>
            <header class="center">
                <h1>Pergunta > Cadastrar</h1>
            </header>
            <section class="wrapper">
                <?php if (!$genericDAO->selectAll("Edital", NULL)) : ?>
                    <h2 class="center">Você não pode cadastrar perguntas pois não existem editais criados.</h2>
                    <div class="input_line submit_line center">
                        <a href="#" class="submit negative cancel">Voltar</a>
                    </div>
                <?php else : ?>
                <form method="POST" action="<?=$action?>" class="new_submit">

                    <?php if ($status == "UPDATING") : ?>
                        <input type="hidden" name="Pergunta-id" value="<?=$obj->get('id')?>">
                    <?php endif; ?>

                    <div class="input_line">
                        <div class="input_container half">
                            <label for="id_edital">Edital</label>
                            <select name="Pergunta-id_edital" id="id_edital">
                            <?php
                            $editais = $genericDAO->selectAll("Edital", NULL);
                            if ($editais) :
                                if (!is_array($editais)) :
                                    $editais = array($editais);
                                endif;

                                foreach ($editais as $edital) :
                            ?>
                                <option value="<?=$edital->get('id')?>"<?=($status == "UPDATING" && $edital->get('id') == $obj->get('id_edital')) || (array_key_exists("edital", $_GET) && $edital->get('id') == $_GET['edital'] ) ? " selected" : ""?>><?=$edital->get('id')?> - <?=$edital->get('nome')?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                            </select>
                        </div>

                        <script>
                        $('#tipo_resposta').change(function(){
                            var typesWithSize = ["text", "textarea-s", "textarea-m", "textarea-l"];

                            var selectedItem = false
                            $(this).find("option").each(function(){
                                if ($(this).is(":selected")) selectedItem = $(this);
                            });

                            if (typesWithSize.indexOf(selectedItem.attr("value")) >= 0) {
                                $("#tamanho_resposta_container").removeClass("hidden");
                                $("#exemplo_container").removeClass("hidden");
                            } else {
                                $("#tamanho_resposta_container").addClass("hidden");
                                $("#exemplo_container").addClass("hidden");
                            }
                        });
                        </script>

                        <div class="input_container third">
                            <label for="tipo_resposta">Tipo de Resposta</label>
                            <select name="Pergunta-tipo_resposta" id="tipo_resposta">
                                <?php $value = "text"; $title = "Texto - Uma linha"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "textarea-s"; $title = "Texto - Multiplas linhas (pequeno)"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "textarea-m"; $title = "Texto - Multiplas linhas (médio)"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "textarea-l"; $title = "Texto - Multiplas linhas (grande)"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "number"; $title = "Número inteiro"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "number"; $title = "Número com decimais"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "datepicker"; $title = "Data"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "datetimepicker"; $title = "Data e Hora"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "select"; $title = "Select (como esse aqui)"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "checkbox"; $title = "Checkbox"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                                <?php $value = "slider"; $title = "Slider"; ?>
                                <option value="<?=$value?>"<?=$status == "UPDATING" && $obj->get('tipo_resposta') == $value ? "selected" : ""?>><?=$title?></option>
                            </select>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container half">
                            <label for="titulo">Título da Pergunta</label>
                            <input name="Pergunta-titulo" type="text" id="titulo" required="required"<?=$status == "UPDATING" ? ' value="'.$obj->get('titulo').'"' : ''?>>
                        </div>

                        <div class="input_container half last">
                            <label for="descricao">Descrição</label>
                            <input name="Pergunta-descricao" type="text" id="descricao"<?=$status == "UPDATING" ? ' value="'.$obj->get('descricao').'"' : ''?>>
                        </div>
                    </div>

                    <div class="input_line">
                        <div id="exemplo_container" class="input_container third">
                            <label for="exemplo">Exemplo de Resposta</label>
                            <input name="Pergunta-exemplo" type="text" id="exemplo"<?=$status == "UPDATING" ? ' value="'.$obj->get('exemplo').'"' : ''?>>
                        </div>

                        <div id="tamanho_resposta_container" class="input_container third">
                            <label for="tamanho_resposta">Tamanho máximo da resposta</label>
                            <input name="Pergunta-tamanho_resposta" type="number" id="tamanho_resposta" required="required"<?=$status == "UPDATING" ? ' value="'.$obj->get('tamanho_resposta').'"' : ''?>>
                        </div>

                        <div class="input_container third last">
                            <label for="ordem_exibicao">Ordem de Exibição</label>
                            <input name="Pergunta-ordem_exibicao" type="number" id="ordem_exibicao" required="required"<?=$status == "UPDATING" ? ' value="'.$obj->get('ordem_exibicao').'"' : ''?>>
                        </div>
                    </div>

                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="cadastrar" value="Cadastrar" class="positive">
                    </div>
                </form>
                <?php endif; ?>
            </section>
        </main>
<?php Structure::footer(); ?>
