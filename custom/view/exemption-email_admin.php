<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $status = "INSERTING";
    $action = APP_URL."/admin/exemption-email/action/insert";
    $obj = null;

    if (array_key_exists("id", $_GET)) {
        $status = "UPDATING";
        $action = APP_URL."/admin/exemption-email/action/update";

        $id = $_GET['id'];
        $obj = $genericDAO->selectAll("ExemptionEmail", "id = $id");
        if (!$obj) {
            // error
        }
    }
?>
        <main>
            <header class="center">
                <h1>Isenção por E-mail > Cadastrar</h1>
            </header>
            <section class="wrapper ">
                <?php if (!$genericDAO->selectAll("Edital", NULL)) : ?>
                    <h2 class="center">Você não pode cadastrar isenções pois não existem editais criadas.</h2>
                    <div class="input_line submit_line center">
                        <a href="#" class="submit negative cancel">Voltar</a>
                    </div>
                <?php else : ?>
                <form method="POST" action="<?=$action?>" class="new_submit">

                    <?php if ($status == "UPDATING") : ?>
                        <input type="hidden" name="ExemptionEmail-id" value="<?=$obj->get('id')?>">
                    <?php endif; ?>

                    <div class="input_line">
                        <div class="input_container third">
                            <label for="email">E-mail</label>
                            <input type="text" name="ExemptionEmail-email" id="email">
                        </div>

                        <div class="input_container third">
                            <label for="id_product">Produto</label>
                            <select name="ExemptionEmail-id_product" id="id_product">
                            <?php
                            $products = $genericDAO->selectAll("Product", NULL);
                            if ($products) :
                                if (!is_array($products)) $products = array($products);
                                foreach ($products as $product) :
                            ?>
                                <option value="<?=$product->get('id')?>"<?=$status == "UPDATING" && $product->get('id') == $obj->get('id_product') ? ' selected' : ''?>><?=$product->get('id')?> - <?=$product->get('description')?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                            </select>
                        </div>

                        <div class="input_container third last">
                            <label for="modifier">Modificador <em>(0.01 a 1)</em></label>
                            <input type="text" name="ExemptionEmail-modifier" id="modifier"<?=$status == "UPDATING" ? ' value="'.$obj->get('modifier').'"' : ''?>>
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
