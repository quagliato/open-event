<?php
    $usuario = Structure::verifyAdminSession();
    Structure::header();
    if (!array_key_exists('id', $_GET)) {
        Structure::redirWithMessage("Tenho que saber qual valor editar, né?", "/valor/listar");
    }
    $blacklist_dao = new BlacklistDAO;
    $blacklist = $blacklist_dao->getBlacklistedById($_GET['id']);
?>
                <form method="POST" action="<?=APP_URL?>/admin/action/blacklist/editar" class="new_submit">
                    <h1>Blacklist > Editar e-mail</h1>

                    <input type="hidden" name="Blacklist-id" id="id" value="<?=$blacklist->get('id')?>">

                    <label for="Blacklist-user_email">E-mail</label>
                    <input name="Blacklist-user_email" type="email" id="user_email" placeholder="usuario@servidor.com" required="required" value="<?=$blacklist->get('user_email')?>">

                    <p><input type="submit" value="Salvar" /></p>
                </form>
<?php Structure::footer(); ?>
