<?php
    $urlpatterns = array(
        "/" => "index.php",
        "/404" => "theme/404.php",
        "/login" => "action/login.php",
        "/logout" => "action/logout.php",

        "/admin/blacklist/cadastrar" => "view/blacklist_cadastrar.php",
        "/admin/blacklist/editar" => "view/blacklist_editar.php",
        "/admin/blacklist/listar" => "view/blacklist_listar.php",
        "/admin/action/blacklist/cadastrar" => "action/blacklist_cadastrar.php",
        "/admin/action/blacklist/editar" => "action/blacklist_editar.php",
        "/admin/action/blacklist/excluir" => "action/blacklist_excluir.php",

        "/arquivo/enviar" => "view/arquivo_enviar.php",
        "/arquivo/listar" => "view/arquivo_listar.php",
        "/usuario/cadastrar" => "view/usuario_cadastrar.php",
        "/usuario/atualizar" => "view/usuario_atualizar.php",

        "/action/arquivo/enviar" => "action/arquivo_enviar.php",
        "/action/usuario/cadastrar" => "action/usuario_cadastrar.php",
        "/action/usuario/atualizar" => "action/usuario_atualizar.php",

        "/dashboard" => "view/dashboard.php",

        "/lost_password" => "view/lost_password.php",
        "/request" => "action/request.php",
        "/restore" => "view/restore.php",
        "/reset_password" => "action/reset_password.php"
    );
?>
