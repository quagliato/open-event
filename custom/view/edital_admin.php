<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $status = "INSERTING";
    $action = APP_URL."/admin/edital/action/insert";
    $obj = null;

    if (array_key_exists("id", $_GET)) {
        $status = "UPDATING";
        $action = APP_URL."/admin/edital/action/update";

        $id = $_GET['id'];
        $obj = $genericDAO->selectAll("Edital", "id = $id");
        if (!$obj) {
            // error
        }
    }
?>
        <main>
            <header class="center">
                <h1>Edital > Cadastrar</h1>
            </header>
            <section class="wrapper">
                <form method="POST" action="<?=$action?>" class="new_submit">

                    <?php if ($status == "UPDATING") : ?>
                        <input type="hidden" name="Edital-id" value="<?=$obj->get('id')?>">
                    <?php endif; ?>

                    <div class="input_line">
                        <div class="input_container half fnone">
                            <label for="nome">Nome</label>
                            <input name="Edital-nome" type="text" id="nome" required="required"<?=$status == "UPDATING" ? ' value="'.$obj->get('nome').'"' : ''?>>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container full fnone">
                            <label for="desc_resumida">Descrição Resumida</label>
                            <textarea name="Edital-desc_resumida" id="desc_resumida" required="required" class="s"><?=$status == "UPDATING" ? $obj->get('desc_resumida') : ''?></textarea>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container full fnone">
                            <label for="desc_completa">Descrição Completa</label>
                            <textarea name="Edital-desc_completa" id="desc_completa" required="required" class="m"><?=$status == "UPDATING" ? $obj->get('desc_completa') : ''?></textarea>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container fourth fnone">
                            <label for="tempo_preenchimento">Tempo de Preenchimento (minutos)</label>
                            <input name="Edital-tempo_preenchimento" type="number" id="tempo_preenchimento" required="required"<?=$status == "UPDATING" ? ' value="'.$obj->get('tempo_preenchimento').'"' : ''?>>
                        </div>

                        <div class="input_container fourth fnone">
                            <label for="dt_abertura">Data de Abertura</label>
                            <input name="Edital-dt_abertura" type="text" id="dt_abertura" required="required" class="datetimepicker"<?=$status == "UPDATING" ? ' value="'.Utils::sqlTimestamp2BrFormat($obj->get('dt_abertura')).'"' : ''?>>
                        </div>

                        <div class="input_container fourth fnone">
                            <label for="dt_fechamento">Data de Fechamento</label>
                            <input name="Edital-dt_fechamento" type="text" id="dt_fechamento" required="required" class="datetimepicker"<?=$status == "UPDATING" ? ' value="'.Utils::sqlTimestamp2BrFormat($obj->get('dt_fechamento')).'"' : ''?>>
                        </div>
                    </div>

                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="cadastrar" value="Cadastrar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
