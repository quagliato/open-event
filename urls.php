<?php
  $urlpatterns = array(
    "/" => "view/login.php",
    "/404" => "view/404.php",
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
    "/user/cadastrar" => "view/user_cadastrar.php",
    "/user/atualizar" => "view/user_atualizar.php",

    "/action/arquivo/enviar" => "action/arquivo_enviar.php",
    "/action/user/cadastrar" => "action/user_cadastrar.php",
    "/action/user/atualizar" => "action/user_atualizar.php",

    "/dashboard" => "view/dashboard.php",

    "/lost_password" => "view/lost_password.php",
    "/request" => "action/request.php",
    "/restore" => "view/restore.php",
    "/reset_password" => "action/reset_password.php"
  );

  foreach ($custom_urlpatterns as $key => $value) {
    $urlpatterns[$key] = "custom/".$value;
  }
?>
