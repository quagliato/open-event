<?php
    Structure::verifyAdminSession();
    Structure::header();

    $genericDAO = new GenericDAO;

    $status = "INSERTING";
    $action = APP_URL."/admin/product-father/action/insert";
    $obj = null;

    if (array_key_exists("id", $_GET)) {
        $status = "UPDATING";
        $action = APP_URL."/admin/product-father/action/update";

        $id = $_GET['id'];
        $obj = $genericDAO->selectAll("ProductFather", "id = $id");
        if (!$obj) {
            // error
        }
    }
?>
        <main>
            <header class="center">
                <h1>Pacote-Pai > Cadastrar</h1>
            </header>
            <section class="wrapper ">
                <form method="POST" action="<?=$action?>" class="new_submit">

                    <?php if ($status == "UPDATING") : ?>
                        <input type="hidden" name="ProductFather-id" value="<?=$obj->get('id')?>">
                    <?php endif; ?>

                    <div class="input_line">
                        <div class="input_container half fnone">
                            <label for="id_father">Pacote-Pai</label>
                            <select name="ProductExclude-id_father" id="id_father" required>
                                <?php
                                    $products = $genericDAO->get("Product", NULL);
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
                        <div class="input_container half fnone">
                            <label for="id_product">Pacote</label>
                            <select name="ProductExclude-id_product" id="id_product" required>
                                <?php
                                    $products = $genericDAO->get("Product", NULL);
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
                    </div>

                    <div class="input_line submit_line right">
                        <a href="#" class="submit negative cancel">Cancelar</a>
                        <input type="submit" name="cadastrar" value="Cadastrar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
