<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $status = "INSERTING";
    $action = APP_URL."/admin/product/action/insert";
    $obj = null;

    if (array_key_exists("id", $_GET)) {
        $status = "UPDATING";
        $action = APP_URL."/admin/product/action/update";

        $id = $_GET['id'];
        $obj = $genericDAO->selectAll("Product", "id = $id");
        if (!$obj) {
            // error
        }
    }
?>
        <main>
            <header class="center">
                <h1>Pacotes > Cadastrar</h1>
            </header>
            <section class="wrapper ">
                <form method="POST" action="<?=$action?>" class="new_submit">

                    <?php if ($status == "UPDATING") : ?>
                        <input type="hidden" name="Product-id" value="<?=$obj->get('id')?>">
                    <?php endif; ?>

                    <div class="input_line">
                        <div class="input_container third">
                            <label for="id_father">Produto-pai</label>
                            <select name="Product-id_father" id="id_father">
                                <option value="NULL">Sem produto pai</option>
                            <?php
                            $products = $genericDAO->selectAll("Product", NULL);
                            if ($products) :
                                if (!is_array($products)) $products = array($products);
                                foreach ($products as $product) :
                            ?>
                                <option value="<?=$product->get('id')?>"<?=$status == "UPDATING" && $product->get('id') == $obj->get('id_father') ? ' selected' : ''?>><?=$product->get('id')?> - <?=$product->get('description')?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container fourth">
                            <label for="dt_begin">Data de Início</label>
                            <input type="text" name="Product-dt_begin" id="dt_begin" class="datetimepicker"<?=$status == "UPDATING" ? ' value="'.Utils::sqlTimestamp2BrFormat($obj->get('dt_begin')).'"' : ''?>>
                        </div>

                        <div class="input_container fourth">
                            <label for="dt_begin">Data de Fim</label>
                            <input type="text" name="Product-dt_end" id="dt_end" class="datetimepicker"<?=$status == "UPDATING" ? ' value="'.Utils::sqlTimestamp2BrFormat($obj->get('dt_end')).'"' : ''?>>
                        </div>

                        <div class="input_container fourth">
                            <label for="max_quantity">Quantidade Máxima</label>
                            <input type="number" name="Product-max_quantity" id="max_quantity"<?=$status == "UPDATING" ? ' value="'.$obj->get('max_quantity').'"' : ''?>>
                        </div>

                        <div class="input_container fourth last">
                            <label for="price">Preço (R$)</label>
                            <input type="text" name="Product-price" id="price"<?=$status == "UPDATING" ? ' value="'.$obj->get('price').'"' : ''?>>
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container half">
                            <label for="description">Descrição</label>
                            <input type="text" name="Product-description" id="description"<?=$status == "UPDATING" ? ' value="'.$obj->get('description').'"' : ''?>>
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
