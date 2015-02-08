<?php
    Structure::header();
    if (!isset($_GET['code']) || is_null($_GET['code'])) {
        Structure::redirWithMessage("Nãnãninanão!", "/");
    }
?>
        <main>
            <header class="center">
                <h1>Restaurar Senha</h1>
            </header>
            <section class="wrapper center">
                <form method="POST" onsubmit="return validateRestorePassword();" action="reset_password" class="new_submit">
                    <input type="hidden" name="code" value="<?=$_GET['code']?>">

                    <div class="input_line">
                        <div class="input_container third fnone">
                            <label for="senha">Senha</label>
                            <input id="senha" type="password" name="senha" required />
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container third fnone">
                            <label for="confirmacao_senha">Confirme sua senha</label>
                            <input id="confirmacao_senha" type="password" name="confirmacao_senha" required />
                        </div>
                    </div>

                    <div class="input_line center submit_line">
                        <input type="submit" name="cancelar" value="Cancelar" href="<?=APP_URL?>" class="cancel negative">
                        <input type="submit" name="Salvar" value="Salvar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
