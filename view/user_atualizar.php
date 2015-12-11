<?php
    $user = Structure::verifySession();
    Structure::header();
?>
        <main>
            <header class="center">
                <h1>Usuário > Alterar Cadastro</h1>
            </header>
            <section class="wrapper center">
                <form action="<?=APP_URL?>/action/user/atualizar" method="post" class="new_submit">
                
                    <div class="input_line">
                        <div class="input_container half fnone">
                            <label for="nome">Nome completo</label>
                            <input name="User-nome" type="text" id="nome" required="required" value="<?=$user->get('nome')?>">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container half fnone">
                            <label for="email">Email</label>
                            <input name="User-email" type="email" id="email" prequired="required" max-length="100" value="<?=$user->get('email')?>">
                        </div>
                    </div>

                    <div class="input_line">
                        <div class="input_container fourth fnone">
                            <label for="senha">Senha</label>
                            <input name="User-senha" type="password" id="senha" placeholder="Senha difícil">
                        </div>

                        <div class="input_container fourth fnone">
                            <label for="confirmacao_senha">Confirmação Senha</label>
                            <input name="confirmacao_senha" type="password" id="confirmacao_senha" placeholder="Confirme sua senha" onchange="validatePassword()">
                        </div>
                        
                    </div>

                    <div class="input_line center submit_line">
                        <input type="submit" name="cancelar" value="Cancelar" href="<?=APP_URL?>" class="cancel negative">
                        <input type="submit" name="salvar" value="Salvar" class="positive">
                    </div>
                </form>
            </section>
        </main>
<?php Structure::footer(); ?>
