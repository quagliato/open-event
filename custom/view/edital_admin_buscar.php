<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;
?>
        <main>
            <header class="center">
                <h1>Buscar Respostas de Editais</h1>
            </header>
            <section class="wrapper center">
                <form method="GET" action="<?=APP_URL?>/admin/edital/buscar/action">

                    <div class="input_line center">
                        <div class="input_container third fnone">
                            <h2>Por e-mail</h2>
                            <label for="email">E-mail</label>
                            <input name="email" type="text" id="email">
                        </div>
                        <div class="input_container third fnone">
                            <h2>Por ID do Usuário</h2>
                            <label for="id_user">ID do Usuário</label>
                            <input name="id_user" type="text" id="id_user">
                        </div>
                    </div>

                    <div class="input_line center">
                        <div class="input_container third fnone">
                            <h2>Por status</h2>
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="PRE">Pré-selecionado</option>
                                <option value="NEG">Negado</option>
                                <option value="SEL">Selecionado</option>
                            </select>
                        </div>
                        <div class="input_container third fnone">
                            <h2>Por edital</h2>
                            <label for="edital">Edital</label>
                            <select name="edital" id="edital">
                                <option value="">Selecione um edital</option>
                                <?php
                                    $editais = $genericDAO->selectAll("Edital", NULL);
                                    if ($editais) :
                                        if (!is_array($editais)) :
                                            $editais = array($editais);
                                        endif;
                                        foreach ($editais as $edital) :
                                            echo '<option value="'.$edital->get('id').'">'.$edital->get('nome').'</option>';
                                        endforeach;
                                    endif;
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="buscar" value="Buscar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
