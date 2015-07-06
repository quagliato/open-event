<?php Structure::header('nude'); ?>
    <header>
        <div id="topline">
            <div class="wrapper">
                <div class="side" id="left">
                    <?php
                        $link = false;
                        if (isset($_SESSION['user_id']) && !is_null($_SESSION['user_id']) && "" != $_SESSION['user_id']) :
                            $link = APP_URL."/dashboard";
                        else :
                            $link = APP_URL;
                        endif;
                    ?>
                    <h1><a href="<?=$link?>"><?=APP_TITLE?></a></h1>
                </div>

                <div class="side" id="right">
                    <?php if (isset($_SESSION['user_id']) && !is_null($_SESSION['user_id']) && "" != $_SESSION['user_id']) : ?>
                    <div id="info" class="fright">
                        <?php
                            $userDAO = new UsuarioDAO;
                            $user = $userDAO->getUserById($_SESSION['user_id']);
                        ?>
                        <p><?=$user->get('email')?></p>
                        <p class="fright" style="line-height:15px; vertical-align:top;">
                            <a href="<?=APP_URL?>/usuario/atualizar">Alterar Cadastro</a>&nbsp;&nbsp;&nbsp;
                            <a href="<?=APP_URL?>/logout">Sair</a>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
