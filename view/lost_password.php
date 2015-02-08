<?php
    Structure::header();
?>
        <main>
            <header class="center">
                <h1>Restaurar Senha</h1>
            </header>
            <section class="wrapper center">
                <form method="POST" action="<?=APP_URL?>/request" class="new_submit">
                    <div class="input_line">
                        <div class="input_container half fnone">
                            <label for="email">E-mail</label>
                            <input id="email" type="email" name="email" placeholder="usuario@servidor.tld" required>
                        </div>
                    </div>

                    <div class="input_line center submit_line">
                        <input type="submit" name="cancelar" value="Cancelar" class="cancel negative">
                        <input type="submit" name="restaurar" value="Restaurar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
