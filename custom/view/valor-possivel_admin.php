<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $status = "INSERTING";
    $action = APP_URL."/admin/valor-possivel/action/insert";
    $obj = null;

    if (array_key_exists("id", $_GET)) {
        $status = "UPDATING";
        $action = APP_URL."/admin/valor-possivel/action/update";

        $id = $_GET['id'];
        $obj = $genericDAO->selectAll("ValorPossivel", "id = $id");
        if (!$obj) {
            // error
        }
    }
?>
        <main>
            <header class="center">
                <h1>Valor Possível > Cadastrar</h1>
            </header>
            <section class="wrapper ">
                <?php if (!$genericDAO->selectAll("Edital", NULL)) : ?>
                    <h2 class="center">Você não pode cadastrar valores possíveis pois não existem perguntas criadas.</h2>
                    <div class="input_line submit_line center">
                        <a href="#" class="submit negative cancel">Voltar</a>
                    </div>
                <?php else : ?>
                <form method="POST" action="<?=$action?>" class="new_submit">

                    <?php if ($status == "UPDATING") : ?>
                        <input type="hidden" name="ValorPossivel-id" value="<?=$obj->get('id')?>">
                    <?php endif; ?>

                    <div class="input_line">
                        <div class="input_container two-thirds">
                            <label for="id_pergunta">Edital/Pergunta</label>
                            <select name="ValorPossivel-id_pergunta" id="id_pergunta">
                            <?php
                            $editais = $genericDAO->selectAll("Edital", NULL);
                            if ($editais) :
                                if (!is_array($editais)) :
                                    $editais = array($editais);
                                endif;

                                foreach ($editais as $edital) :
                                    $perguntaDAO = new PerguntaDAO;
                                    $perguntas = $perguntaDAO->getPerguntaByEdital($edital->get('id'));
                                    if ($perguntas) :
                                        if (!is_array($perguntas)) :
                                            $perguntas = array($perguntas);
                                        endif;

                                        foreach ($perguntas as $pergunta) :
                            ?>
                                <option value="<?=$pergunta->get('id')?>"<?=$status == "UPDATING" && $pergunta->get('id') == $obj->get('id_pergunta') ? " selected" : ""?>><?=$edital->get('id')?> - <?=$edital->get('nome')?> / <?=$pergunta->get('id')?> - <?=$pergunta->get('titulo')?></option>
                            <?php
                                        endforeach;
                                    endif;
                                endforeach;
                            endif;
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container three-fourths">
                            <label for="label">Etiqueta do Valor</label>
                            <input name="ValorPossivel-label" type="text" id="label" required="required"<?=$status == "UPDATING" ? ' value="'.$obj->get('label').'"' : ''?>>
                        </div>

                        <div class="input_container fourth last">
                            <label for="valor">Valor Real</label>
                            <input name="ValorPossivel-valor" type="text" id="valor" required="required"<?=$status == "UPDATING" ? ' value="'.$obj->get('valor').'"' : ''?>>
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
