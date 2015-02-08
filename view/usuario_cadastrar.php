<?php
    session_start();
    if(isset($_SESSION['user_id'])) unset($_SESSION['user_id']);

    Structure::header();
?>
        <main>
            <header class="center">
                <h1>Usuário > Cadastrar</h1>
            </header>
            <section class="wrapper center">
                <form method="POST" action="<?=APP_URL?>/action/usuario/cadastrar" class="new_submit">

                    <div class="input_line">
                        <div class="input_container half fnone">
                            <label for="nome">Nome completo</label>
                            <input name="Usuario-nome" type="text" id="nome" required="required">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container half fnone">
                            <label for="email">Email</label>
                            <input name="Usuario-email" type="email" id="email" required="required" placeholder="usuario@servidor.tld">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container fourth fnone">
                            <label for="senha">Senha</label>
                            <input name="Usuario-senha" type="password" id="senha" required="required">
                        </div>
                        <div class="input_container fourth fnone">
                            <label for="confirmacao_senha">Confirmação Senha</label>
                            <input name="confirmacao_senha" type="password" id="confirmacao_senha" placeholder="Confirme sua senha" required="required" onchange="validatePassword()">
                        </div>
                    </div>

                    <div class="input_line center submit_line">
                        <input type="submit" name="cancelar" value="Cancelar" href="<?=APP_URL?>" class="cancel negative">
                        <input type="submit" name="cadastrar" value="Cadastrar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
