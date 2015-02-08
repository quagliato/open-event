<?php
    $usuario = Structure::verifyAdminSession();
    Structure::header();
?>
                <form method="POST" action="<?=APP_URL?>/admin/action/blacklist/cadastrar" class="new_submit">
                    <h1>Blacklist > Cadastrar e-mail</h1>

                    <label for="Blacklist-user_email">E-mail</label>
                    <input name="Blacklist-user_email" type="email" id="user_email" placeholder="usuario@servidor.com" required="required">

                    <p><input type="submit" value="Cadastrar" /></p>
                </form>
<?php Structure::footer(); ?>
